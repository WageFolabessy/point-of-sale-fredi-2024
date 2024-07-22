<div class="modal fade" id="modal-tambah-produk">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Produk</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card p-3 mb-3">
                    <div id="namaProdukError" class="text-danger"></div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="nama_produk">Nama Produk</span>
                        <input name="nama_produk" id="inputNamaProduk" type="text" class="form-control"
                            placeholder="Masukan nama produk" aria-label="nama_produk" aria-describedby="nama_produk" />
                    </div>
                    <div id="idKategoriError" class="text-danger"></div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="id_kategoriSpan">Nama Kategori</span>
                        <select class="form-control" aria-label="Default select example" name="id_kategori" id="id_kategori">
                            <option selected disabled>Pilih kategori</option>
                            <!-- Options akan diisi dengan JavaScript -->
                        </select>
                    </div>
                    <div id="namaMerkError" class="text-danger"></div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="merk">Merk</span>
                        <input name="merk" id="inputMerk" type="text" class="form-control"
                            placeholder="Masukan nama merk" aria-label="merk" aria-describedby="merk" />
                    </div>
                    <div id="hargaBeliError" class="text-danger"></div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="harga_beli">Harga Beli</span>
                        <input name="harga_beli" id="inputHargaBeli" type="number" class="form-control"
                            placeholder="Masukan harga beli" aria-label="harga_beli" aria-describedby="harga_beli" />
                    </div>
                    <div id="hargaJualError" class="text-danger"></div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="harga_jual">Harga Jual</span>
                        <input name="harga_jual" id="inputHargaJual" type="number" class="form-control"
                            placeholder="Masukan harga jual" aria-label="harga_jual" aria-describedby="harga_jual" />
                    </div>
                    <div id="diskonError" class="text-danger"></div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="diskon">Diskon</span>
                        <input name="diskon" id="inputDiskon" type="number" class="form-control"
                            placeholder="Masukan diskon" aria-label="diskon" aria-describedby="diskon" />
                    </div>
                    <div id="stokError" class="text-danger"></div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="stok">stok</span>
                        <input name="stok" id="inputStok" type="number" class="form-control"
                            placeholder="Masukan stok" aria-label="stok" aria-describedby="stok" />
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="tambah-produk">Tambah Produk</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
