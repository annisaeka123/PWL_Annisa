<form action="{{ url('/penjualan/import_ajax') }}" method="POST" id="form-import-penjualan" enctype="multipart/form-data">
    @csrf
    <div id="modal-import-penjualan" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import Data Penjualan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label>Download Template</label><br>
                    <a href="{{ asset('template_penjualan.xlsx') }}" class="btn btn-info btn-sm" download>
                        <i class="fa fa-file-excel"></i> Download
                    </a>
                </div>

                <div class="form-group">
                    <label>Pilih File</label>
                    <input type="file" name="file_penjualan" id="file_penjualan" class="form-control" required>
                    <small id="error-file_penjualan" class="error-text form-text text-danger"></small>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Upload</button>
            </div>
        </div>
    </div>
</form>
