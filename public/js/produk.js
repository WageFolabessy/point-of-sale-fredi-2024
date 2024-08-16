// Inisialisasi DataTable
$("#tabelProduk").DataTable({
    processing: false,
    serverSide: true,
    autoWidth: false,
    responsive: true,
    ajax: "/produk/datatables/",
    columns: [
        { data: "select_all", name: "select_all", sortable: false },
        { data: "DT_RowIndex", name: "DT_RowIndex" },
        { data: "kode_produk", name: "kode_produk" },
        { data: "nama_produk", name: "nama_produk" },
        { data: "nama_kategori", name: "nama_kategori" },
        { data: "merk", name: "merk" },
        { data: "harga_beli", name: "harga_beli" },
        { data: "harga_jual", name: "harga_jual" },
        { data: "diskon", name: "diskon"},
        { data: "stok", name: "stok" },
        { data: "aksi", name: "aksi", orderable: false, searchable: false },
    ],
});

// Ambil data kategori dan isi select
$.ajax({
    url: "/produk/kategori_list/",
    type: "GET",
    success: function (data) {
        var select = $("#id_kategori");
        select.empty();
        select.append("<option selected disabled>Pilih kategori</option>");
        $.each(data, function (index, kategori) {
            select.append(
                '<option value="' +
                    kategori.id +
                    '">' +
                    kategori.nama_kategori +
                    "</option>"
            );
        });

        var selectEdit = $("#id_kategoriEdit");
        selectEdit.empty();
        selectEdit.append("<option selected disabled>Pilih kategori</option>");
        $.each(data, function (index, kategori) {
            selectEdit.append(
                '<option value="' +
                    kategori.id +
                    '">' +
                    kategori.nama_kategori +
                    "</option>"
            );
        });
    },
    error: function (error) {
        console.error("Error fetching categories:", error);
    },
});

$("#select_all").on("click", function () {
    $("input[name='id_produk[]']").prop("checked", this.checked);
});

$(document).on("click", "#tambah-produk", function (e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: "/produk/tambah_produk",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            nama_produk: $("input[name=nama_produk]").val(),
            id_kategori: $("select[name=id_kategori]").val(),
            merk: $("input[name=merk]").val(),
            harga_beli: $("input[name=harga_beli]").val(),
            harga_jual: $("input[name=harga_jual]").val(),
            diskon: $("input[name=diskon]").val(),
            stok: $("input[name=stok]").val(),
        },
        success: function (response) {
            $("#modal-tambah-produk").modal("hide");

            $(".toastrDefaultSuccess", function () {
                toastr.success(response.message);
            });

            clearForm();
            $("#tabelProduk").DataTable().ajax.reload();
        },
        error: function (response) {
            $("#namaProdukError").text(response.responseJSON.error.nama_produk);
            $("#idKategoriError").text(response.responseJSON.error.id_kategori);
            $("#namaMerkError").text(response.responseJSON.error.merk);
            $("#hargaBeliError").text(response.responseJSON.error.harga_beli);
            $("#hargaJualError").text(response.responseJSON.error.harga_jual);
            $("#diskonError").text(response.responseJSON.error.diskon);
            $("#stokError").text(response.responseJSON.error.stok);
        },
    });
});

$(document).on("click", "#tombol-edit", function (e) {
    let id = $(this).data("id");

    $.ajax({
        url: "/produk/edit_produk/" + id,
        type: "GET",
        success: function (response) {
            // Set data produk

            $("#inputNamaProdukEdit").val(response.nama_produk);
            $("#id_kategoriEdit").val(response.id_kategori);
            $("#inputMerkEdit").val(response.merk);
            $("#inputHargaBeliEdit").val(response.harga_beli);
            $("#inputHargaJualEdit").val(response.harga_jual);
            $("#inputDiskonEdit").val(response.diskon);
            $("#inputStokEdit").val(response.stok);

            // Menambahkan event handler
            $("#edit-produk")
                .off("click")
                .on("click", function () {
                    updateProduk(id);
                });
        },
    });
});

$("#hapusBanyak").on("click", function () {
    var selected = [];
    $("input[name='id_produk[]']:checked").each(function () {
        selected.push($(this).val());
    });

    if (selected.length > 0) {
        if (confirm("Anda yakin ingin menghapus data yang dipilih?")) {
            $.ajax({
                url: $("#delete-form").attr("action"),
                method: "POST",
                data: {
                    _token: $('input[name="_token"]').val(),
                    ids: selected,
                },
                success: function (response) {
                    $(".toastrDefaultSuccess", function () {
                        toastr.success(response.message);
                    });
                    $("#tabelProduk").DataTable().ajax.reload();
                },
                error: function (xhr) {
                    alert("Terjadi kesalahan.");
                },
            });
        }
    } else {
        alert("Pilih setidaknya satu data untuk dihapus.");
    }
});

$(document).on("click", "#tombol-hapus", function (e) {
    let id = $(this).data("id");

    if (confirm("Apakah Anda yakin ingin menghapus produk ini?")) {
        $.ajax({
            url: "/produk/hapus_produk/" + id,
            type: "DELETE",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                $(".toastrDefaultSuccess", function () {
                    toastr.success(response.message);
                });
                $("#tabelProduk").DataTable().ajax.reload();
            },
        });
    }
});

function updateProduk(id) {
    let data = {
        _token: $('meta[name="csrf-token"]').attr("content"),
        nama_produk: $("#inputNamaProdukEdit").val(),
        id_kategori: $("#id_kategoriEdit").val(),
        merk: $("#inputMerkEdit").val(),
        harga_beli: $("#inputHargaBeliEdit").val(),
        harga_jual: $("#inputHargaJualEdit").val(),
        diskon: $("#inputDiskonEdit").val(),
        stok: $("#inputStokEdit").val(),
    };

    $.ajax({
        url: "/produk/update_produk/" + id,
        type: "POST",
        data: data,
        success: function (response) {
            $("#modal-edit-produk").modal("hide");
            $("#tabelProduk").DataTable().ajax.reload();
            $(".toast").toast("show");
            $(".toastrDefaultSuccess", function () {
                toastr.success(response.message);
            });
        },
        error: function (response) {
            clearError();
            $("#namaProdukError").text(response.responseJSON.error.nama_produk);
            $("#idKategoriError").text(response.responseJSON.error.id_kategori);
            $("#namaMerkError").text(response.responseJSON.error.merk);
            $("#hargaBeliError").text(response.responseJSON.error.harga_beli);
            $("#hargaJualError").text(response.responseJSON.error.harga_jual);
            $("#diskonError").text(response.responseJSON.error.diskon);
            $("#stokError").text(response.responseJSON.error.stok);
        },
    });
}

function cetakBarcode(url) {
    var selectedCount = $('input[name="id_produk[]"]:checked').length;

    console.log("Jumlah produk yang dipilih: " + selectedCount);

    if (selectedCount < 1) {
        alert("Pilih data yang akan dicetak");
        return;
    } else {
        var form = $("<form>", {
            method: "POST",
            action: url,
            target: "_blank",
        }).append(
            $("<input>", {
                type: "hidden",
                name: "_token",
                value: $('meta[name="csrf-token"]').attr("content"),
            })
        );

        $('input[name="id_produk[]"]:checked').each(function () {
            form.append(
                $("<input>", {
                    type: "hidden",
                    name: "id_produk[]",
                    value: $(this).val(),
                })
            );
        });

        $("body").append(form);
        form.submit();
    }
}

function clearForm() {
    $("input[name=nama_produk]").val("");
    $("select[name=id_kategori]").index();
    let id_kategoriSelect = document.getElementById("id_kategori");
    id_kategoriSelect.selectedIndex = 0;
    $("input[name=merk]").val("");
    $("input[name=harga_beli]").val("");
    $("input[name=harga_jual]").val("");
    $("input[name=diskon]").val("");
    $("input[name=stok]").val("");

    $("#namaProdukError").text("");
    $("#idKategoriError").text("");
    $("#namaMerkError").text("");
    $("#hargaBeliError").text("");
    $("#hargaJualError").text("");
    $("#diskonError").text("");
    $("#stokError").text("");
}

function clearError() {
    $("#namaProdukError").text("");
    $("#idKategoriError").text("");
    $("#namaMerkError").text("");
    $("#hargaBeliError").text("");
    $("#hargaJualError").text("");
    $("#diskonError").text("");
    $("#stokError").text("");
}
