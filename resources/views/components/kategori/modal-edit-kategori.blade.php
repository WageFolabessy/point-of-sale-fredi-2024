<div class="modal fade" id="modal-edit-kategori">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Kategori</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card p-3 mb-3">
                    <div id="namaKategoriEditError" class="text-danger"></div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="nama_kategoriEdit">Nama Kategori</span>
                        <input name="nama_kategori" id="inputNamaKategoriEdit" type="text" class="form-control"
                            placeholder="Masukan nama kategori" aria-label="nama_kategoriEdit" aria-describedby="nama_kategoriEdit" />
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="edit-kategori">Edit Kategori</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
