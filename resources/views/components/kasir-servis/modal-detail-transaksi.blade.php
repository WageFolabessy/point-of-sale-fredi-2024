<div class="modal fade" id="modal-detail-transaksi">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Transaksi</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card p-3">
                    <div id="namaError" class="text-danger"></div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="nama">Nama</span>
                        <input name="nama" id="inputNamaDetail" type="text" class="form-control"
                            placeholder="Masukan Nama" aria-label="nama" aria-describedby="nama" disabled />
                    </div>
                    <div id="noHpError" class="text-danger"></div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="no_hp">Nomor HP</span>
                        <input name="no_hp" id="inputNoHpDetail" type="number" class="form-control" placeholder=""
                            aria-label="no_hp" aria-describedby="no_hp" disabled />
                    </div>
                    <div id="jenisHpError" class="text-danger"></div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="jenis_hp">Jenis HP</span>
                        <input name="jenis_hp" id="inputJenisHpDetail" type="text" class="form-control"
                            placeholder="Masukan jenis HP" aria-label="jenis_hp" aria-describedby="jenis_hp" disabled />
                    </div>
                    <div id="nomorImeiError" class="text-danger"></div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="no_imei">No Imei</span>
                        <input name="no_imei" id="inputNoImeiDetail" type="text" class="form-control" placeholder=""
                            aria-label="no_imei" aria-describedby="no_imei" disabled />
                    </div>
                    <div id="statusError" class="text-danger"></div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="status">Status</span>
                        <select class="form-control form-select" id="inputStatusDetail" name="inputStatusDetailSelect"
                            disabled>
                            <option disabled selected>Pilih Status...</option>
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
                        <div class="table-responsive">
                            <table id="tabelKerusakanDetail"
                                class="table table-striped table-hover table-bordered text-center"
                                style="display: none">
                                <caption>
                                    Daftar Kerusakan
                                </caption>
                                <tr>
                                    <th>Kerusakan</th>
                                    <th>Biaya</th>
                                    <th>Harga Beli</th>
                                    <th>Harga Jual</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
