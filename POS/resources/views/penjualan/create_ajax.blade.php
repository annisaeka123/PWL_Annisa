<form action="{{ url('/penjualan/ajax') }}" method="POST" id="form-tambah-penjualan">
    @csrf
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Transaksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="penjualan_kode">Kode Transaksi</label>
                    <input type="text" name="penjualan_kode" id="penjualan_kode" class="form-control" required>
                    <small id="error-penjualan_kode" class="form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label for="user_id">Pengguna</label>
                    <select name="user_id" id="user_id" class="form-control" required>
                        <option value="">- Pilih Pengguna -</option>
                        @foreach ($user as $u)
                            <option value="{{ $u->user_id }}">{{ $u->nama }}</option>
                        @endforeach
                    </select>
                    <small id="error-user_id" class="form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label for="pembeli">Pembeli</label>
                    <input type="text" name="pembeli" id="pembeli" class="form-control" required>
                    <small id="error-pembeli" class="form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label for="penjualan_tanggal">Tanggal Transaksi</label>
                    <input type="date" name="penjualan_tanggal" id="penjualan_tanggal" class="form-control" required>
                    <small id="error-penjualan_tanggal" class="form-text text-danger"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>

<!-- jQuery Validate & AJAX Script -->
<script>
    $(document).ready(function () {
        $("#form-tambah-penjualan").validate({
            rules: {
                penjualan_kode: {
                    required: true,
                    minlength: 2,
                    maxlength: 10
                },
                nama: {
                    required: true,
                    minlength: 3,
                    maxlength: 100
                }
                pembeli: {
                    required: true,
                    minlength: 3,
                    maxlength: 100
                }
                penjualan_tanggal: {
                    required: true
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
                            $('#table_penjualan').DataTable().ajax.reload();
                            form.reset();
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function (prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: response.message
                            });
                        }
                    },
                    errorElement: 'span',
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: 'Gagal menyimpan data.'
                        });
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

<!-- SweetAlert CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    $.ajax({
        type: "POST",
        url: "{{ url('penjualan/store_ajax') }}",
        data: $("#form-tambah").serialize(),
        success: function (response) {
            $('#form-tambah')[0].reset(); // Reset form
            $('#myModal').modal('hide'); // Tutup modal

            // Tampilkan SweetAlert
            Swal.fire({
                title: "Berhasil!",
                text: "Data berhasil disimpan",
                icon: "success",
                confirmButtonText: "OK"
            });

            // Reload tabel agar data baru muncul
            $('#table_penjualan').DataTable().ajax.reload();
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
