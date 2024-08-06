@extends('components.base')
@section('title')
    - Laporan Pulsa / Paket Data
@endsection
@section('stylesheet')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/adminlte/css/toastr.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-1">
                <div class="col-sm-6">
                    <h1>Laporan Pulsa / Paket Data</h1>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="toastrDefaultSuccess"></div>
        <h3 class="text-center" id="laporan"></h3>
        <h3 class="text-center" id="keteranganTanggal"></h3>
        <button type="button" class="btn btn-info mt-3 mb-3" data-toggle="modal" data-target="#modal-periode-laporan">
            <span class="icon text-white-50">
                <i class="fas fa-calendar"></i>
            </span>
            <span class="text"> Ubah Periode Laporan</span>
        </button>
        <a type="button" href="" target="_blank" class="btn btn-danger mt-3 mb-3" id="tombol-pdf"
            data-url="{{ route('pulsa_paket_pdf', ['startDate' => 'startDatePlaceholder', 'endDate' => 'endDatePlaceholder']) }}">
            <span class="icon text-white-50">
                <i class="fas fa-file-pdf"></i>
            </span>
            <span class="text"> Export PDF</span>
        </a>

        @include('components.laporan-pulsa-paket.modal-ubah-periode')
        <div class="container-fluid">
            <div class="row">
                <div class="table-responsive">
                    <table id="tabelLaporanPulsaPaket" class="table table-striped table-hover table-bordered text-center"
                        style="width: 100%" aria-describedby="tabelLaporanPulsaPaket">
                        <caption>
                            Daftar Laporan
                        </caption>
                        <thead class="text-center">
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Nomor HP</th>
                                <th>Harga Beli</th>
                                <th>Harga Jual</th>
                                <th>Kasir</th>
                                <th>Profit</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th colspan="6">Total Harga Beli</th>
                                <th id="totalHargaBeli"></th>
                            </tr>
                            <tr>
                                <th colspan="6">Total Harga Jual</th>
                                <th id="totalHargaJual"></th>
                            </tr>
                            <tr>
                                <th colspan="6">Total Profit</th>
                                <th id="totalProfit"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/adminlte/js/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('js/laporan-pulsa-paket.js') }}"></script>
@endsection
