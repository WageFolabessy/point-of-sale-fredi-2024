<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class PembelianController extends Controller
{
    public function index()
    {
        $pembelian = Pembelian::orderBy('created_at', 'desc')->get();

        return DataTables::of($pembelian)
            ->addIndexColumn()
            ->addColumn('nominal', function ($data) {
                return format_uang($data->nominal);
            })
            ->addColumn('aksi', function ($pembelian) {
                return view('components.pembelian.tombol-aksi')->with('pembelian', $pembelian);
            })->rawColumns(['aksi'])
            ->make(true);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'deskripsi' => 'required',
            'nominal' => 'required|integer|min:0',
        ], [
            'deskripsi.required' => 'Pengeluaran harus diisi',
            'nominal.required' => 'Nominal harus diisi',
            'nominal.integer' => 'Nominal harus berupa angka',
            'nominal.min' => 'Nominal harus lebih besar atau sama dengan 0',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $pembelian = new Pembelian();
        $pembelian->deskripsi = $request->deskripsi;
        $pembelian->nominal = $request->nominal;
        $pembelian->save();
        return response()->json(['message' => 'Pembelian berhasil ditambahkan.']);
    }

    public function edit($id)
    {
        $data = Pembelian::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'deskripsi' => 'required',
            'nominal' => 'required|integer|min:0',
        ], [
            'deskripsi.required' => 'Pengeluaran harus diisi',
            'nominal.required' => 'Nominal harus diisi',
            'nominal.integer' => 'Nominal harus berupa angka',
            'nominal.min' => 'Nominal harus lebih besar atau sama dengan 0',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $pembelian = Pembelian::find($id);
        $pembelian->deskripsi = $request->deskripsi;
        $pembelian->nominal = $request->nominal;
        $pembelian->save();

        return response()->json(['message' => 'Pembelian berhasil diperbarui.']);
    }

    public function destroy($id)
    {
        $pembelian = Pembelian::find($id);
        $pembelian->delete();

        return response()->json([
            'message' => 'Pembelian berhasil dihapus'
        ]);
    }
}
