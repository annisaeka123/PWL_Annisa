@empty($penjualanDetail)
    <div id="modal-master" class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang Anda cari tidak ditemukan
                </div>
                <a href="{{ url('/penjualanDetail') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/penjualanDetail/' . $penjualanDetail->detail_id . '/delete_ajax') }}" method="POST" id="form-delete-level">
        @csrf
        @method('DELETE')

        <div id="modal-master" class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Data Level</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <h5><i class="icon fas fa-ban"></i> Konfirmasi !!!</h5>
                        Apakah Anda yakin ingin menghapus data level berikut ini?
                    </div>
                    <table class="table table-sm table-bordered table-striped">
                        <tr>
                            <th class="text-right col-4">ID Transaksi Penjualan :</th>
                            <td class="col-8">{{ $penjualanDetail->penjuala->penjualan_ID }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-4">Barang :</th>
                            <td class="col-8">{{ $penjualanDetail->barang->barang_nama }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-4">Jumlah Barang :</th>
                            <td class="col-8">{{ $penjualanDetail->jumlah }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-4">Harga Total :</th>
                            <td class="col-8">{{ $penjualanDetail->harga }}</td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function () {
            $("#form-delete-penjualanDetail").validate({
                rules: {},
                submitHandler: function (form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function (response) {
                            if (response.status) {
                                $("#myModal").modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                });
                                $('#table_penjualanDetail').DataTable().ajax.reload();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    text: response.message
                                });
                            }
                        },
                        error: function () {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Terjadi kesalahan saat menghapus data level.'
                            });
                        }
                    });
                    return false;
                }
            });
        });
    </script>
@endempty
