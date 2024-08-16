@extends('components.base')
@section('title')
    - Kasir Aksesoris
@endsection
@section('stylesheet')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/adminlte/css/toastr.min.css') }}">
    <style>
        .tampil-bayar {
            font-size: 5em;
            text-align: center;
            height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
        }


        .tampil-terbilang {
            padding: 10px;
            background: #f0f0f0;
            text-align: center;
        }

        .table-penjualan tbody tr:last-child {
            display: none;
        }

        @media(max-width: 768px) {
            .tampil-bayar {
                font-size: 3em;
                height: 70px;
                padding-top: 5px;
            }
        }

        .input-group-btn button {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }
    </style>
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-sm-6">
                    <h1>Aksesoris</h1>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <section class="content">
        @include('components.kasir-aksesoris.produk')
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form class="form-produk">
                                @csrf
                                <div class="form-group row">
                                    <label for="kode_produk" class="col-lg-2 col-form-label">Kode Produk</label>
                                    <div class="col-lg-5">
                                        <div class="input-group">
                                            <input type="hidden" name="id_penjualan" id="id_penjualan" value="">
                                            <input type="hidden" name="id_produk" id="id_produk">
                                            <input type="text" class="form-control" name="kode_produk" id="kode_produk">
                                            <div class="input-group-append">
                                                <button onclick="tampilProduk()" class="btn btn-info btn-flat"
                                                    type="button">
                                                    <i class="fa fa-arrow-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive">
                                <table id="tabelKasirAksesoris"
                                    class="table table-striped table-hover table-bordered text-center">
                                    <caption>Daftar Transaksi</caption>
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode</th>
                                            <th>Nama</th>
                                            <th>Harga</th>
                                            <th>Jumlah</th>
                                            <th>Diskon</th>
                                            <th>Subtotal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>

                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="tampil-bayar bg-primary text-white"></div>
                                </div>
                                <div class="col-lg-4">
                                    <form action="" class="form-penjualan" method="post">
                                        @csrf
                                        <input type="hidden" name="id_penjualan" value="">
                                        <input type="hidden" name="total" id="total">
                                        <input type="hidden" name="total_item" id="total_item">
                                        <input type="hidden" name="bayar" id="bayar">
                                        <input type="hidden" name="id_member" id="id_member" value="">

                                        <div class="form-group row">
                                            <label for="totalrp" class="col-lg-4 col-form-label">Total</label>
                                            <div class="col-lg-8">
                                                <input type="text" id="totalrp" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="diskon" class="col-lg-4 col-form-label">Diskon</label>
                                            <div class="col-lg-8">
                                                <input type="number" name="diskon" id="diskon" class="form-control"
                                                    value="0" onfocus="clearZero(this)" onblur="restoreZero(this)"
                                                    oninput="hitungDiskon(); formatNumber(this)">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="bayar" class="col-lg-4 col-form-label">Bayar</label>
                                            <div class="col-lg-8">
                                                <input type="text" id="bayarrp" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="diterima" class="col-lg-4 col-form-label">Diterima</label>
                                            <div class="col-lg-8">
                                                <input type="number" id="diterima" class="form-control" name="diterima"
                                                    value="0" onfocus="clearZero(this)" onblur="restoreZero(this)"
                                                    oninput="hitungKembalian(); formatNumber(this)">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="kembali" class="col-lg-4 col-form-label">Kembali</label>
                                            <div class="col-lg-8">
                                                <input type="text" id="kembali" name="kembali" class="form-control"
                                                    value="0" readonly>
                                            </div>
                                        </div>
                                        <input type="hidden" id="nama_kasir" value="{{ Auth::user()->nama }}">
                                        <div class="box-footer ">
                                            <button type="submit" class=" mt-3 btn btn-info btn-sm btn-flat pull-right mr-3"
                                                id="btn-simpan"><i class="fa fa-save"></i> Simpan Transaksi</button>
                                            <button type="submit" class=" mt-3 btn btn-warning btn-sm btn-flat pull-right"
                                                id="btn-simpan-dan-cetak-nota"><i class="fa fa-print"></i> Simpan dan Cetak Nota Transaksi</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/adminlte/js/toastr.min.js') }}"></script>
    <script src="{{ asset('js/kasir-aksesoris.js') }}"></script>
@endsection
