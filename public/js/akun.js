// Inisialisasi DataTable
$("#tabelAkun").DataTable({
    processing: false,
    serverSide: true,
    ajax: '/akun/datatables/',
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
    $.ajax({
        type: "POST",
        url: "/akun/tambah_akun",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            nama: $("input[name=nama]").val(),
            username: $("input[name=username]").val(),
            is_admin: $("#input_isAdmin").val(),
            password: $("input[name=password]").val(),
        },
        success: function (response) {
            $("#modal-tambah-akun").modal("hide");

            // $(".toast-body").text("Dosen berhasil ditambahkan");
            // $(".toast").toast("show");

            clearForm();
            $("#tabelAkun").DataTable().ajax.reload();
        },
        error: function (response) {
            $("#namaError").text(response.responseJSON.error.nama);
            $("#usernameError").text(response.responseJSON.error.username);
            $("#isAdminError").text(response.responseJSON.error.is_admin);
            $("#passwordError").text(response.responseJSON.error.password);
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
                // $(".toast-body").text("Dosen berhasil dihapus");
                // $(".toast").toast("show");
                $("#tabelAkun").DataTable().ajax.reload();
            },
        });
    }
});

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
