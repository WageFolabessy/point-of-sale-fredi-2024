function format_uang(number) {
    return "Rp. " + number.toLocaleString("id-ID");
}

$("#tabelPenjualan").DataTable({
    processing: false,
    serverSide: true,
    ajax: "/penjualan/datatables/",
    columns: [
        { data: "DT_RowIndex", name: "DT_RowIndex" },
        { data: "created_at", name: "created_at" },
        { data: "waktu", name: "waktu" },
        { data: "no_nota", name: "no_nota" },
        { data: "total_item", name: "total_item" },
        {
            data: "total_harga",
            name: "total_harga",
            render: function (data) {
                return format_uang(parseInt(data));
            },
        },
        {
            data: "diskon",
            name: "diskon",
            render: function (data) {
                return format_uang(parseInt(data));
            },
        },
        {
            data: "bayar",
            name: "bayar",
            render: function (data) {
                return format_uang(parseInt(data));
            },
        },
        {
            data: "diterima",
            name: "diterima",
            render: function (data) {
                return format_uang(parseInt(data));
            },
        },
        { data: "nama_kasir", name: "nama_kasir" },
        { data: "aksi", name: "aksi", orderable: false, searchable: false },
    ],
});

$(document).on("click", "#tombol-detail-penjualan", function (e) {
    e.preventDefault();

    var penjualanId = $(this).data("id");
    let counter = 1;

    $.ajax({
        url: `/penjualan/${penjualanId}/detail`,
        method: "GET",
        success: function (response) {
            // Kosongkan tbody sebelum mengisi ulang
            var tbody = $("#tabelDetailPenjualan tbody");
            tbody.empty();

            // Tambahkan data ke tabel
            response.forEach(function (detail) {
                var row = `
                    <tr>
                        <td>${counter}</td>
                        <td>${detail.produk.kode_produk}</td>
                        <td>${detail.produk.nama_produk}</td>
                        <td>${format_uang(detail.harga_jual)}</td>
                        <td>${detail.jumlah}</td>
                        <td>${format_uang(detail.diskon)}</td>
                        <td>${format_uang(detail.subtotal)}</td>
                    </tr>
                `;
                counter++;
                tbody.append(row);
            });

            // Tampilkan modal
            $("#modal-detail-penjualan").modal("show");
        },
        error: function () {
            alert("Gagal mengambil data detail penjualan.");
        },
    });
});

$(document).on('click', '#tombol-hapus', function(e) {
    e.preventDefault();

    var penjualanId = $(this).data('id');
    var url = `/penjualan/${penjualanId}`;

    if (confirm('Apakah Anda yakin ingin menghapus penjualan ini?')) {
        $.ajax({
            url: url,
            method: 'DELETE', // pastikan ini menggunakan DELETE
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    $(".toastrDefaultSuccess", function () {
                        toastr.success(response.message);
                    });
                    $('#tabelPenjualan').DataTable().ajax.reload(); // Reload tabel penjualan setelah penghapusan
                } else {
                    $(".toastrDefaultSuccess", function () {
                        toastr.success(response.message);
                    });
                }
            },
            error: function() {
                alert('Terjadi kesalahan. Silakan coba lagi.');
            }
        });

    }
});

