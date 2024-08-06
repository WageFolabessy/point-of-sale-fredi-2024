<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class PengeluaranController extends Controller
{
    public function index()
    {
        $pengeluaran = Pengeluaran::orderBy('created_at', 'desc')->get();

        return DataTables::of($pengeluaran)
            ->addIndexColumn()
            ->addColumn('nominal', function ($data) {
                return format_uang($data->nominal);
            })
            ->addColumn('aksi', function ($pengeluaran) {
                return view('components.pengeluaran.tombol-aksi')->with('pengeluaran', $pengeluaran);
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

        $pengeluaran = new Pengeluaran();
        $pengeluaran->deskripsi = $request->deskripsi;
        $pengeluaran->nominal = $request->nominal;
        $pengeluaran->save();
        return response()->json(['message' => 'Pengeluaran berhasil ditambahkan.']);
    }

    public function edit($id)
    {
        $data = Pengeluaran::findOrFail($id);
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

        $pengeluaran = Pengeluaran::find($id);
        $pengeluaran->deskripsi = $request->deskripsi;
        $pengeluaran->nominal = $request->nominal;
        $pengeluaran->save();

        return response()->json(['message' => 'Pengeluaran berhasil diperbarui.']);
    }

    public function destroy($id)
    {
        $pengeluaran = Pengeluaran::find($id);
        $pengeluaran->delete();

        return response()->json([
            'message' => 'Pengeluaran berhasil dihapus'
        ]);
    }
}
