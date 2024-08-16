<?php

namespace App\Http\Controllers;

use App\Models\DetailPenjualan;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LaporanAksesorisController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::today()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::today()->format('Y-m-d'));

        $data = DetailPenjualan::with('produk', 'penjualan')
            ->whereHas('penjualan', function ($query) use ($startDate, $endDate) {
                $query->whereDate('created_at', '>=', $startDate)
                    ->whereDate('created_at', '<=', $endDate);
            })
            ->get();

        $totalSubtotal = $data->sum('subtotal');
        $totalDiskon = $data->sum('diskon');
        $totalKeuntungan = $data->sum('keuntungan');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('created_at', function ($data) {
                return tanggal_indonesia($data->created_at, false);
            })
            ->addColumn('nama_produk', function ($data) {
                return $data->produk->nama_produk;
            })
            ->addColumn('harga_jual', function ($data) {
                return format_uang($data->harga_jual);
            })
            ->addColumn('subtotal', function ($data) {
                return format_uang($data->subtotal);
            })
            ->addColumn('diskon', function ($data) {
                return format_uang($data->diskon);
            })
            ->addColumn('keuntungan', function ($data) {
                return format_uang($data->keuntungan);
            })
            ->addColumn('nama_kasir', function ($data) {
                return $data->penjualan->nama_kasir;
            })
            ->with('totalSubtotal', format_uang($totalSubtotal))
            ->with('totalDiskon', $totalDiskon . '%')
            ->with('totalKeuntungan', format_uang($totalKeuntungan))
            ->make(true);
    }



    public function generatePdf($startDate, $endDate)
    {
        $data = DetailPenjualan::with('produk', 'penjualan')
            ->whereHas('penjualan', function ($query) use ($startDate, $endDate) {
                $query->whereDate('created_at', '>=', $startDate)
                    ->whereDate('created_at', '<=', $endDate);
            })
            ->get();

        // Hitung totalSubtotal, totalDiskon, dan totalKeuntungan
        $totalSubtotal = $data->sum('subtotal');
        $totalDiskon = $data->sum('diskon');
        $totalKeuntungan = $data->sum('keuntungan');

        $pdf = Pdf::loadView('pages.laporan.laporan-pdf-aksesoris', compact('data', 'totalSubtotal', 'totalDiskon', 'totalKeuntungan', 'startDate', 'endDate'))
            ->setPaper('a4', 'landscape')
            ->setOptions(['defaultFont' => 'sans-serif']);

        return $pdf->stream('laporan_penjualan dari ' . tanggal_indonesia($startDate, false) . ' s/d ' . tanggal_indonesia($endDate, false));
    }
}
