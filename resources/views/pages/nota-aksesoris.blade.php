<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nota Penjualan</title>
    <style>
        body {
            font-family: "Courier New", Courier, monospace;
            font-size: 12px;
            width: 90mm;
            margin: auto;
        }
        h1, h2, p, table {
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            font-size: 16px;
            margin-bottom: 10px;
        }
        h2 {
            text-align: center;
            font-size: 14px;
            margin-bottom: 10px;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .text-left {
            text-align: left;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        th, td {
            border: 0;
            padding: 5px 0;
            word-wrap: break-word;
        }
        .separator {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }
        @media print {
            @page {
                size: 90mm auto;
                margin: 0;
            }
            body {
                margin: 0;
            }
        }
    </style>
</head>
<body>
    <h1>Henx's</h1>
    <h2>ALAMAT TOKO</h2>
    <p>Tanggal: {{ date('d-m-Y') }} {{ date('H:i:s') }}</p>
    <p>No: {{ str_pad($penjualan->id, 10, '0', STR_PAD_LEFT) }}</p>
    <p>Kasir: {{ $penjualan->nama_kasir }}</p>
    <div class="separator"></div>
    <table>
        <thead>
            <tr>
                <th class="text-left">Nama</th>
                <th class="text-right">Harga</th>
                <th class="text-right">Jumlah</th>
                <th class="text-right">Diskon</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penjualan->detailPenjualans as $index => $detail)
            <tr>
                <td>{{ $detail->produk->nama_produk }}</td>
                <td class="text-right">{{ format_uang($detail->harga_jual) }}</td>
                <td class="text-right">{{ $detail->jumlah }}</td>
                <td class="text-right">{{ format_uang($detail->diskon) }}</td>
                <td class="text-right">{{ format_uang($detail->subtotal) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="separator"></div>
    <table>
        <tbody>
            <tr>
                <td class="text-left">Total Harga</td>
                <td class="text-right">{{ format_uang($penjualan->total_harga) }}</td>
            </tr>
            <tr>
                <td class="text-left">Diskon</td>
                <td class="text-right">{{ format_uang($penjualan->diskon) }}</td>
            </tr>
            <tr>
                <td class="text-left">Total Bayar</td>
                <td class="text-right">{{ format_uang($penjualan->bayar) }}</td>
            </tr>
            <tr>
                <td class="text-left">Diterima</td>
                <td class="text-right">{{ format_uang($penjualan->diterima) }}</td>
            </tr>
            <tr>
                <td class="text-left">Kembalian</td>
                <td class="text-right">{{ format_uang($penjualan->diterima - $penjualan->bayar) }}</td>
            </tr>
        </tbody>
    </table>
    <div class="separator"></div>
    <p class="text-center">-- TERIMA KASIH --</p>
</body>
</html>
