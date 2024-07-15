// Inisialisasi DataTable
$("#tabelKategori").DataTable({
    processing: false,
    serverSide: true,
    ajax: '/kategori/datatables/',
    columns: [
        { data: "DT_RowIndex", name: "DT_RowIndex" },
        { data: "nama_kategori", name: "nama_kategori" },
        { data: "aksi", name: "aksi", orderable: false, searchable: false },
    ],
});

$(document).on("click", "#tambah-kategori", function (e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: "/kategori/tambah_kategori",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            nama_kategori: $("input[name=nama_kategori]").val(),
        },
        success: function (response) {
            $("#modal-tambah-kategori").modal("hide");

            $(".toastrDefaultSuccess", function () {
                toastr.success(response.message);
            });

            clearForm();
            $("#tabelKategori").DataTable().ajax.reload();
        },
        error: function (response) {
            $("#namaKategoriError").text(response.responseJSON.error.nama_kategori);
        },
    });
});

$(document).on("click", "#tombol-edit", function (e) {
    let id = $(this).data("id");

    $.ajax({
        url: "/kategori/edit_kategori/" + id,
        type: "GET",
        success: function (response) {
            // Set data akun

            $("#inputNamaKategoriEdit").val(response.nama_kategori);

            // Menambahkan event handler
            $("#edit-kategori")
                .off("click")
                .on("click", function () {
                    updateKategori(id);
                });
        },
    });
});

function updateKategori(id) {
    let data = {
        _token: $('meta[name="csrf-token"]').attr("content"),
        nama_kategori: $("#inputNamaKategoriEdit").val(),
    };

    $.ajax({
        url: "/kategori/update_kategori/" + id,
        type: "POST",
        data: data,
        success: function (response) {
            $("#modal-edit-kategori").modal("hide");
            $("#tabelKategori").DataTable().ajax.reload();
            $(".toast").toast("show");
            $(".toastrDefaultSuccess", function () {
                toastr.success(response.message);
            });
        },
        error: function (response) {
            clearError();
            $("#namaKategoriEditError").text(response.responseJSON.error.nama_kategori);
        },
    });
}

$(document).on("click", "#tombol-hapus", function (e) {
    let id = $(this).data("id");

    if (confirm("Apakah Anda yakin ingin menghapus kategori ini?")) {
        $.ajax({
            url: "/kategori/hapus_kategori/" + id,
            type: "DELETE",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                $(".toastrDefaultSuccess", function () {
                    toastr.success(response.message);
                });
                $("#tabelKategori").DataTable().ajax.reload();
            },
        });
    }
});

function clearForm() {
    $("input[name=nama_kategori]").val("");

    $("#namaKategoriError").text("");
}

function clearError() {
    $("#namaErrorEdit").text("");
}
