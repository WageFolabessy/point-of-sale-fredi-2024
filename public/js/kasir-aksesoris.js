// Fungsi untuk menampilkan modal produk
function tampilProduk() {
    $("#modal-tampil-produk").modal("show");
}

// Fungsi untuk memformat angka menjadi format uang Rupiah
function format_uang(number) {
    return "Rp. " + number.toLocaleString("id-ID");
}

// Fungsi untuk menghapus angka nol dari input jika input bernilai 0
function clearZero(input) {
    if (input.value === "0") {
        input.value = "";
    }
}

// Fungsi untuk mengembalikan angka nol jika input kosong
function restoreZero(input) {
    if (input.value === "") {
        input.value = "0";
    }
}

// Fungsi untuk menghitung kembalian
function hitungKembalian() {
    let total = parseFloat($("#totalrp").val().replace(/\D/g, "")) || 0;
    let diterima = parseFloat($("#diterima").val().replace(/\D/g, "")) || 0;
    let kembalian = 0;

    let diskon = parseFloat($("#diskon").val()) || 0;
    let bayarrp = parseFloat($("#bayarrp").val().replace(/\D/g, "")) || 0;

    if (diskon === 0) {
        kembalian = diterima - total;
    } else {
        kembalian = diterima - bayarrp;
    }
    $("#kembali").val(format_uang(kembalian));
}

// Fungsi untuk menghitung harga setelah diskon
function hitungDiskon() {
    let total = parseFloat($("#totalrp").val().replace(/\D/g, "")) || 0;
    let diskon = parseFloat($("#diskon").val()) || 0;
    let hargaBayarSetelahDiskon = total - diskon;

    $("#bayarrp").val(format_uang(hargaBayarSetelahDiskon));
    $("#kembali").val(format_uang(hargaBayarSetelahDiskon));
    $(".tampil-bayar").text("Bayar: " + format_uang(hargaBayarSetelahDiskon));
}

// Inisialisasi ketika dokumen siap
$(document).ready(function () {
    $(".tampil-bayar").text("Bayar: " + format_uang(0));
    $("#totalrp").val(format_uang(0));
    $("#kembali").val(format_uang(0));
    $("#bayarrp").val(format_uang(0));

    // Setup AJAX dengan CSRF token
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    // Inisialisasi DataTable
    $("#tabelProduk").DataTable();
    let table = $("#tabelKasirAksesoris").DataTable({
        processing: false,
        serverSide: false,
        searching: false,
        paging: false,
        info: false,
        columns: [
            { title: "No" },
            { title: "Kode" },
            { title: "Nama" },
            {
                title: "Harga",
                render: function (data) {
                    return format_uang(parseInt(data));
                },
            },
            { title: "Jumlah" },
            {
                title: "Diskon",
                render: function (data) {
                    return format_uang(parseInt(data))
                },
            },
            {
                title: "Subtotal",
                render: function (data) {
                    return (
                        '<span class="subtotal" data-value="' +
                        data +
                        '">' +
                        format_uang(data) +
                        "</span>"
                    );
                },
            },
            { title: "Aksi" },
        ],
    });

    // Event handler untuk tombol pilih produk
    $(".pilih-produk").click(function (e) {
        e.preventDefault();

        let data = {
            kode: $(this).data("kode"),
            nama: $(this).data("nama"),
            harga: $(this).data("harga"),
            diskon: $(this).data("diskon"),
        };

        $.ajax({
            type: "POST",
            url: "/add-product",
            data: data,
            success: function (response) {
                let product = response.product;
                let exists = false;

                table.rows().every(function () {
                    let rowData = this.data();
                    if (rowData[1] === product.kode) {
                        exists = true;
                        return false;
                    }
                });

                if (!exists) {
                    table.row
                        .add([
                            "",
                            product.kode,
                            product.nama,
                            product.harga,
                            `<input type="number" class="form-control jumlah" value="1" min="1" data-id="${product.kode}" data-harga="${product.harga}" data-diskon="${product.diskon}">`,
                            product.diskon,
                            product.subtotal,
                            '<button class="btn btn-danger btn-sm btn-hapus">Hapus</button>',
                        ])
                        .draw(false);
                    updateTableNumbers();
                    updateTotal();
                    hitungDiskon();
                    hitungKembalian();

                    $("#modal-tampil-produk").modal("hide");
                } else {
                    alert("Produk sudah ada di daftar transaksi.");
                }
            },
        });
    });

    // Fungsi untuk mengupdate nomor urut pada tabel
    function updateTableNumbers() {
        table.rows().every(function (index) {
            let row = this.node();
            $(row)
                .find("td:first")
                .text(index + 1);
        });
    }

    // Fungsi untuk mengupdate total harga
    function updateTotal() {
        let total = 0;
        table.rows().every(function () {
            let row = this.node();
            let subtotal = parseFloat($(row).find(".subtotal").data("value"));
            total += subtotal;
        });

        $("#totalrp").val(format_uang(total));
        $(".tampil-bayar").text("Bayar: " + format_uang(total));

        hitungKembalian();
    }

    // Event handler untuk tombol hapus
    $("#tabelKasirAksesoris tbody").on("click", ".btn-hapus", function () {
        let row = table.row($(this).parents("tr"));
        row.remove().draw();
        updateTableNumbers();
        updateTotal();
        hitungDiskon();
        hitungKembalian();
    });

    // Event handler untuk input jumlah
    $("#tabelKasirAksesoris tbody").on("input", ".jumlah", function () {
        $(this).focus();

        let row = $(this).closest("tr");
        let kode = $(this).data("id");
        let jumlah = $(this).val();
        let harga = $(this).data("harga");
        let diskon = $(this).data("diskon");

        $.ajax({
            type: "POST",
            url: "/update-quantity",
            data: { kode: kode, jumlah: jumlah, harga: harga, diskon: diskon },
            success: function (response) {
                let subtotal = response.subtotal;
                table.cell(row, 6).data(format_uang(subtotal)).draw(false);
                $(row)
                    .find(".subtotal")
                    .data("value", subtotal)
                    .text(format_uang(subtotal));
                updateTotal();
                hitungDiskon();
                hitungKembalian();
            },
        });
    });

    $("#btn-simpan").click(function (e) {
        e.preventDefault();

        let produk = [];
        table.rows().every(function () {
            let data = this.data();
            produk.push({
                id: data[1], // Kode Produk
                harga_jual: parseInt(data[3].replace(/\D/g, "")),
                jumlah: $(this.node()).find(".jumlah").val(),
                diskon: parseInt(data[5]) || 0,
                subtotal: parseInt($(this.node()).find(".subtotal").data("value")) // Ambil data-value dari elemen subtotal
            });
        });

        // Data yang akan dikirim ke server
        let transaksi = {
            total_item: produk.length,
            total_harga: parseInt($("#totalrp").val().replace(/\D/g, "")),
            diskon: parseFloat($("#diskon").val()) || 0,
            bayar: parseInt($("#bayarrp").val().replace(/\D/g, "")),
            diterima: parseInt($("#diterima").val().replace(/\D/g, "")),
            nama_kasir: $("#nama_kasir").val(),
            produk: produk,
            _token: $('meta[name="csrf-token"]').attr("content"),
        };
        console.log(transaksi);

        $.ajax({
            type: "POST",
            url: "simpan-transaksi",
            data: transaksi,
            success: function (response) {
                if (response.success) {
                    alert(response.message);
                    window.location.reload(); // reload halaman
                }
            },
            error: function (xhr, status, error) {
                alert("Gagal menyimpan transaksi. Silakan coba lagi.");
                console.log(xhr.responseText);
            }
        });
    });

    $("#btn-simpan-dan-cetak-nota").click(function (e) {
        e.preventDefault();

        let produk = [];
        table.rows().every(function () {
            let data = this.data();
            produk.push({
                id: data[1], // Kode Produk
                harga_jual: parseInt(data[3].replace(/\D/g, "")),
                jumlah: $(this.node()).find(".jumlah").val(),
                diskon: parseInt(data[5]) || 0,
                subtotal: parseInt($(this.node()).find(".subtotal").data("value")) // Ambil data-value dari elemen subtotal
            });
        });

        // Data yang akan dikirim ke server
        let transaksi = {
            total_item: produk.length,
            total_harga: parseInt($("#totalrp").val().replace(/\D/g, "")),
            diskon: parseFloat($("#diskon").val()) || 0,
            bayar: parseInt($("#bayarrp").val().replace(/\D/g, "")),
            diterima: parseInt($("#diterima").val().replace(/\D/g, "")),
            nama_kasir: $("#nama_kasir").val(),
            produk: produk,
            _token: $('meta[name="csrf-token"]').attr("content"),
        };

        $.ajax({
            type: "POST",
            url: "simpan-transaksi",
            data: transaksi,
            success: function (response) {
                if (response.success) {
                    alert(response.message);
                    window.open('/cetak-nota/' + response.penjualan_id, '_blank');
                    window.location.reload(); // reload halaman
                }
            },
            error: function (xhr, status, error) {
                alert("Gagal menyimpan transaksi. Silakan coba lagi.");
                console.log(xhr.responseText);
            }
        });
    });



    // Event handler untuk input diterima
    $("#diterima").on("input", hitungKembalian);
    // Event handler untuk input diskon
    $("#diskon").on("input", hitungDiskon);
});
