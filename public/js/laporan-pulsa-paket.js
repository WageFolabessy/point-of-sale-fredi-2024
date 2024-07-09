$(document).ready(function () {
    let table = $("#tabelLaporanPulsaPaket").DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        paging: false,
        info: false,
        ajax: {
            url: "/laporan_pulsa_paket/datatables/",
            data: function (d) {
                let startDate = $("#tanggal_mulai input").val();
                let endDate = $("#tanggal_akhir input").val();
                d.start_date = moment(startDate, "MM/DD/YYYY").format(
                    "YYYY-MM-DD"
                );
                d.end_date = moment(endDate, "MM/DD/YYYY").format("YYYY-MM-DD");
            },
            dataSrc: function (json) {
                $("#totalProfit").html(json.totalProfit);
                $("#totalHargaBeli").html(json.totalHargaBeli);
                $("#totalHargaJual").html(json.totalHargaJual);
                return json.data;
            },
        },
        columns: [
            { data: "DT_RowIndex", name: "DT_RowIndex" },
            { data: "created_at", name: "created_at" },
            { data: "nomor_hp", name: "nomor_hp" },
            { data: "harga_beli", name: "harga_beli" },
            { data: "harga_jual", name: "harga_jual" },
            { data: "nama_kasir", name: "nama_kasir" },
            { data: "profit", name: "profit" },
        ],
    });

    $("#tanggal_mulai").datetimepicker({
        format: "L",
    });

    $("#tanggal_akhir").datetimepicker({
        format: "L",
    });

    $("#ubah-periode-transaksi").click(function () {
        table.ajax.reload();
        $("#modal-periode-laporan").modal("hide");

        // Set keteranganTanggal
        let startDate = $("#tanggal_mulai input").val();
        let endDate = $("#tanggal_akhir input").val();
        let today = moment().format("MM/DD/YYYY");

        if (startDate === today && endDate === today) {
            $("#keteranganTanggal").text("Laporan Hari Ini");
        } else {
            $("#laporan").text("Laporan Tanggal");
            $("#keteranganTanggal").text(
                tanggal_indonesia(startDate, false) +
                    " - " +
                    tanggal_indonesia(endDate, false)
            );
        }
    });

    // Set default keteranganTanggal saat halaman dimuat
    let today = moment().format("MM/DD/YYYY");
    $("#keteranganTanggal").text("Laporan Hari Ini");
});

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

    console.log("Tanggal Input: ", tgl); // Debug

    const bulan = nama_bulan[parseInt(tgl.substring(0, 2))];
    const tanggal = tgl.substring(3, 5);
    const tahun = tgl.substring(6, 10);
    let text = "";

    if (tampil_hari) {
        const urutan_hari = new Date(
            tahun,
            parseInt(tgl.substring(0, 2)) - 1,
            tanggal
        ).getDay();
        const hari = nama_hari[urutan_hari];
        text += `${hari}, ${tanggal} ${bulan} ${tahun}`;
    } else {
        text += `${tanggal} ${bulan} ${tahun}`;
    }

    return text;
}
