<?php

namespace App\Http\Controllers;

use App\Models\KasirServis;
use App\Models\KasirServisKeluhan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class KasirServisController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->get('date', Carbon::today()->toDateString());

        $data = KasirServis::whereDate('created_at', $date)
            ->orderBy('created_at', 'desc')
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('status', function ($data) {
                if ($data->status == false) {
                    return 'Belum Selesai';
                } else {
                    return 'Selesai';
                }
            })
            ->addColumn('aksi', function ($data) {
                return view('components.kasir-servis.tombol-aksi')->with('data', $data);
            })
            ->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'no_hp' => 'required',
            'jenis_hp' => 'required',
            'nomor_imei' => 'nullable',
            'status' => 'required',
        ], [
            'nama.required' => 'Nama harus diisi',
            'no_hp.required' => 'Nomor HP harus diisi',
            'jenis_hp.required' => 'jenis HP harus diisi',
            'nomor_imei.nullable' => 'nullable',
            'status.required' => 'Status harus diisi',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $data = new KasirServis;
        $data->nama = $request->nama;
        $data->no_hp = $request->no_hp;
        $data->jenis_hp = $request->jenis_hp;
        $data->nomor_imei = $request->nomor_imei;
        $data->status = $request->status;
        $data->nama_kasir = Auth::user()->nama;
        $data->save();

        if ($request->has('kerusakan')) {
            foreach ($request->kerusakan as $keluhan) {
                $newKeluhan = new KasirServisKeluhan();
                $newKeluhan->kerusakan = $keluhan['kerusakan'];
                $newKeluhan->biaya = $keluhan['biaya'];
                $newKeluhan->harga_beli = $keluhan['harga_beli'];
                $newKeluhan->harga_jual = $keluhan['harga_jual'];
                $newKeluhan->kasir_servis_id = $data->id;
                $newKeluhan->save();
            }
            return response()->json(['message' => 'Transaksi dan Kerusakan berhasil ditambahkan.']);
        }
        return response()->json(['message' => 'Transaksi berhasil ditambahkan.']);
    }

    public function edit($id)
    {
        $data = KasirServis::with('kasirServisKeluhans')->find($id);
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'no_hp' => 'required',
            'jenis_hp' => 'required',
            'nomor_imei' => 'nullable',
            'status' => 'required',
        ], [
            'nama.required' => 'Nama harus diisi',
            'no_hp.required' => 'Nomor HP harus diisi',
            'jenis_hp.required' => 'jenis HP harus diisi',
            'nomor_imei.nullable' => 'nullable',
            'status.required' => 'Status harus diisi',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $data = KasirServis::find($id);
        $data->nama = $request->nama;
        $data->no_hp = $request->no_hp;
        $data->jenis_hp = $request->jenis_hp;
        $data->nomor_imei = $request->nomor_imei;
        $data->status = $request->status;
        $data->nama_kasir = Auth::user()->nama;
        $data->save();

        KasirServisKeluhan::where('kasir_servis_id', $id)->delete();

        if ($request->has('kerusakan')) {
            foreach ($request->kerusakan as $keluhan) {
                $newKeluhan = new KasirServisKeluhan();
                $newKeluhan->kerusakan = $keluhan['kerusakan'];
                $newKeluhan->biaya = $keluhan['biaya'];
                $newKeluhan->harga_beli = $keluhan['harga_beli'];
                $newKeluhan->harga_jual = $keluhan['harga_jual'];
                $newKeluhan->kasir_servis_id = $data->id;
                $newKeluhan->save();
            }
            return response()->json(['message' => 'Transaksi dan Kerusakan berhasil diperbaharui.']);
        }

        return response()->json(['message' => 'Transaksi berhasil diperbaharui.']);
    }

    public function destroy($id)
    {
        $data = KasirServis::find($id);
        $data->delete();

        return response()->json([
            'message' => 'Transaksi berhasil dihapus'
        ]);
    }
}
