// Inisialisasi DataTable
$("#tabelAkun").DataTable({
    processing: false,
    serverSide: true,
    ajax: "/akun/datatables/",
    columns: [
        { data: "DT_RowIndex", name: "DT_RowIndex" },
        { data: "nama", name: "nama" },
        { data: "username", name: "username" },
        { data: "is_admin", name: "is_admin" },
        { data: "aksi", name: "aksi", orderable: false, searchable: false },
    ],
});

$(document).on("click", "#tambah-akun", function (e) {
    e.preventDefault();

    let formData = new FormData();
    formData.append("_token", $('meta[name="csrf-token"]').attr("content"));
    formData.append("nama", $("input[name=nama]").val());
    formData.append("username", $("input[name=username]").val());
    formData.append("is_admin", $("#input_isAdmin").val());
    formData.append("password", $("input[name=password]").val());

    let fotoProfilInput = $("#fotoProfilInput")[0];
    if (fotoProfilInput.files.length > 0) {
        formData.append("foto_profil", fotoProfilInput.files[0]);
    }

    $.ajax({
        type: "POST",
        url: "/akun/tambah_akun",
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            $("#modal-tambah-akun").modal("hide");

            $(".toastrDefaultSuccess", function () {
                toastr.success(response.message);
            });

            clearForm();
            $("#tabelAkun").DataTable().ajax.reload();
        },
        error: function (response) {
            $("#namaError").text(response.responseJSON.error.nama);
            $("#usernameError").text(response.responseJSON.error.username);
            $("#isAdminError").text(response.responseJSON.error.is_admin);
            $("#passwordError").text(response.responseJSON.error.password);
            if (response.responseJSON.error.foto_profil) {
                $("#fotoError").text(response.responseJSON.error.foto_profil);
            }
        },
    });
});

$(document).on("click", "#tombol-hapus", function (e) {
    let id = $(this).data("id");

    if (confirm("Apakah Anda yakin ingin menghapus akun ini?")) {
        $.ajax({
            url: "/akun/hapus_akun/" + id,
            type: "DELETE",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                $(".toastrDefaultSuccess", function () {
                    toastr.success(response.message);
                });
                $("#tabelAkun").DataTable().ajax.reload();
            },
        });
    }
});

$(document).on("click", "#tombol-edit", function (e) {
    let id = $(this).data("id");

    $.ajax({
        url: "/akun/edit_akun/" + id,
        type: "GET",
        success: function (response) {
            const { nama, username, is_admin, foto_profil } = response;

            $("#inputNamaEdit").val(nama);
            $("#inputusernameEdit").val(username);
            $("#input_isAdminEdit").val(is_admin);
            if (foto_profil) {
                $("#fotoPreviewEdit")
                    .attr("src", "/images/" + foto_profil)
                    .removeClass("d-none");
            }

            $("#edit-akun")
                .off("click")
                .on("click", function () {
                    updateAkun(id);
                });
        },
    });
});

function updateAkun(id) {
    let formData = new FormData();
    formData.append("_token", $('meta[name="csrf-token"]').attr("content"));
    formData.append("nama", $("#inputNamaEdit").val());
    formData.append("username", $("#inputusernameEdit").val());
    formData.append("is_admin", $("#input_isAdminEdit").val());

    let fotoProfilInput = $("#fotoProfilInputEdit")[0];
    if (fotoProfilInput.files.length > 0) {
        formData.append("foto_profil", fotoProfilInput.files[0]);
    }

    $.ajax({
        url: "/akun/update_akun/" + id,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            $("#modal-edit-akun").modal("hide");
            $("#tabelAkun").DataTable().ajax.reload();
            $(".toast").toast("show");
            $(".toastrDefaultSuccess", function () {
                toastr.success(response.message);
            });
        },
        error: function (response) {
            clearError();
            $("#namaErrorEdit").text(response.responseJSON.error.nama);
            $("#usernameErrorEdit").text(response.responseJSON.error.username);
            $("#isAdminErrorEdit").text(response.responseJSON.error.is_admin);
            if (response.responseJSON.error.foto_profil) {
                $("#fotoErrorEdit").text(
                    response.responseJSON.error.foto_profil
                );
            }
        },
    });
}

function clearForm() {
    $("input[name=nama]").val("");
    $("input[name=username]").val("");
    let input_isAdmin = document.getElementById("input_isAdmin");
    input_isAdmin.selectedIndex = 0;
    $("input[name=password]").val("");

    $("#namaError").text("");
    $("#usernameError").text("");
    $("#isAdminError").text("");
    $("#passwordError").text("");
}

function clearError() {
    $("#namaErrorEdit").text("");
    $("#usernameErrorEdit").text("");
    $("#isAdminErrorEdit").text("");
    $("#passwordErrorEdit").text("");
}
