<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pendapatan</title>
    <link rel="shortcut icon" href="{{ asset('assets/plugins/adminlte/img/AdminLTELogo.png') }}" type="image/x-icon">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        .text-center {
            text-align: center;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th {
            background-color: #f2f2f2;
            text-align: center;
            padding: 8px;
        }

        .table td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        .table th[scope="col"] {
            color: black;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f9f9f9;
        }

        .table-striped tbody tr:nth-of-type(even) {
            background-color: #ffffff;
        }

        .table tfoot {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h3 class="text-center">Laporan Pendapatan Aksesoris</h3>
    <h4 class="text-center">{{ tanggal_indonesia($startDate, false) }} s/d {{ tanggal_indonesia($endDate, false) }}</h4>

    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Tanggal</th>
                <th scope="col">Kode Produk</th>
                <th scope="col">Nama Produk</th>
                <th scope="col">Harga Jual</th>
                <th scope="col">Jumlah</th>
                <th scope="col">Subtotal</th>
                <th scope="col">Keuntungan</th>
                <th scope="col">Kasir</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ tanggal_indonesia($item->created_at, false) }}</td>
                    <td>{{ $item->produk->kode_produk }}</td>
                    <td>{{ $item->produk->nama_produk }}</td>
                    <td>{{ format_uang($item->harga_jual) }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>{{ format_uang($item->subtotal) }}</td>
                    <td>{{ format_uang($item->keuntungan) }}</td>
                    <td>{{ $item->penjualan->nama_kasir }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="7">Total Subtotal</th>
                <th colspan="2">{{ format_uang($totalSubtotal) }}</th>
            </tr>
            <tr>
                <th colspan="7">Total Keuntungan</th>
                <th colspan="2">{{ format_uang($totalKeuntungan) }}</th>
            </tr>
        </tfoot>
    </table>

</body>

</html>
