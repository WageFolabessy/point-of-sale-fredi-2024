<div class="d-flex justify-content-center align-items-center">
    <a href="#" id="tombol-hapus" class="btn btn-danger btn-icon-split mb-4 mr-2" title="Hapus"
        data-id="{{ $pembelian->id }}">
        <span class="icon text-white-50">
            <i class="fas fa-trash"></i>
        </span>
    </a>
    <a href="#" id="tombol-edit" class="btn btn-warning btn-icon-split mb-4" title="Edit" data-toggle="modal"
        data-target="#modal-edit-pembelian" data-id="{{ $pembelian->id }}">
        <span class="icon text-white-50">
            <i class="fas fa-edit"></i>
        </span>
    </a>
</div>
