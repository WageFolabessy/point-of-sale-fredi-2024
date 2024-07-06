<div class="modal fade" id="modal-tambah-transaksi">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Transaksi</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card p-3 mb-3">
                    <div id="nomorHPError" class="text-danger"></div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="nomor_hp">Nomor HP</span>
                        <input name="nomor_hp" id="inputNomorHP" type="text" class="form-control"
                            placeholder="Masukan Nomor HP" aria-label="nomor_hp" aria-describedby="nomor_hp" />
                    </div>
                    <div id="hargaBeliError" class="text-danger"></div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="harga_beli">Harga Beli</span>
                        <input name="harga_beli" id="inputHargaBeli" type="number" class="form-control"
                            placeholder="Masukan Harga Beli" aria-label="harga_beli" aria-describedby="harga_beli" />
                    </div>
                    <div id="hargaJualError" class="text-danger"></div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="harga_jual">Harga Jual</span>
                        <input name="harga_jual" id="inputHargaJual" type="number" class="form-control"
                            placeholder="Masukan Harga Jual" aria-label="harga_jual" aria-describedby="harga_jual" />
                    </div>
                    <div id="keteranganError" class="text-danger"></div>
                    <div class="input-group">
                        <span class="input-group-text" id="keterangan">Keterangan</span>
                        <textarea class="form-control" id="inputKeterangan" name="keterangan" rows="3" aria-label="keterangan"
                            aria-describedby="keterangan"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="tambah-transaksi">Tambah Transaksi</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
