@extends('components.base')
@section('title')
    - Pengeluaran
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
                    <h1>Pengeluaran</h1>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="toastrDefaultSuccess"></div>

        <div class="d-flex justify-content-start mb-3">
            <button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#modal-tambah-pengeluaran">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text"> Tambah Pengeluaran</span>
            </button>
        </div>


        @include('components.pengeluaran.modal-tambah-pengeluaran')
        @include('components.pengeluaran.modal-edit-pengeluaran')
        <div class="container-fluid">
            <div class="row">
                <div class="table-responsive">
                    <table id="tabelPengeluaran" class="table table-striped table-hover table-bordered text-center"
                        style="width: 100%" aria-describedby="tabelPengeluaran">
                        <caption>
                            Daftar Pengeluaran
                        </caption>
                        <thead class="text-center">
                            <tr>
                                <th>No</th>
                                <th>Deskripsi</th>
                                <th>Nominal</th>
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
    <script src="{{ asset('js/pengeluaran.js') }}"></script>
@endsection
