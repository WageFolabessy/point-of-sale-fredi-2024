<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KasirPulsaPaket;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanPulsaPaket extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::today()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::today()->format('Y-m-d'));

        $data = KasirPulsaPaket::whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->orderBy('created_at', 'asc')
            ->get();

        $totalProfit = $data->sum('profit');
        $totalHargaBeli = $data->sum('harga_beli');
        $totalHargaJual = $data->sum('harga_jual');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('created_at', function ($data) {
                return tanggal_indonesia($data->created_at, false);
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
            ->make(true);
    }

    public function generatePdf($startDate, $endDate)
    {
        $data = KasirPulsaPaket::whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->orderBy('created_at', 'asc')
            ->get();

        $totalProfit = $data->sum('profit');
        $totalHargaBeli = $data->sum('harga_beli');
        $totalHargaJual = $data->sum('harga_jual');

        $pdf = PDF::loadView('pages.laporan.laporan-pdf-pulsa-paket', compact('data', 'totalProfit', 'totalHargaBeli', 'totalHargaJual', 'startDate', 'endDate'))
            ->setPaper('a4', 'landscape')
            ->setOptions(['defaultFont' => 'sans-serif']);

        return $pdf->stream('laporan_pulsa_paket dari ' . tanggal_indonesia($startDate, false) . ' s/d ' . tanggal_indonesia($endDate, false));
    }
}
