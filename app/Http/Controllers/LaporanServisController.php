<?php

namespace App\Http\Controllers;

use App\Models\KasirServis;
use App\Models\KasirServisKeluhan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanServisController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::today()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::today()->format('Y-m-d'));

        $data = KasirServis::with('kasirServisKeluhans')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->get()
            ->map(function ($item) {
                $item->kerusakan = $item->kasirServisKeluhans->pluck('kerusakan')->implode(', ');
                $item->biaya = $item->kasirServisKeluhans->sum('biaya');
                $item->harga_beli = $item->kasirServisKeluhans->sum('harga_beli');
                $item->harga_jual = $item->kasirServisKeluhans->sum('harga_jual');
                $item->profit = $item->kasirServisKeluhans->sum('profit');
                return $item;
            });

        $totalProfit = $data->sum('profit');
        $totalHargaBeli = $data->sum('harga_beli');
        $totalHargaJual = $data->sum('harga_jual');
        $totalBiaya = $data->sum('biaya');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('created_at', function ($data) {
                return tanggal_indonesia($data->created_at, false);
            })
            ->addColumn('biaya', function ($data) {
                return format_uang($data->biaya);
            })
            ->addColumn('harga_beli', function ($data) {
                return format_uang($data->harga_beli);
            })
            ->addColumn('harga_jual', function ($data) {
                return format_uang($data->harga_jual);
            })
            ->addColumn('profit', function ($data) {
                return format_uang($data->profit);
            })
            ->with('totalProfit', format_uang($totalProfit))
            ->with('totalHargaBeli', format_uang($totalHargaBeli))
            ->with('totalHargaJual', format_uang($totalHargaJual))
            ->with('totalBiaya', format_uang($totalBiaya))
            ->make(true);
    }


    public function generatePdf($startDate, $endDate)
    {
        $data = KasirServis::with('kasirServisKeluhans')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->get()
            ->map(function ($item) {
                $item->kerusakan = $item->kasirServisKeluhans->pluck('kerusakan')->implode(', ');
                $item->biaya = $item->kasirServisKeluhans->sum('biaya');
                $item->harga_beli = $item->kasirServisKeluhans->sum('harga_beli');
                $item->harga_jual = $item->kasirServisKeluhans->sum('harga_jual');
                $item->profit = $item->kasirServisKeluhans->sum('profit');
                return $item;
            });

        $totalProfit = $data->sum('profit');
        $totalHargaBeli = $data->sum('harga_beli');
        $totalHargaJual = $data->sum('harga_jual');
        $totalBiaya = $data->sum('biaya');

        $pdf = PDF::loadView('pages.laporan.laporan-pdf-servis', compact('data', 'totalProfit', 'totalHargaBeli', 'totalHargaJual', 'totalBiaya', 'startDate', 'endDate'))
            ->setPaper('a4', 'landscape')
            ->setOptions(['defaultFont' => 'sans-serif']);

        return $pdf->stream('laporan_servis dari ' . tanggal_indonesia($startDate, false) . ' s/d ' . tanggal_indonesia($endDate, false));
    }
}
