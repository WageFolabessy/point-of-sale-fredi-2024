<?php

namespace App\Http\Controllers;

use App\Models\DetailPenjualan;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;

class KasirAksesorisController extends Controller
{
    public function index()
    {
        $produks = Produk::with('kategori')->orderBy('created_at', 'desc')->get();
        return view('pages.kasir-aksesoris', compact('produks'));
    }

    public function addProduct(Request $request)
    {
        $product = [
            'kode' => $request->input('kode'),
            'nama' => $request->input('nama'),
            'harga' => $request->input('harga'),
            'diskon' => $request->input('diskon'),
            'jumlah' => 1,
            'subtotal' => $request->input('harga') * 1 - ($request->input('diskon') / 100) * $request->input('harga')
        ];

        return response()->json(['product' => $product]);
    }

    public function updateQuantity(Request $request)
    {
        $kode = $request->input('kode');
        $jumlah = $request->input('jumlah');
        $harga = $request->input('harga');
        $diskon = $request->input('diskon');

        $subtotal = $harga * $jumlah - ($diskon / 100) * $harga * $jumlah;

        return response()->json(['subtotal' => $subtotal]);
    }

    protected function calculateTotal($products)
    {
        $total = 0;
        foreach ($products as $product) {
            $total += $product['subtotal'];
        }
        return $total;
    }

    public function simpanTransaksi(Request $request)
    {
        try {
            // Simpan penjualan
            $penjualan = Penjualan::create([
                'total_item' => $request->total_item,
                'total_harga' => $request->total_harga,
                'diskon' => $request->diskon,
                'bayar' => $request->bayar,
                'diterima' => $request->diterima,
                'nama_kasir' => $request->nama_kasir,
            ]);

            foreach ($request->produk as $item) {
                // Mencari ID produk berdasarkan kode_produk
                $produk = Produk::where('kode_produk', $item['id'])->first();

                if (!$produk) {
                    return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan dengan kode: ' . $item['id']], 422);
                }

                DetailPenjualan::create([
                    'id_penjualan' => $penjualan->id,
                    'id_produk' => $produk->id, // Gunakan ID produk yang valid
                    'harga_jual' => $item['harga_jual'],
                    'jumlah' => $item['jumlah'],
                    'diskon' => $item['diskon'] ?? 0,
                    'subtotal' => $item['subtotal'],
                ]);

                // Update stok produk
                $produk->stok -= $item['jumlah'];
                $produk->save();
            }

            return response()->json(['success' => true, 'message' => 'Transaksi berhasil disimpan.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }
}
