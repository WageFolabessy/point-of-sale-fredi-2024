// Inisialisasi DataTable
$("#tabelPembelian").DataTable({
    processing: false,
    serverSide: true,
    autoWidth: false,
    responsive: true,
    ajax: "/pembelian/datatables/",
    columns: [
        { data: "DT_RowIndex", name: "DT_RowIndex" },
        { data: "deskripsi", name: "deskripsi" },
        { data: "nominal", name: "nominal" },
        { data: "aksi", name: "aksi", orderable: false, searchable: false },
    ],
});

$(document).on("click", "#tambah-pembelian", function (e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: "/pembelian/tambah_pembelian",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            deskripsi: $("input[name=deskripsi]").val(),
            nominal: $("input[name=nominal]").val(),
        },
        success: function (response) {
            $("#modal-tambah-pembelian").modal("hide");

            $(".toastrDefaultSuccess", function () {
                toastr.success(response.message);
            });

            clearForm();
            $("#tabelPembelian").DataTable().ajax.reload();
        },
        error: function (response) {
            $("#deskripsiError").text(response.responseJSON.error.deskripsi);
            $("#nominalError").text(response.responseJSON.error.nominal);
        },
    });
});

$(document).on("click", "#tombol-edit", function (e) {
    let id = $(this).data("id");

    $.ajax({
        url: "/pembelian/edit_pembelian/" + id,
        type: "GET",
        success: function (response) {
            // Set data pembelian

            $("#inputDeskripsiEdit").val(response.deskripsi);
            $("#inputNominalEdit").val(response.nominal);

            // Menambahkan event handler
            $("#edit-pembelian")
                .off("click")
                .on("click", function () {
                    updatepembelian(id);
                });
        },
    });
});

$(document).on("click", "#tombol-hapus", function (e) {
    let id = $(this).data("id");

    if (confirm("Apakah Anda yakin ingin menghapus pembelian ini?")) {
        $.ajax({
            url: "/pembelian/hapus_pembelian/" + id,
            type: "DELETE",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                $(".toastrDefaultSuccess", function () {
                    toastr.success(response.message);
                });
                $("#tabelPembelian").DataTable().ajax.reload();
            },
        });
    }
});

function updatepembelian(id) {
    let data = {
        _token: $('meta[name="csrf-token"]').attr("content"),
        deskripsi: $("input[name=deskripsiEdit]").val(),
        nominal: $("input[name=nominalEdit]").val(),
    };

    $.ajax({
        url: "/pembelian/update_pembelian/" + id,
        type: "POST",
        data: data,
        success: function (response) {
            $("#modal-edit-pembelian").modal("hide");
            $("#tabelPembelian").DataTable().ajax.reload();
            $(".toast").toast("show");
            $(".toastrDefaultSuccess", function () {
                toastr.success(response.message);
            });
        },
        error: function (response) {
            clearError();
            $("#deskripsiErrorEdit").text(response.responseJSON.error.deskripsi);
            $("#nominalErrorEdit").text(response.responseJSON.error.nominal);
        },
    });
}

function clearForm() {
    $("input[name=deskripsi]").val("");
    $("input[name=nominal]").val("");
    $("input[name=deskripsiEdit]").val("");
    $("input[name=nominalEdit]").val("");

    $("#deskripsiError").text("");
    $("#nominalError").text("");
    $("#deskripsiErrorEdit").text("");
    $("#nominalErrorEdit").text("");
}

function clearError() {
    $("#deskripsiError").text("");
    $("#nominalError").text("");
    $("#deskripsiErrorEdit").text("");
    $("#nominalErrorEdit").text("");
}
