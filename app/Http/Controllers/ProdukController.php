<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::with('kategori')->orderBy('created_at', 'desc')->get();

        return DataTables::of($produk)
            ->addIndexColumn()
            ->addColumn('select_all', function ($produk) {
                return '
                    <input type="checkbox" name="id[]" value="'. $produk->id .'">
                ';
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
}
