$(document).ready(function () {
    let defaultDate = moment().format("YYYY-MM-DD"); // Tanggal default adalah hari ini

    let table = $("#tabelKasirServis").DataTable({
        processing: false,
        serverSide: true,
        ajax: {
            url: "/kasir_servis/datatables/",
            data: function (d) {
                let selectedDate = $("#tanggal_transaksi input").val();
                if (!selectedDate) {
                    selectedDate = defaultDate; // Jika tanggal tidak dipilih, gunakan defaultDate
                }
                let formattedDate = moment(selectedDate, "MM/DD/YYYY").format(
                    "YYYY-MM-DD"
                );
                d.date = formattedDate;

                let today = moment().format("YYYY-MM-DD");
                if (formattedDate === today) {
                    $("#keteranganTanggal").text("Transaksi Hari Ini");
                } else {
                    $("#keteranganTanggal").text(
                        "Transaksi Hari " + tanggal_indonesia(formattedDate)
                    );
                }
            },
        },
        columns: [
            { data: "DT_RowIndex", name: "DT_RowIndex" },
            { data: "nama", name: "nama" },
            { data: "no_hp", name: "no_hp" },
            { data: "jenis_hp", name: "jenis_hp" },
            { data: "nomor_imei", name: "nomor_imei" },
            { data: "status", name: "status" },
            { data: "nama_kasir", name: "nama_kasir" },
            { data: "aksi", name: "aksi", orderable: false, searchable: false },
        ],
    });

    $("#tanggal_transaksi").datetimepicker({
        format: "L",
    });

    $("#ubah-periode-transaksi").click(function () {
        table.ajax.reload();
        $("#modal-periode-transaksi").modal("hide");
    });
});

$(document).on("click", "#tambah-transaksi", function (e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: "/kasir_servis/tambah_transaksi",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            nama: $("input[name=nama]").val(),
            no_hp: $("input[name=no_hp]").val(),
            jenis_hp: $("input[name=jenis_hp]").val(),
            nomor_imei: $("input[name=no_imei]").val(),
            status: $("select[name=inputStatus]").val(),
            kerusakan: ambilDataTabel(),
        },
        success: function (response) {
            $("#modal-tambah-transaksi").modal("hide");

            $(".toastrDefaultSuccess", function () {
                toastr.success(response.message);
            });

            clearForm();
            clearTable();
            tampilSembunyiTabel();
            console.log(ambilDataTabel());

            $("#tabelKasirServis").DataTable().ajax.reload();
        },
        error: function (response) {
            console.log(ambilDataTabel());
            $("#namaError").text(response.responseJSON.error.nama);
            $("#noHpError").text(response.responseJSON.error.no_hp);
            $("#jenisHpError").text(response.responseJSON.error.jenis_hp);
            $("#nomorImeiError").text(response.responseJSON.error.no_imei);
            $("#statusError").text(response.responseJSON.error.status);
        },
    });
});

$(document).on("click", "#tombol-edit", function (e) {
    let id = $(this).data("id");

    $.ajax({
        url: "/kasir_servis/edit_transaksi/" + id,
        type: "GET",
        success: function (response) {
            const {
                nama,
                no_hp,
                jenis_hp,
                nomor_imei,
                status,
                kasir_servis_keluhans,
            } = response;

            $("#inputNamaEdit").val(nama);
            $("#inputNoHpEdit").val(no_hp);
            $("#inputJenisHpEdit").val(jenis_hp);
            $("#inputNoImeiEdit").val(nomor_imei);

            if (status == 0) {
                $("#inputStatusEdit").val("0");
            } else if (status == 1) {
                $("#inputStatusEdit").val("1");
            }

            // Set data peserta kegiatan
            if (kasir_servis_keluhans !== null) {
                let tabel = document.getElementById("tabelKerusakanEdit");

                // Hapus baris tabel yang ada
                for (let i = tabel.rows.length - 1; i >= 1; i--) {
                    tabel.deleteRow(i);
                }

                // Tambahkan baris baru
                kasir_servis_keluhans.forEach((kerusakan) => {
                    let baris = tabel.insertRow();

                    // Gunakan format_uang untuk biaya, harga_beli, dan harga_jual
                    baris.insertCell(0).innerHTML = kerusakan["kerusakan"];
                    baris.insertCell(1).innerHTML = format_uang(
                        kerusakan["biaya"]
                    );
                    baris.insertCell(2).innerHTML = format_uang(
                        kerusakan["harga_beli"]
                    );
                    baris.insertCell(3).innerHTML = format_uang(
                        kerusakan["harga_jual"]
                    );

                    // Membuat tombol hapus untuk setiap baris
                    let tombolHapus = document.createElement("button");
                    tombolHapus.innerHTML = "Hapus";
                    tombolHapus.className = "btn btn-danger";
                    tombolHapus.onclick = function () {
                        hapusKerusakanEdit(this);
                    };
                    baris.insertCell(4).appendChild(tombolHapus); // Menambahkan tombol ke sel aksi
                });

                // Tampilkan tabel jika ada baris
                tabel.style.display = tabel.rows.length > 1 ? "table" : "none";
            }
            // Menambahkan event handler
            $("#edit-transaksi")
                .off("click")
                .on("click", function () {
                    updateTransaksi(id);
                });
        },
    });
});

$(document).on("click", "#tombol-detail", function (e) {
    let id = $(this).data("id");

    $.ajax({
        url: "/kasir_servis/edit_transaksi/" + id,
        type: "GET",
        success: function (response) {
            const {
                nama,
                no_hp,
                jenis_hp,
                nomor_imei,
                status,
                kasir_servis_keluhans,
            } = response;

            $("#inputNamaDetail").val(nama);
            $("#inputNoHpDetail").val(no_hp);
            $("#inputJenisHpDetail").val(jenis_hp);
            $("#inputNoImeiDetail").val(nomor_imei);

            if (status == 0) {
                $("#inputStatusDetail").val("0");
            } else if (status == 1) {
                $("#inputStatusDetail").val("1");
            }

            // Set data peserta kegiatan
            if (kasir_servis_keluhans !== null) {
                let tabel = document.getElementById("tabelKerusakanDetail");

                // Hapus baris tabel yang ada
                for (let i = tabel.rows.length - 1; i >= 1; i--) {
                    tabel.deleteRow(i);
                }

                // Tambahkan baris baru
                kasir_servis_keluhans.forEach((kerusakan) => {
                    let baris = tabel.insertRow();

                    // Gunakan format_uang untuk biaya, harga_beli, dan harga_jual
                    baris.insertCell(0).innerHTML = kerusakan["kerusakan"];
                    baris.insertCell(1).innerHTML = format_uang(
                        kerusakan["biaya"]
                    );
                    baris.insertCell(2).innerHTML = format_uang(
                        kerusakan["harga_beli"]
                    );
                    baris.insertCell(3).innerHTML = format_uang(
                        kerusakan["harga_jual"]
                    );
                });

                // Tampilkan tabel jika ada baris
                tabel.style.display = tabel.rows.length > 1 ? "table" : "none";
            }
        },
    });
});

$(document).on("click", "#tombol-hapus", function (e) {
    let id = $(this).data("id");

    if (confirm("Apakah Anda yakin ingin menghapus transaksi ini?")) {
        $.ajax({
            url: "/kasir_servis/hapus_transaksi/" + id,
            type: "DELETE",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                $(".toastrDefaultSuccess", function () {
                    toastr.success(response.message);
                });
                $("#tabelKasirServis").DataTable().ajax.reload();
            },
        });
    }
});

function updateTransaksi(id) {
    let data = {
        _token: $('meta[name="csrf-token"]').attr("content"),
        nama: $("input[name=namaEdit]").val(),
        no_hp: $("input[name=no_hpEdit]").val(),
        jenis_hp: $("input[name=jenis_hpEdit]").val(),
        nomor_imei: $("input[name=no_imeiEdit]").val(),
        status: $("select[name=inputStatusSelectEdit]").val(),
        kerusakan: ambilDataTabelEdit(),
    };

    console.log(data);
    $.ajax({
        url: "/kasir_servis/update_transaksi/" + id,
        type: "POST",
        data: data,
        success: function (response) {
            $("#modal-edit-transaksi").modal("hide");

            $("#tabelKasirServis").DataTable().ajax.reload();

            $(".toastrDefaultSuccess", function () {
                toastr.success(response.message);
            });
        },
        error: function (response) {
            clearError();
            $("#namaErrorEdit").text(response.responseJSON.error.nama);
            $("#noHpErrorEdit").text(response.responseJSON.error.no_hp);
            $("#jenisHpErrorEdit").text(response.responseJSON.error.jenis_hp);
            $("#nomorImeiErrorEdit").text(response.responseJSON.error.no_imei);
            $("#statusErrorEdit").text(response.responseJSON.error.status);
        },
    });
}

function clearForm() {
    $("input[name=nama]").val("");
    $("input[name=no_hp]").val("");
    $("input[name=jenis_hp]").val("");
    $("input[name=no_imei]").val("");
    $("#inputStatus").val("-1");

    $("input[name=kerusakan]").val("");
    $("input[name=harga_beli]").val("");
    $("input[name=harga_jual]").val("");
    $("input[name=biaya]").val("");

    $("#namaError").text("");
    $("#noHpError").text("");
    $("#jenisHpError").text("");
    $("#nomorImeiError").text("");
    $("#statusError").text("");
}

function clearError() {
    $("#nomorHPErrorEdit").text("");
    $("#hargaBeliErrorEdit").text("");
    $("#hargaJualErrorEdit").text("");
    $("#keteranganErrorEdit").text("");
}

function tanggal_indonesia(tgl, tampil_hari = true) {
    const nama_hari = [
        "Minggu",
        "Senin",
        "Selasa",
        "Rabu",
        "Kamis",
        "Jum'at",
        "Sabtu",
    ];
    const nama_bulan = [
        "",
        "Januari",
        "Februari",
        "Maret",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Agustus",
        "September",
        "Oktober",
        "November",
        "Desember",
    ];

    const tahun = tgl.substring(0, 4);
    const bulan = nama_bulan[parseInt(tgl.substring(5, 7))];
    const tanggal = tgl.substring(8, 10);
    let text = "";

    if (tampil_hari) {
        const urutan_hari = new Date(
            tahun,
            parseInt(tgl.substring(5, 7)) - 1,
            tanggal
        ).getDay();
        const hari = nama_hari[urutan_hari];
        text += `${hari}, ${tanggal} ${bulan} ${tahun}`;
    } else {
        text += `${tanggal} ${bulan} ${tahun}`;
    }

    return text;
}

function tambahKerusakan() {
    // Mendapatkan elemen tabel dan jumlah baris
    let tabel = document.getElementById("tabelKerusakan");
    let jumlahBaris = tabel.rows.length;

    // Mendapatkan nilai input dari form
    let kerusakan = document.getElementById("inputKerusakan").value;
    let biaya = document.getElementById("inputBiaya").value;
    let hargaBeli = document.getElementById("inputHargaBeli").value;
    let hargaJual = document.getElementById("inputHargaJual").value;

    if (
        biaya !== "" &&
        kerusakan !== "" &&
        hargaBeli !== "" &&
        hargaJual !== ""
    ) {
        // Membuat baris baru
        let baris = tabel.insertRow(jumlahBaris);

        // Membuat sel baru dan mengisi dengan nilai input
        let selkerusakan = baris.insertCell(0);
        let selbiaya = baris.insertCell(1);
        let selhargaBeli = baris.insertCell(2);
        let selhargaJual = baris.insertCell(3);
        let selAksi = baris.insertCell(4);

        selbiaya.innerHTML = format_uang(parseInt(biaya));
        selkerusakan.innerHTML = kerusakan;
        selhargaBeli.innerHTML = format_uang(parseInt(hargaBeli));
        selhargaJual.innerHTML = format_uang(parseInt(hargaJual));

        // Membuat tombol hapus untuk setiap baris
        let tombolHapus = document.createElement("button");
        tombolHapus.innerHTML = "Hapus";
        tombolHapus.className = "btn btn-danger";
        tombolHapus.onclick = function () {
            hapusKerusakan(this);
        };
        selAksi.appendChild(tombolHapus); // Menambahkan tombol ke sel aksi
        tampilSembunyiTabel();
        clearInputKerusakan();
    } else {
        alert("Anda harus melengkapi semua data");
    }
}

function hapusKerusakan(tombol) {
    // Mendapatkan indeks baris dari tombol
    let indeks = tombol.parentNode.parentNode.rowIndex;
    // Menghapus baris dari tabel
    document.getElementById("tabelKerusakan").deleteRow(indeks);
    tampilSembunyiTabel();
}

function ambilDataTabel() {
    // Mendapatkan elemen tabel
    let tabel = document.getElementById("tabelKerusakan");

    // Membuat array untuk menyimpan data
    let dataTabel = [];

    // Melakukan iterasi untuk setiap baris di tabel
    for (let i = 1; i < tabel.rows.length; i++) {
        // Mendapatkan baris saat ini
        let baris = tabel.rows[i];
        let biaya = parseInt(baris.cells[1].innerText.replace(/[Rp.\s,]/g, ""));
        let harga_beli = parseInt(baris.cells[2].innerText.replace(/[Rp.\s,]/g, ""));
        let harga_jual = parseInt(baris.cells[3].innerText.replace(/[Rp.\s,]/g, ""));

        // Membuat objek untuk menyimpan data baris

        let dataBaris = {
            kerusakan: baris.cells[0].innerText,
            biaya: isNaN(biaya) ? 0 : biaya,
            harga_beli: isNaN(harga_beli) ? 0 : harga_beli,
            harga_jual: isNaN(harga_jual) ? 0 : harga_jual,
        };

        // Menambahkan data baris ke array data tabel
        dataTabel.push(dataBaris);
    }

    // Mengembalikan data tabel
    return dataTabel;
}

function tampilSembunyiTabel() {
    let tabel = document.getElementById("tabelKerusakan");
    let jumlahBaris = tabel.rows.length - 1;
    if (jumlahBaris >= 1) {
        tabel.style.display = "table";
    } else {
        tabel.style.display = "none";
    }
}

function clearInputKerusakan() {
    // Mengosongkan field input
    document.getElementById("inputKerusakan").value = "";
    document.getElementById("inputBiaya").value = "";
    document.getElementById("inputHargaBeli").value = "";
    document.getElementById("inputHargaJual").value = "";
}

function clearTable() {
    let tabel = document.getElementById("tabelKerusakan");

    // Remove all rows except the header
    while (tabel.rows.length > 1) {
        tabel.deleteRow(1);
    }
}

// EDIT

function tambahKerusakanEdit() {
    // Mendapatkan elemen tabel dan jumlah baris
    let tabel = document.getElementById("tabelKerusakanEdit");
    let jumlahBaris = tabel.rows.length;

    // Mendapatkan nilai input dari form
    let kerusakan = document.getElementById("inputKerusakanEdit").value;
    let biaya = document.getElementById("inputBiayaEdit").value;
    let hargaBeli = document.getElementById("inputHargaBeliEdit").value;
    let hargaJual = document.getElementById("inputHargaJualEdit").value;

    if (
        biaya !== "" &&
        kerusakan !== "" &&
        hargaBeli !== "" &&
        hargaJual !== ""
    ) {
        // Membuat baris baru
        let baris = tabel.insertRow(jumlahBaris);

        // Membuat sel baru dan mengisi dengan nilai input
        let selkerusakan = baris.insertCell(0);
        let selbiaya = baris.insertCell(1);
        let selhargaBeli = baris.insertCell(2);
        let selhargaJual = baris.insertCell(3);
        let selAksi = baris.insertCell(4);

        selbiaya.innerHTML = format_uang(parseInt(biaya));
        selkerusakan.innerHTML = kerusakan;
        selhargaBeli.innerHTML = format_uang(parseInt(hargaBeli));
        selhargaJual.innerHTML = format_uang(parseInt(hargaJual));

        // Membuat tombol hapus untuk setiap baris
        let tombolHapus = document.createElement("button");
        tombolHapus.innerHTML = "Hapus";
        tombolHapus.className = "btn btn-danger";
        tombolHapus.onclick = function () {
            hapusKerusakanEdit(this);
        };
        selAksi.appendChild(tombolHapus); // Menambahkan tombol ke sel aksi
        tampilSembunyiTabelEdit();
        clearInputKerusakanEdit();
    } else {
        alert("Anda harus melengkapi semua data");
    }
}

function hapusKerusakanEdit(tombol) {
    // Mendapatkan indeks baris dari tombol
    let indeks = tombol.parentNode.parentNode.rowIndex;
    // Menghapus baris dari tabel
    document.getElementById("tabelKerusakanEdit").deleteRow(indeks);
    tampilSembunyiTabelEdit();
}

function ambilDataTabelEdit() {
    // Mendapatkan elemen tabel
    let tabel = document.getElementById("tabelKerusakanEdit");

    // Membuat array untuk menyimpan data
    let dataTabel = [];

    for (let i = 1; i < tabel.rows.length; i++) {
        // Mendapatkan baris saat ini
        let baris = tabel.rows[i];
        let biaya = parseInt(baris.cells[1].innerText.replace(/[Rp.\s,]/g, ""));
        let harga_beli = parseInt(baris.cells[2].innerText.replace(/[Rp.\s,]/g, ""));
        let harga_jual = parseInt(baris.cells[3].innerText.replace(/[Rp.\s,]/g, ""));

        // Membuat objek untuk menyimpan data baris

        let dataBaris = {
            kerusakan: baris.cells[0].innerText,
            biaya: isNaN(biaya) ? 0 : biaya,
            harga_beli: isNaN(harga_beli) ? 0 : harga_beli,
            harga_jual: isNaN(harga_jual) ? 0 : harga_jual,
        };

        // Menambahkan data baris ke array data tabel
        dataTabel.push(dataBaris);
    }

    // Mengembalikan data tabel
    return dataTabel;
}

function tampilSembunyiTabelEdit() {
    let tabel = document.getElementById("tabelKerusakanEdit");
    let jumlahBaris = tabel.rows.length - 1;
    if (jumlahBaris >= 1) {
        tabel.style.display = "table";
    } else {
        tabel.style.display = "none";
    }
}

function clearInputKerusakanEdit() {
    // Mengosongkan field input
    document.getElementById("inputKerusakanEdit").value = "";
    document.getElementById("inputBiayaEdit").value = "";
    document.getElementById("inputHargaBeliEdit").value = "";
    document.getElementById("inputHargaJualEdit").value = "";
}

function clearTableEdit() {
    let tabel = document.getElementById("tabelKerusakanEdit");

    // Remove all rows except the header
    while (tabel.rows.length > 1) {
        tabel.deleteRow(1);
    }
}

function format_uang(number) {
    return "Rp. " + number.toLocaleString("id-ID");
}

document
    .getElementById("addKerusakan")
    .addEventListener("click", tambahKerusakan);
document
    .getElementById("addKerusakanEdit")
    .addEventListener("click", tambahKerusakanEdit);
