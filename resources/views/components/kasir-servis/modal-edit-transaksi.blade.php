<div class="modal fade" id="modal-edit-transaksi">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Transaksi</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card p-3">
                    <div id="namaErrorEdit" class="text-danger"></div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="nama">Nama</span>
                        <input name="namaEdit" id="inputNamaEdit" type="text" class="form-control"
                            placeholder="Masukan Nama" aria-label="nama" aria-describedby="nama" />
                    </div>
                    <div id="noHpErrorEdit" class="text-danger"></div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="no_hp">Nomor HP</span>
                        <input name="no_hpEdit" id="inputNoHpEdit" type="number" class="form-control"
                            placeholder="Masukan No HP" aria-label="no_hp" aria-describedby="no_hp" />
                    </div>
                    <div id="jenisHpErrorEdit" class="text-danger"></div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="jenis_hp">Jenis HP</span>
                        <input name="jenis_hpEdit" id="inputJenisHpEdit" type="text" class="form-control"
                            placeholder="Masukan jenis HP" aria-label="jenis_hp" aria-describedby="jenis_hp" />
                    </div>
                    <div id="nomorImeiErrorEdit" class="text-danger"></div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="no_imei">No Imei</span>
                        <input name="no_imeiEdit" id="inputNoImeiEdit" type="text" class="form-control"
                            placeholder="Masukan Nomor Imei" aria-label="no_imei" aria-describedby="no_imei" />
                    </div>
                    <div id="statusErrorEdit" class="text-danger"></div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="status">Status</span>
                        <select class="form-control form-select" id="inputStatusEdit" name="inputStatusSelectEdit">
                            <option disabled selected>Pilih Status...</option>
                            <option value="0">Belum Selesai</option>
                            <option value="1">Selesai</option>
                        </select>
                    </div>
                </div>
                <section id="kerusakanList">
                    <div class="kerusakanEdit card p-3" id="kerusakanedit">
                        <h2 class="card-title text-body-secondary mb-3">
                            Keluhan / Jenis Kerusakan
                        </h2>
                        <div id="kerusakanError" class="text-danger"></div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="kerusakan">Kerusakan</span>
                            <input name="kerusakanEdit" id="inputKerusakanEdit" type="text" class="form-control"
                                placeholder="Masukkan Jenis Kerusakan" aria-label="kerusakan"
                                aria-describedby="kerusakan" />
                        </div>
                        <div id="hargaBeliError" class="text-danger"></div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="harga_beli">Harga Beli</span>
                            <input name="harga_beliEdit" id="inputHargaBeliEdit" type="number" class="form-control"
                                placeholder="Masukan Harga Beli" aria-label="harga_beli"
                                aria-describedby="harga_beli" />
                        </div>
                        <div id="hargaJualError" class="text-danger"></div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="harga_jual">Harga Jual</span>
                            <input name="harga_jualEdit" id="inputHargaJualEdit" type="number" class="form-control"
                                placeholder="Masukan Harga Jual" aria-label="harga_jual"
                                aria-describedby="harga_jual" />
                        </div>
                        <div id="biayaError" class="text-danger"></div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="biaya">Biaya</span>
                            <input name="biayaEdit" id="inputBiayaEdit" type="number" class="form-control"
                                placeholder="Masukkan Biaya Perbaikan" aria-label="biaya" aria-describedby="biaya" />
                        </div>
                    </div>
                    <button class="btn btn-primary mb-3 w-100" id="addKerusakanEdit" type="button">
                        Tambah Kerusakan
                    </button>
                    <div class="table-responsive">
                        <table id="tabelKerusakanEdit" class="table table-striped table-hover table-bordered text-center"
                            style="display: none">
                            <caption>
                                Daftar Kerusakan
                            </caption>
                            <tr>
                                <th>Kerusakan</th>
                                <th>Biaya</th>
                                <th>Harga Beli</th>
                                <th>Harga Jual</th>
                                <th>Aksi</th>
                            </tr>
                        </table>
                    </div>
                </section>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="edit-transaksi">Tambah Transaksi</button>
            </div>
        </div>
    </div>
</div>
