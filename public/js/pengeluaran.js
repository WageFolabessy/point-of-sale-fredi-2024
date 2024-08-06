// Inisialisasi DataTable
$("#tabelPengeluaran").DataTable({
    processing: false,
    serverSide: true,
    autoWidth: false,
    responsive: true,
    ajax: "/pengeluaran/datatables/",
    columns: [
        { data: "DT_RowIndex", name: "DT_RowIndex" },
        { data: "deskripsi", name: "deskripsi" },
        { data: "nominal", name: "nominal" },
        { data: "aksi", name: "aksi", orderable: false, searchable: false },
    ],
});

$(document).on("click", "#tambah-pengeluaran", function (e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: "/pengeluaran/tambah_pengeluaran",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            deskripsi: $("input[name=deskripsi]").val(),
            nominal: $("input[name=nominal]").val(),
        },
        success: function (response) {
            $("#modal-tambah-pengeluaran").modal("hide");

            $(".toastrDefaultSuccess", function () {
                toastr.success(response.message);
            });

            clearForm();
            $("#tabelPengeluaran").DataTable().ajax.reload();
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
        url: "/pengeluaran/edit_pengeluaran/" + id,
        type: "GET",
        success: function (response) {
            // Set data pengeluaran

            $("#inputDeskripsiEdit").val(response.deskripsi);
            $("#inputNominalEdit").val(response.nominal);

            // Menambahkan event handler
            $("#edit-pengeluaran")
                .off("click")
                .on("click", function () {
                    updatePengeluaran(id);
                });
        },
    });
});

$(document).on("click", "#tombol-hapus", function (e) {
    let id = $(this).data("id");

    if (confirm("Apakah Anda yakin ingin menghapus pengeluaran ini?")) {
        $.ajax({
            url: "/pengeluaran/hapus_pengeluaran/" + id,
            type: "DELETE",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                $(".toastrDefaultSuccess", function () {
                    toastr.success(response.message);
                });
                $("#tabelPengeluaran").DataTable().ajax.reload();
            },
        });
    }
});

function updatePengeluaran(id) {
    let data = {
        _token: $('meta[name="csrf-token"]').attr("content"),
        deskripsi: $("input[name=deskripsiEdit]").val(),
        nominal: $("input[name=nominalEdit]").val(),
    };

    $.ajax({
        url: "/pengeluaran/update_pengeluaran/" + id,
        type: "POST",
        data: data,
        success: function (response) {
            $("#modal-edit-pengeluaran").modal("hide");
            $("#tabelPengeluaran").DataTable().ajax.reload();
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
