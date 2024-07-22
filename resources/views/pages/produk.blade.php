@extends('components.base')
@section('title')
    - Produk
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
                    <h1>Produk</h1>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="toastrDefaultSuccess"></div>
        <h3 class="text-center" id="laporan"></h3>
        <h3 class="text-center" id="keteranganTanggal"></h3>

        <div class="d-flex justify-content-start mb-3">
            <button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#modal-tambah-produk">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text"> Tambah Produk</span>
            </button>
            <a type="button" href="#" class="btn btn-secondary mr-2" id="tombol-cetak-barcode" onclick="cetakBarcode('{{ route('cetakBarcode') }}')">
                <span class="icon text-white-50">
                    <i class="fas fa-barcode"></i>
                </span>
                <span class="text"> Cetak Barcode</span>
            </a>
            <form method="POST" id="delete-form" action="{{ route('hapusBanyak') }}">
                @csrf
                <button type="button" class="btn btn-danger" id="hapusBanyak">
                    <span class="icon text-white-50">
                        <i class="fas fa-trash"></i>
                    </span>
                    <span class="text"> Hapus Produk</span>
                </button>
            </form>
        </div>


        @include('components.produk.modal-tambah-produk')
        @include('components.produk.modal-edit-produk')
        <div class="container-fluid">
            <div class="row">
                <div class="table-responsive">
                    <table id="tabelProduk" class="table table-striped table-hover table-bordered text-center"
                        style="width: 100%" aria-describedby="tabelProduk">
                        <caption>
                            Daftar Produk
                        </caption>
                        <thead class="text-center">
                            <tr>
                                <th width="6%">
                                    <input type="checkbox" name="select_all" id="select_all">
                                </th>
                                <th>No</th>
                                <th>Kode Produk</th>
                                <th>Nama Produk</th>
                                <th>Nama Kategori</th>
                                <th>Merk</th>
                                <th>Harga Beli</th>
                                <th>Harga Jual</th>
                                <th>Diskon</th>
                                <th>Stok</th>
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
    <script src="{{ asset('js/produk.js') }}"></script>
@endsection
