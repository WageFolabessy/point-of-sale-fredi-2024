// Inisialisasi DataTable
$("#tabelProduk").DataTable({
    processing: false,
    serverSide: true,
    ajax: '/produk/datatables/',
    columns: [
        {data: 'select_all', searchable: false, sortable: false},
        { data: "DT_RowIndex", name: "DT_RowIndex" },
        { data: "kode_produk", name: "kode_produk" },
        { data: "nama_produk", name: "nama_produk" },
        { data: "nama_kategori", name: "nama_kategori" },
        { data: "merk", name: "merk" },
        { data: "harga_beli", name: "harga_beli" },
        { data: "harga_jual", name: "harga_jual" },
        { data: "diskon", name: "diskon" },
        { data: "stok", name: "stok" },
        { data: "aksi", name: "aksi", orderable: false, searchable: false },
    ],
});

// Ambil data kategori dan isi select
$.ajax({
    url: '/produk/kategori_list/',
    type: 'GET',
    success: function(data) {
        var select = $('#id_kategori');
        select.empty();
        select.append('<option selected disabled>Pilih kategori</option>');
        $.each(data, function(index, kategori) {
            select.append('<option value="' + kategori.id + '">' + kategori.nama_kategori + '</option>');
        });
    },
    error: function(error) {
        console.error('Error fetching categories:', error);
    }
});

$('[name=select_all]').on('click', function () {
    $(':checkbox').prop('checked', this.checked);
});
