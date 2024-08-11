@extends('components.base')
@section('title')
    - Kelola Akun
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
                    @can('admin')
                        <h1>Kelola Akun</h1>
                    @endcan
                    @can('biasa')
                        <h1>Profil Saya</h1>
                    @endcan
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="toastrDefaultSuccess"></div>
        @can('admin')
            <button type="button" class="btn btn-primary mt-3 mb-3" data-toggle="modal" data-target="#modal-tambah-akun">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text"> Tambah Akun</span>
            </button>
        @endcan
        @include('components.modal-tambah-akun')
        @include('components.modal-edit-akun')
        <div class="container-fluid">
            <div class="row">
                <div class="table-responsive">
                    <table id="tabelAkun" class="table table-striped table-hover table-bordered" style="width: 100%"
                        aria-describedby="tabelAkun">
                        <caption>
                            Daftar Akun
                        </caption>
                        <thead class="text-center">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Peran</th>
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
    <script src="{{ asset('js/akun.js') }}"></script>
@endsection
