<?php

namespace App\Http\Controllers;

use App\Models\KasirPulsaPaket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class KasirPulsaPaketController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->get('date', Carbon::today()->toDateString());

        $data = KasirPulsaPaket::whereDate('created_at', $date)
            ->orderBy('created_at', 'desc')
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('harga_beli', function ($data) {
                return format_uang($data->harga_beli);
            })
            ->addColumn('harga_jual', function ($data) {
                return format_uang($data->harga_jual);
            })
            ->addColumn('profit', function ($data) {
                return format_uang($data->profit);
            })
            ->addColumn('aksi', function ($data) {
                return view('components.kasir-pulsa.tombol-aksi')->with('data', $data);
            })
            ->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nomor_hp' => 'required',
            'harga_beli' => 'required',
            'harga_jual' => 'required',
            'keterangan' => 'nullable',
        ], [
            'nomor_hp.required' => 'Nomor HP harus diisi',
            'harga_beli.required' => 'Harga beli harus diisi',
            'harga_jual.required' => 'Harga jual harus diisi',
            'keterangan.nullable' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $data = new KasirPulsaPaket;
        $data->nomor_hp = $request->nomor_hp;
        $data->harga_beli = $request->harga_beli;
        $data->harga_jual = $request->harga_jual;
        $data->keterangan = $request->keterangan;
        $data->nama_kasir = Auth::user()->nama;
        $data->save();
        return response()->json(['message' => 'Transaksi berhasil ditambahkan.']);
    }

    public function edit($id)
    {
        $data = KasirPulsaPaket::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nomor_hp' => 'required',
            'harga_beli' => 'required',
            'harga_jual' => 'required',
            'keterangan' => 'nullable',
        ], [
            'nomor_hp.required' => 'Nomor HP harus diisi',
            'harga_beli.required' => 'Harga beli harus diisi',
            'harga_jual.required' => 'Harga jual harus diisi',
            'keterangan.nullable' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $data = KasirPulsaPaket::find($id);
        $data->nomor_hp = $request->nomor_hp;
        $data->harga_beli = $request->harga_beli;
        $data->harga_jual = $request->harga_jual;
        $data->keterangan = $request->keterangan;
        $data->save();
        return response()->json(['message' => 'Transaksi berhasil diperbaharui.']);
    }

    public function destroy($id)
    {
        $data = KasirPulsaPaket::find($id);
        $data->delete();

        return response()->json([
            'message' => 'Transaksi berhasil dihapus'
        ]);
    }
}
