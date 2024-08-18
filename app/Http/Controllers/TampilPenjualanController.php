<?php

namespace App\Http\Controllers;

use App\Models\DetailPenjualan;
use App\Models\Penjualan;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TampilPenjualanController extends Controller
{
    public function index()
    {
        return view('pages.penjualan');
    }

    public function penjualanDataTables()
    {
        $penjualan = Penjualan::orderBy('created_at', 'desc')->get();

        return DataTables::of($penjualan)
            ->addIndexColumn()
            ->addColumn('created_at', function ($penjualan) {
                return tanggal_indonesia($penjualan->created_at, false);
            })
            ->addColumn('waktu', function ($penjualan) {
                return Carbon::parse($penjualan->created_at)->format('H:i:s') . ' WIB';
            })
            ->addColumn('no_nota', function ($penjualan) {
                return tambah_nol_didepan($penjualan->id, 10);
            })
            ->addColumn('aksi', function ($penjualan) {
                return view('components.penjualan.tombol-aksi')->with('penjualan', $penjualan);
            })
            ->make(true);
    }

    public function getDetailPenjualan($id)
    {
        $detailPenjualan = DetailPenjualan::where('id_penjualan', $id)->with('produk')->get();

        return response()->json($detailPenjualan);
    }

    public function destroy($id)
    {
        try {
            $penjualan = Penjualan::findOrFail($id);

            // Hapus detail penjualan terkait
            DetailPenjualan::where('id_penjualan', $penjualan->id)->delete();

            // Hapus penjualan
            $penjualan->delete();

            return response()->json(['success' => true, 'message' => 'Penjualan berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus penjualan.'], 422);
        }
    }
}
