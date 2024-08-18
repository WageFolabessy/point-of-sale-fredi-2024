@extends('components.base')
@section('title')
    - Kasir Pulsa / Paket Data
@endsection
@section('stylesheet')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/adminlte/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-1">
                <div class="col-sm-6">
                    <h1>Servis</h1>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="toastrDefaultSuccess"></div>
        <h3 class="text-center" id="keteranganTanggal">Transaksi Hari Ini</h3>
        <button type="button" class="btn btn-primary mt-3 mb-3" data-toggle="modal" data-target="#modal-tambah-transaksi">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text"> Tambah Transaksi</span>
        </button>
        <button type="button" class="btn btn-info mt-3 mb-3" data-toggle="modal" data-target="#modal-periode-transaksi">
            <span class="icon text-white-50">
                <i class="fas fa-calendar"></i>
            </span>
            <span class="text"> Ubah Periode Transaksi</span>
        </button>
        @include('components.kasir-servis.modal-tambah-transaksi')
        @include('components.kasir-servis.modal-ubah-periode')
        @include('components.kasir-servis.modal-edit-transaksi')
        @include('components.kasir-servis.modal-detail-transaksi')
        <div class="container-fluid">
            <div class="row">
                <div class="table-responsive">
                    <table id="tabelKasirServis" class="table table-striped table-hover table-bordered text-center"
                        style="width: 100%" aria-describedby="tabelKasirServis">
                        <caption>
                            Daftar Transaksi
                        </caption>
                        <thead class="text-center">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>No HP</th>
                                <th>Jenis HP</th>
                                <th>Nomor Imei</th>
                                <th>Status</th>
                                <th>Kasir</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
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
    <script src="{{ asset('js/kasir-servis.js') }}"></script>
@endsection
