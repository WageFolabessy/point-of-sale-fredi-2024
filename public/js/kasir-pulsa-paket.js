// Inisialisasi DataTable
$("#tabelKasirPulsaPaket").DataTable({
    processing: false,
    serverSide: true,
    ajax: '/kasir_pulsa_paket/datatables/',
    columns: [
        { data: "DT_RowIndex", name: "DT_RowIndex" },
        { data: "nomor_hp", name: "nomor_hp" },
        { data: "harga_beli", name: "harga_beli" },
        { data: "harga_jual", name: "harga_jual" },
        { data: "profit", name: "profit" },
        { data: "keterangan", name: "keterangan" },
        { data: "nama_kasir", name: "nama_kasir" },
        { data: "aksi", name: "aksi", orderable: false, searchable: false },
    ],
});

//Date picker
$('#tanggal_transaksi').datetimepicker({
    format: 'L'
});

$(document).on("click", "#tambah-transaksi", function (e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: "/kasir_pulsa_paket/tambah_transaksi",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            nomor_hp: $("input[name=nomor_hp]").val(),
            harga_beli: $("input[name=harga_beli]").val(),
            harga_jual: $("input[name=harga_jual]").val(),
            keterangan: $("textarea[name=keterangan]").val(),
        },
        success: function (response) {
            $("#modal-tambah-transaksi").modal("hide");

            $(".toastrDefaultSuccess", function () {
                toastr.success(response.message);
            });

            clearForm();
            $("#tabelKasirPulsaPaket").DataTable().ajax.reload();
        },
        error: function (response) {
            $("#nomorHPError").text(response.responseJSON.error.nomor_hp);
            $("#hargaBeliError").text(response.responseJSON.error.harga_beli);
            $("#hargaJualError").text(response.responseJSON.error.harga_jual);
            $("#keteranganError").text(response.responseJSON.error.keterangan);
        },
    });
});

$(document).on("click", "#tombol-edit", function (e) {
    let id = $(this).data("id");

    $.ajax({
        url: "/kasir_pulsa_paket/edit_transaksi/" + id,
        type: "GET",
        success: function (response) {
            // Set data akun
            const { nomor_hp, harga_beli, harga_jual, keterangan } = response;

            $("#inputNomorHPEdit").val(nomor_hp);
            $("#inputHargaBeliEdit").val(harga_beli);
            $("#inputHargaJualEdit").val(harga_jual);
            $("#inputKeteranganEdit").val(keterangan);

            // Menambahkan event handler
            $("#edit-transaksi")
                .off("click")
                .on("click", function () {
                    updateTransaksi(id);
                });
        },
    });
});

function updateTransaksi(id) {
    let data = {
        _token: $('meta[name="csrf-token"]').attr("content"),
        nomor_hp: $("#inputNomorHPEdit").val(),
        harga_beli: $("#inputHargaBeliEdit").val(),
        harga_jual: $("#inputHargaJualEdit").val(),
        keterangan: $("#inputKeteranganEdit").val(),
    };

    $.ajax({
        url: "/kasir_pulsa_paket/update_transaksi/" + id,
        type: "POST",
        data: data,
        success: function (response) {
            $("#modal-edit-transaksi").modal("hide");

            $("#tabelKasirPulsaPaket").DataTable().ajax.reload();

            $(".toastrDefaultSuccess", function () {
                toastr.success(response.message);
            });
        },
        error: function (response) {
            clearError();
            $("#nomorHPErrorEdit").text(response.responseJSON.error.nomor_hp);
            $("#hargaBeliErrorEdit").text(response.responseJSON.error.harga_beli);
            $("#hargaJualErrorEdit").text(response.responseJSON.error.harga_jual);
            $("#keteranganErrorEdit").text(response.responseJSON.error.keterangan);
        },
    });
}

$(document).on("click", "#tombol-hapus", function (e) {
    let id = $(this).data("id");

    if (confirm("Apakah Anda yakin ingin menghapus transaksi ini?")) {
        $.ajax({
            url: "/kasir_pulsa_paket/hapus_transaksi/" + id,
            type: "DELETE",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                $(".toastrDefaultSuccess", function () {
                    toastr.success(response.message);
                });
                $("#tabelKasirPulsaPaket").DataTable().ajax.reload();
            },
        });
    }
});

function clearForm() {
    $("input[name=nomor_hp]").val("");
    $("input[name=harga_beli]").val("");
    $("input[name=harga_jual]").val("");
    $("textarea[name=keterangan]").val("");

    $("#nomorHPErrorEdit").text("");
    $("#hargaBeliErrorEdit").text("");
    $("#hargaJualErrorEdit").text("");
    $("#keteranganErrorEdit").text("");
}

function clearError() {
    $("#nomorHPErrorEdit").text("");
    $("#hargaBeliErrorEdit").text("");
    $("#hargaJualErrorEdit").text("");
    $("#keteranganErrorEdit").text("");
}
