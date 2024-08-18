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
                <div class="card p-3">
                    <div id="namaError" class="text-danger"></div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="nama">Nama</span>
                        <input name="nama" id="inputNama" type="text" class="form-control"
                            placeholder="Masukan Nama" aria-label="nama" aria-describedby="nama" />
                    </div>
                    <div id="noHpError" class="text-danger"></div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="no_hp">Nomor HP</span>
                        <input name="no_hp" id="inputNoHp" type="number" class="form-control"
                            placeholder="Masukan No HP" aria-label="no_hp" aria-describedby="no_hp" />
                    </div>
                    <div id="jenisHpError" class="text-danger"></div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="jenis_hp">Jenis HP</span>
                        <input name="jenis_hp" id="inputJenisHp" type="text" class="form-control"
                            placeholder="Masukan jenis HP" aria-label="jenis_hp" aria-describedby="jenis_hp" />
                    </div>
                    <div id="nomorImeiError" class="text-danger"></div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="no_imei">No Imei</span>
                        <input name="no_imei" id="inputNoImei" type="text" class="form-control"
                            placeholder="Masukan Nomor Imei" aria-label="no_imei" aria-describedby="no_imei" />
                    </div>
                    <div id="statusError" class="text-danger"></div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="status">Status</span>
                        <select class="form-control form-select" id="inputStatus" name="inputStatus">
                            <option disabled selected value="-1" >Pilih Status...</option>
                            <option value="0">Belum Selesai</option>
                            <option value="1">Selesai</option>
                        </select>
                    </div>
                </div>
                <section id="kerusakanList">
                    <div class="kerusakan card p-3" id="kerusakan1">
                        <h2 class="card-title text-body-secondary mb-3">
                            Keluhan / Jenis Kerusakan
                        </h2>
                        <div id="kerusakanError" class="text-danger"></div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="kerusakan">Kerusakan</span>
                            <input name="kerusakan" id="inputKerusakan" type="text" class="form-control"
                                placeholder="Masukkan Jenis Kerusakan" aria-label="kerusakan"
                                aria-describedby="kerusakan" />
                        </div>
                        <div id="hargaBeliError" class="text-danger"></div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="harga_beli">Harga Beli</span>
                            <input name="harga_beli" id="inputHargaBeli" type="number" class="form-control"
                                placeholder="Masukan Harga Beli" aria-label="harga_beli"
                                aria-describedby="harga_beli" />
                        </div>
                        <div id="hargaJualError" class="text-danger"></div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="harga_jual">Harga Jual</span>
                            <input name="harga_jual" id="inputHargaJual" type="number" class="form-control"
                                placeholder="Masukan Harga Jual" aria-label="harga_jual"
                                aria-describedby="harga_jual" />
                        </div>
                        <div id="biayaError" class="text-danger"></div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="biaya">Biaya</span>
                            <input name="biaya" id="inputBiaya" type="number" class="form-control"
                                placeholder="Masukkan Biaya Perbaikan" aria-label="biaya" aria-describedby="biaya" />
                        </div>
                    </div>
                    <button class="btn btn-primary mb-3 w-100" id="addKerusakan" type="button">
                        Tambah Kerusakan
                    </button>
                    <div class="table-responsive">
                        <table id="tabelKerusakan" class="table table-striped table-hover table-bordered text-center"
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
                <button type="button" class="btn btn-primary" id="tambah-transaksi">Tambah Transaksi</button>
            </div>
        </div>
    </div>
</div>
