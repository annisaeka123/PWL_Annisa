<form action="{{ url('stok/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Stok Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="barang_id">Barang</label>
                    <select name="barang_id" id="barang_id" class="form-control" required>
                        <option value="">- Pilih Barang -</option>
                        @foreach ($barang as $b)
                            <option value="{{ $b->barang_id }}">{{ $b->barang_nama }}</option>
                        @endforeach
                    </select>
                    <small id="error-barang_id" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label for="user_id">Pegawai</label>
                    <select name="user_id" id="user_id" class="form-control" required>
                        <option value="">- Pilih Pegawai -</option>
                        @foreach ($user as $u)
                            @if ($u->level->level_kode !== 'CUS')
                                <option value="{{ $u->user_id }}">{{ $u->nama }}</option>
                            @endif
                        @endforeach
                    </select>
                    <small id="error-user_id" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label for="supplier_id">Supplier</label>
                    <select name="supplier_id" id="supplier_id" class="form-control" required>
                        <option value="">- Pilih Supplier -</option>
                        @foreach ($supplier as $s)
                            <option value="{{ $s->supplier_id }}">{{ $s->supplier_nama }}</option>
                        @endforeach
                    </select>
                    <small id="error-supplier_id" class="error-text form-text text-danger"></small>
                </div>
                                               
                <div class="form-group">
                    <label for="tanggal">Tanggal Stok</label>
                    <input value="" type="date" name="stok_tanggal" id="stok_tanggal" class="form-control" required>
                    <small id="error-stok_tanggal" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Jumlah Stok</label>
                    <input value="" type="number" name="stok_jumlah" id="stok_jumlah" class="form-control" required>
                    <small id="error-stok_jumlah" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>
<script>
    $(document).ready(function () {
        $("#form-tambah").validate({
            rules: {
                barang_id: {
                    required: true,
                    number: true
                },
                user_id: {
                    required: true,
                    number: true
                },
                supplier_id: {
                    required: true,
                    number: true
                },
                stok_tanggal: {
                required: true,
                date: true  // yang divalidasi adalah tanggal
                },
                stok_jumlah: {
                    required: true,
                    number: true  // yang divalidasi adalah angka
                }
            },
            submitHandler: function (form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function (response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function (prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    $.ajax({
        type: "POST",
        url: "{{ url('stok/store_ajax') }}",
        data: $("#form-tambah").serialize(),
        success: function (response) {
            $('#form-tambah')[0].reset(); // Reset form
            $('#myModal').modal('hide'); // Tutup modal

            // Tampilkan SweetAlert
            Swal.fire({
                title: "Berhasil!",
                text: "Data user berhasil disimpan",
                icon: "success",
                confirmButtonText: "OK"
            });

            // Reload tabel agar data baru muncul
            $('#table_stok').DataTable().ajax.reload();
        },
        error: function (xhr) {
            Swal.fire({
                title: "Gagal!",
                text: "Terjadi kesalahan saat menyimpan data.",
                icon: "error",
                confirmButtonText: "OK"
            });
        }
    });
</script>