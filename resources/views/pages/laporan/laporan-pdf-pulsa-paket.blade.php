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
    <h3 class="text-center">Laporan Pendapatan</h3>
    <h4 class="text-center">{{ tanggal_indonesia($startDate, false) }} s/d {{ tanggal_indonesia($endDate, false) }}</h4>

    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Tanggal</th>
                <th scope="col">Nomor HP</th>
                <th scope="col">Harga Beli</th>
                <th scope="col">Harga Jual</th>
                <th scope="col">Kasir</th>
                <th scope="col">Profit</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ tanggal_indonesia($item->created_at) }}</td>
                    <td>{{ $item->nomor_hp }}</td>
                    <td>{{ format_uang($item->harga_beli) }}</td>
                    <td>{{ format_uang($item->harga_jual) }}</td>
                    <td>{{ $item->nama_kasir }}</td>
                    <td>{{ format_uang($item->profit) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="6">Total Harga Beli</th>
                <th>{{ format_uang($totalHargaBeli) }}</th>
            </tr>
            <tr>
                <th colspan="6">Total Harga Jual</th>
                <th>{{ format_uang($totalHargaJual) }}</th>
            </tr>
            <tr>
                <th colspan="6">Total Profit</th>
                <th>{{ format_uang($totalProfit) }}</th>
            </tr>
        </tfoot>
    </table>
</body>

</html>
