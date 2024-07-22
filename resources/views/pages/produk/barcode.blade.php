<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Barcode</title>
    <style>
        table {
            border-collapse: separate; /* Menggunakan border-collapse: separate agar border-spacing bisa berfungsi */
            border-spacing: 10px; /* Menambahkan jarak antar sel tabel */
        }

        td {
            border: 1px solid #333;
            padding: 5px; /* Menambahkan padding dalam sel tabel */
            text-align: center;
            vertical-align: top; /* Memastikan teks di atas sel tidak menyusut ke bawah */
        }

        img {
            margin: 0 auto; /* Menyelaraskan gambar ke tengah */
            display: block; /* Menghilangkan spasi di bawah gambar */
        }
    </style>
</head>
<body>
    <table>
        <tr>
            @foreach ($dataproduk as $produk)
                <td>
                    <p>{{ $produk->nama_produk }} - {{ format_uang($produk->harga_jual) }}</p>
                    <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($produk->kode_produk, 'C39') }}"
                        alt="{{ $produk->kode_produk }}"
                        width="180"
                        height="60">
                    <br>
                    {{ $produk->kode_produk }}
                </td>
                @if ($no++ % 3 == 0)
                    </tr><tr>
                @endif
            @endforeach
        </tr>
    </table>
</body>
</html>
