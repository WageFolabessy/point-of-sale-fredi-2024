<div class="modal fade" id="modal-edit-produk">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Produk</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card p-3 mb-3">
                    <div id="namaProdukErrorEdit" class="text-danger"></div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="nama_produk">Nama Produk</span>
                        <input name="nama_produk" id="inputNamaProdukEdit" type="text" class="form-control"
                            placeholder="Masukan nama produk" aria-label="nama_produkEdit" aria-describedby="nama_produkEdit" />
                    </div>
                    <div id="idKategoriErrorEdit" class="text-danger"></div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="id_kategoriSpan">Nama Kategori</span>
                        <select class="form-control" aria-label="Default select example" name="id_kategoriEdit" id="id_kategoriEdit">
                            <option selected disabled>Pilih kategori</option>
                            <!-- Options akan diisi dengan JavaScript -->
                        </select>
                    </div>
                    <div id="namaMerkErrorEdit" class="text-danger"></div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="merk">Merk</span>
                        <input name="merk" id="inputMerkEdit" type="text" class="form-control"
                            placeholder="Masukan nama merk" aria-label="merkEdit" aria-describedby="merkEdit" />
                    </div>
                    <div id="hargaBeliErrorEdit" class="text-danger"></div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="harga_beliEdit">Harga Beli</span>
                        <input name="harga_beli" id="inputHargaBeliEdit" type="number" class="form-control"
                            placeholder="Masukan harga beli" aria-label="harga_beliEdit" aria-describedby="harga_beliEdit" />
                    </div>
                    <div id="hargaJualErrorEdit" class="text-danger"></div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="harga_jualEdit">Harga Jual</span>
                        <input name="harga_jual" id="inputHargaJualEdit" type="number" class="form-control"
                            placeholder="Masukan harga jual" aria-label="harga_jualEdit" aria-describedby="harga_jualEdit" />
                    </div>
                    <div id="diskonErrorEdit" class="text-danger"></div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="diskon">Diskon</span>
                        <input name="diskon" id="inputDiskonEdit" type="number" class="form-control"
                            placeholder="Masukan diskon" aria-label="diskonEdit" aria-describedby="diskonEdit" />
                    </div>
                    <div id="stokErrorEdit" class="text-danger"></div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="stokEdit">stok</span>
                        <input name="stok" id="inputStokEdit" type="number" class="form-control"
                            placeholder="Masukan stok" aria-label="stok" aria-describedby="stok" />
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="edit-produk">Edit Produk</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
