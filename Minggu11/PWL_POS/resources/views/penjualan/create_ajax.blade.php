<form action="{{ url('/penjualan/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Tambah Penjualan</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- Header Penjualan --}}
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Petugas</label>
                            <select name="user_id" id="user_id" class="form-control" required>
                                <option value="">- Pilih Petugas -</option>
                                @foreach($user as $user)
                                    <option value="{{ $user->user_id }}">{{ $user->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Pembeli</label>
                            <input type="text" name="pembeli" id="pembeli" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Kode Penjualan</label>
                            <input type="text" name="penjualan_kode" id="penjualan_kode" class="form-control" required maxlength="20">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Tanggal Penjualan</label>
                            <input type="date" name="penjualan_tanggal" id="penjualan_tanggal" class="form-control" required>
                        </div>
                    </div>
                </div>

                {{-- Detail Penjualan --}}
                <hr>
                <h6 class="font-weight-bold">Detail Barang</h6>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="table-detail">
                        <thead class="thead-light">
                            <tr>
                                <th>Barang</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th class="text-center" style="width: 40px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <select name="barang_id[]" class="form-control" required>
                                        <option value="">- Pilih Barang -</option>
                                        @foreach($barang as $b)
                                            <option value="{{ $b->barang_id }}" data-harga="{{ $b->harga_jual }}">{{ $b->barang_nama }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="harga[]" class="form-control" min="1" readonly required>
                                </td>
                                <td>
                                    <input type="number" name="jumlah[]" class="form-control" min="1" value="1" required>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-danger btn-remove-row">&times;</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="text-right mb-3">
                    <button type="button" id="btn-add-row" class="btn btn-sm btn-outline-primary">+ Tambah Barang</button>
                </div>
            </div>

            <div class="modal-footer bg-light">
                <button type="button" data-dismiss="modal" class="btn btn-secondary">Batal</button>
                <button type="submit" class="btn btn-success">Simpan Penjualan</button>
            </div>
        </div>
    </div>
</form>

<script>
$(document).ready(function() {
    function recalcRow(row) {
        const hargaJual = parseFloat(row.find('select[name="barang_id[]"] option:selected').data('harga')) || 0;
        const jumlah   = parseInt(row.find('input[name="jumlah[]"]').val()) || 0;
        row.find('input[name="harga[]"]').val(hargaJual * jumlah);
    }

    $('#btn-add-row').click(function() {
        let row = $('#table-detail tbody tr:first').clone();
        row.find('select').val('');
        row.find('input[name="jumlah[]"]').val(1);
        row.find('input[name="harga[]"]').val('');
        $('#table-detail tbody').append(row);
    });

    $('#table-detail').on('click', '.btn-remove-row', function() {
        if ($('#table-detail tbody tr').length > 1) {
            $(this).closest('tr').remove();
        }
    });

    $('#table-detail').on('change', 'select[name="barang_id[]"]', function() {
        recalcRow($(this).closest('tr'));
    });

    $('#table-detail').on('input', 'input[name="jumlah[]"]', function() {
        recalcRow($(this).closest('tr'));
    });

    $('#form-tambah').validate({
        rules: {
            user_id: { required: true, number: true },
            pembeli: { required: true, minlength: 3 },
            penjualan_tanggal: { required: true, date: true },
            'barang_id[]': { required: true, number: true },
            'harga[]': { required: true, number: true, min: 1 },
            'jumlah[]': { required: true, number: true, min: 1 }
        },
        errorElement: 'span',
        errorClass: 'invalid-feedback',
        errorPlacement: function(error, element) {
            element.closest('td, .form-group').append(error);
        },
        highlight: function(el) { $(el).addClass('is-invalid'); },
        unhighlight: function(el) { $(el).removeClass('is-invalid'); },

        submitHandler: function(form) {
            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                success: function(res) {
                    if (res.status) {
                        $('#myModal').modal('hide');
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message });
                        dataPenjualan.ajax.reload();
                    } else {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: res.message });
                    }
                },
                error: function(xhr) {
                    let msg = 'Terjadi kesalahan server.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    }
                    Swal.fire({ icon: 'error', title: 'Error', text: msg });
                }
            });
            return false;
        }
    });
});
</script>
