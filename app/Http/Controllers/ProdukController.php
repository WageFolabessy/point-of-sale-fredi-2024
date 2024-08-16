<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::with('kategori')->orderBy('created_at', 'desc')->get();

        return DataTables::of($produk)
            ->addIndexColumn()
            ->addColumn('select_all', function ($produk) {
                return '<input type="checkbox" name="id_produk[]" value="'. $produk->id .'">';
            })
            ->addColumn('nama_kategori', function ($produk) {
                return $produk->kategori ? $produk->kategori->nama_kategori : 'N/A';
            })
            ->addColumn('harga_beli', function ($data) {
                return format_uang($data->harga_beli);
            })
            ->addColumn('harga_jual', function ($data) {
                return format_uang($data->harga_jual);
            })
            ->addColumn('diskon', function ($data) {
                return format_uang($data->diskon);
            })
            ->addColumn('aksi', function ($produk) {
                return view('components.produk.tombol-aksi')->with('produk', $produk);
            })->rawColumns(['select_all'])
            ->make(true);
    }

    public function kategoriList()
    {
        $kategoris = Kategori::all();
        return response()->json($kategoris);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_produk' => 'required|unique:produks,nama_produk',
            'id_kategori' => 'required|exists:kategoris,id',
            'merk' => 'nullable|string',
            'harga_beli' => 'required|integer|min:0',
            'harga_jual' => 'required|integer|min:0',
            'diskon' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0',
        ], [
            'nama_produk.required' => 'Nama produk harus diisi',
            'nama_produk.unique' => 'Nama produk sudah digunakan',
            'id_kategori.required' => 'Kategori harus dipilih',
            'id_kategori.exists' => 'Kategori yang dipilih tidak valid',
            'harga_beli.required' => 'Harga beli harus diisi',
            'harga_beli.integer' => 'Harga beli harus berupa angka',
            'harga_beli.min' => 'Harga beli harus lebih besar atau sama dengan 0',
            'harga_jual.required' => 'Harga jual harus diisi',
            'harga_jual.integer' => 'Harga jual harus berupa angka',
            'harga_jual.min' => 'Harga jual harus lebih besar atau sama dengan 0',
            'diskon.required' => 'Diskon harus diisi',
            'diskon.integer' => 'Diskon harus berupa angka',
            'diskon.min' => 'Diskon harus lebih besar atau sama dengan 0',
            'stok.required' => 'Stok harus diisi',
            'stok.integer' => 'Stok harus berupa angka',
            'stok.min' => 'Stok harus lebih besar atau sama dengan 0',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $produk = new Produk();
        $produk->nama_produk = $request->nama_produk;
        $produk->id_kategori = $request->id_kategori;
        $produk->merk = $request->merk;
        $produk->harga_beli = $request->harga_beli;
        $produk->harga_jual = $request->harga_jual;
        $produk->diskon = $request->diskon;
        $produk->stok = $request->stok;
        $produk->save();
        return response()->json(['message' => 'Produk berhasil ditambahkan.']);
    }

    public function edit($id)
    {
        $data = Produk::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_produk' => 'required|unique:produks,nama_produk,' . $id,
            'id_kategori' => 'required|exists:kategoris,id',
            'merk' => 'nullable|string',
            'harga_beli' => 'required|integer|min:0',
            'harga_jual' => 'required|integer|min:0',
            'diskon' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0',
        ], [
            'nama_produk.required' => 'Nama produk harus diisi',
            'nama_produk.unique' => 'Nama produk sudah digunakan',
            'id_kategori.required' => 'Kategori harus dipilih',
            'id_kategori.exists' => 'Kategori yang dipilih tidak valid',
            'harga_beli.required' => 'Harga beli harus diisi',
            'harga_beli.integer' => 'Harga beli harus berupa angka',
            'harga_beli.min' => 'Harga beli harus lebih besar atau sama dengan 0',
            'harga_jual.required' => 'Harga jual harus diisi',
            'harga_jual.integer' => 'Harga jual harus berupa angka',
            'harga_jual.min' => 'Harga jual harus lebih besar atau sama dengan 0',
            'diskon.required' => 'Diskon harus diisi',
            'diskon.integer' => 'Diskon harus berupa angka',
            'diskon.min' => 'Diskon harus lebih besar atau sama dengan 0',
            'stok.required' => 'Stok harus diisi',
            'stok.integer' => 'Stok harus berupa angka',
            'stok.min' => 'Stok harus lebih besar atau sama dengan 0',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $produk = Produk::find($id);
        $produk->nama_produk = $request->nama_produk;
        $produk->id_kategori = $request->id_kategori;
        $produk->merk = $request->merk;
        $produk->harga_beli = $request->harga_beli;
        $produk->harga_jual = $request->harga_jual;
        $produk->diskon = $request->diskon;
        $produk->stok = $request->stok;
        $produk->save();

        return response()->json(['message' => 'Produk berhasil diperbarui.']);
    }

    public function massDelete(Request $request)
    {
        $ids = $request->ids;
        if (!empty($ids)) {
            Produk::whereIn('id', $ids)->delete();
            return response()->json(['message' => 'Data berhasil dihapus.']);
        } else {
            return response()->json(['message' => 'Tidak ada data yang dipilih untuk dihapus.'], 400);
        }
    }

    public function destroy($id)
    {
        $produk = Produk::find($id);
        $produk->delete();

        return response()->json([
            'message' => 'Produk berhasil dihapus'
        ]);
    }

    public function cetakBarcode(Request $request)
    {
        $dataproduk = Produk::whereIn('id', $request->id_produk)->get();

        $no  = 1;
        $pdf = PDF::loadView('pages.produk.barcode', compact('dataproduk', 'no'));
        $pdf->setPaper('a4', 'portrait');
        return $pdf->stream('Barcode Produk.pdf');
    }
}
