@extends('components.base')
@section('title')
    - Kelola Akun
@endsection
@section('stylesheet')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/adminlte/css/toastr.min.css') }}">
@endsection
@section('content')
    <section class="content">
        <div class="toastrDefaultSuccess"></div>
        <button type="button" class="btn btn-primary mt-3 mb-3" data-toggle="modal" data-target="#modal-tambah-akun">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text"> Tambah Akun</span>
        </button>
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
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Peran</th>
                                <th class="text-center">Aksi</th>
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
