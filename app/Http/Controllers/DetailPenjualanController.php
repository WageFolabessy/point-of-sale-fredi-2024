<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class DetailPenjualanController extends Controller
{
    public function index()
    {
        $produks = Produk::with('kategori')->get();
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
}
