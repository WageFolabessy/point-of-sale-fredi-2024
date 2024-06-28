@extends('components.base')
@section('title')
    - Kalkulator
@endsection
@section('stylesheet')
    <link rel="stylesheet" href="{{ asset('assets/plugins/kalkulator/kalkulator.css') }}">
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-1">
                <div class="col-sm-6">
                    <h1>Kalkulator</h1>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card calculator">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-12">
                                    <input type="text" class="form-control result" id="calculator-screen-and-result"
                                        readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3">
                                    <button class="btn btn-danger text-white" data-method="reset">C</button>
                                </div>
                                <div class="col-3">
                                    <button class="btn btn-orange text-white" id="tombol-delete">DEL</button>
                                </div>
                                <div class="col-3">
                                    <button class="btn btn-green text-white" data-constant="BRO">(</button>
                                </div>
                                <div class="col-3">
                                    <button class="btn btn-green text-white" data-constant="BRC">)</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3">
                                    <button class="btn btn-pink text-white" data-key="55">7</button>
                                </div>
                                <div class="col-3">
                                    <button class="btn btn-pink text-white" data-key="56">8</button>
                                </div>
                                <div class="col-3">
                                    <button class="btn btn-pink text-white " data-key="57">9</button>
                                </div>
                                <div class="col-3">
                                    <button class="btn btn-green text-white" data-constant="DIV">/</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3">
                                    <button class="btn btn-pink text-white" data-key="52">4</button>
                                </div>
                                <div class="col-3">
                                    <button class="btn btn-pink text-white" data-key="53">5</button>
                                </div>
                                <div class="col-3">
                                    <button class="btn btn-pink text-white" data-key="54">6</button>
                                </div>
                                <div class="col-3">
                                    <button class="btn btn-green text-white" data-constant="MULT">*</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3">
                                    <button class="btn btn-pink text-white" data-key="49">1</button>
                                </div>
                                <div class="col-3">
                                    <button class="btn btn-pink text-white" data-key="50">2</button>
                                </div>
                                <div class="col-3">
                                    <button class="btn btn-pink text-white" data-key="51">3</button>
                                </div>
                                <div class="col-3">
                                    <button class="btn btn-green text-white" data-constant="MIN">-</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3">
                                    <button class="btn btn-yellow text-white" data-key="48">0</button>
                                </div>
                                <div class="col-3">
                                    <button class="btn btn-yellow text-white" data-key="46">.</button>
                                </div>
                                <div class="col-3">
                                    <button class="btn btn-yellow text-white" data-constant="PROC">%</button>
                                </div>
                                <div class="col-3">
                                    <button class="btn btn-green text-white" data-constant="SUM">+</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button class="btn btn-primary" onclick="Calculator.calculate()">=</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mt-3">
                        <div class="card-header">History</div>
                        <div class="card-body">
                            <ol id="calc-history-list" class="list-group">
                                <!-- History items will be added here -->
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
@section('script')
    <script src="{{ asset('assets/plugins/kalkulator/kalkulator.js') }}"></script>
@endsection
