@extends('components.base')
@section('title')
    - Kategori
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
                    <h1>Kategori</h1>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="toastrDefaultSuccess"></div>
        <h3 class="text-center" id="laporan"></h3>
        <h3 class="text-center" id="keteranganTanggal"></h3>
        <button type="button" class="btn btn-primary mt-3 mb-3" data-toggle="modal" data-target="#modal-tambah-kategori">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text"> Tambah Kategori</span>
        </button>

        @include('components.kategori.modal-tambah-kategori')
        @include('components.kategori.modal-edit-kategori')
        <div class="container-fluid">
            <div class="row">
                <div class="table-responsive">
                    <table id="tabelKategori" class="table table-striped table-hover table-bordered text-center"
                        style="width: 100%" aria-describedby="tabelKategori">
                        <caption>
                            Daftar Kategori
                        </caption>
                        <thead class="text-center">
                            <tr>
                                <th>No</th>
                                <th>Nama Kategori</th>
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
    <script src="{{ asset('js/kategori.js') }}"></script>
@endsection
