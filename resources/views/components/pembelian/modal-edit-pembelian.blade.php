<div class="modal fade" id="modal-edit-pengeluaran">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Pengeluaran</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card p-3 mb-3">
                    <div id="deskripsiErrorEdit" class="text-danger"></div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="deskripsiEdit">Deskripsi</span>
                        <input name="deskripsiEdit" id="inputDeskripsiEdit" type="text" class="form-control"
                            placeholder="Masukan deskripsi" aria-label="deskripsi" aria-describedby="deskripsi" />
                    </div>
                    <div id="nominalErrorEdit" class="text-danger"></div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="nominalEdit">nominal</span>
                        <input name="nominalEdit" id="inputNominalEdit" type="number" class="form-control"
                            placeholder="Masukan nominal" aria-label="nominal" aria-describedby="nominal" />
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="edit-pengeluaran">Edit Pengeluaran</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
