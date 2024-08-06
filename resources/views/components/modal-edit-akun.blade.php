<div class="modal fade" id="modal-edit-akun">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Akun</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card p-3 mb-3">
                    <div id="namaErrorEdit" class="text-danger"></div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="nama">Nama</span>
                        <input name="nama" id="inputNamaEdit" type="text" class="form-control"
                            placeholder="Masukan nama" aria-label="nama" aria-describedby="nama" />
                    </div>
                    <div id="usernameErrorEdit" class="text-danger"></div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="username">Username</span>
                        <input name="username" id="inputusernameEdit" type="text" class="form-control"
                            placeholder="Masukan username" aria-label="username" aria-describedby="username" />
                    </div>
                    <div id="isAdminErrorEdit" class="text-danger"></div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="username">Peran</span>
                        <select class="form-control form-select" id="input_isAdminEdit">
                            <option disabled selected>Pilih Peran</option>
                            <option value="0">Biasa</option>
                            <option value="1">Admin</option>
                        </select>
                    </div>
                    <div id="passwordErrorEdit" class="text-danger"></div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="Password">Password</span>
                        <input name="password" id="inputPasswordEdit" type="password" class="form-control"
                            placeholder="Masukan password" aria-label="Password" aria-describedby="Password"
                            autocomplete="new-password" />
                    </div>
                    <div id="fotoErrorEdit" class="text-danger"></div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="fotoProfilEdit">Foto Profil</span>
                        <input type="file" class="form-control" id="fotoProfilInputEdit" name="foto_profil"
                            accept="image/*" />
                    </div>
                    <div class="mb-3 text-center">
                        <img src="" alt="Foto Profil" class="img-fluid d-none" id="fotoPreviewEdit"
                            style="max-width: 200px; border-radius: 50%; border: 2px solid #ddd;" />
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="edit-akun">Edit Akun</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
