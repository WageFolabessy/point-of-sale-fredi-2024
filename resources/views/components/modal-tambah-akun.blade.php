<div class="modal fade" id="modal-tambah-akun">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Akun</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card p-3 mb-3">
                    <div id="namaError" class="text-danger"></div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="nama">Nama</span>
                        <input name="nama" id="inputNama" type="text" class="form-control"
                            placeholder="Masukan nama" aria-label="nama" aria-describedby="nama" />
                    </div>
                    <div id="usernameError" class="text-danger"></div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="username">Username</span>
                        <input name="username" id="inputusername" type="text" class="form-control"
                            placeholder="Masukan username" aria-label="username" aria-describedby="username" />
                    </div>
                    <div id="isAdminError" class="text-danger"></div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="username">Peran</span>
                        <select class="form-control form-select" id="input_isAdmin">
                            <option disabled selected>Pilih Peran</option>
                            <option value="0">Biasa</option>
                            <option value="1">Admin</option>
                        </select>
                    </div>
                    <div id="passwordError" class="text-danger"></div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="Password">Password</span>
                        <input name="password" id="inputPassword" type="password" class="form-control"
                            placeholder="Masukan password" aria-label="Password" aria-describedby="Password"
                            autocomplete="new-password" />
                    </div>
                    <div id="fotoError" class="text-danger"></div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="fotoProfil">Foto Profil</span>
                        <input type="file" class="form-control" id="fotoProfilInput" name="foto_profil"
                            accept="image/*" />
                    </div>
                    <div class="mb-3 text-center">
                        <img src="" alt="Foto Profil" class="img-fluid d-none" id="fotoPreview"
                            style="max-width: 200px; border-radius: 50%; border: 2px solid #ddd;" />
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="tambah-akun">Tambah Akun</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
