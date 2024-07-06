@extends('components.base')
@section('title')
    - Kasir Pulsa / Paket Data
@endsection
@section('stylesheet')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/adminlte/css/toastr.min.css') }}">
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-1">
                <div class="col-sm-6">
                    <h1>Pulsa / Paket Data</h1>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="toastrDefaultSuccess"></div>
        <button type="button" class="btn btn-primary mt-3 mb-3" data-toggle="modal" data-target="#modal-tambah-transaksi">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text"> Tambah Transaksi</span>
        </button>
        @include('components.kasir-pulsa.modal-tambah-transaksi')
        @include('components.kasir-pulsa.modal-edit-transaksi')
        <div class="container-fluid">
            <div class="row">
                <div class="table-responsive">
                    <table id="tabelKasirPulsaPaket" class="table table-striped table-hover table-bordered text-center"
                        style="width: 100%" aria-describedby="tabelKasirPulsaPaket">
                        <caption>
                            Daftar Transaksi
                        </caption>
                        <thead class="text-center">
                            <tr>
                                <th>No</th>
                                <th>Nomor HP</th>
                                <th>Harga Beli</th>
                                <th>Harga Jual</th>
                                <th>Profit</th>
                                <th>Keterangan</th>
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
    <script src="{{ asset('js/kasir-pulsa-paket.js') }}"></script>
@endsection
