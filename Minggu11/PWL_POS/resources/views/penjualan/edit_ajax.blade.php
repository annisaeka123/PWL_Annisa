@empty($penjualan)
     <div id="modal-master" class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body">
                 <div class="alert alert-danger">
                     <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                     Data yang Anda cari tidak ditemukan
                 </div>
                 <a href="{{ url('penjualan') }}" class="btn btn-warning">Kembali</a>
             </div>
         </div>
     </div>
 @else
     <form action="{{ url('/penjualan/' . $penjualan->penjualan_id . '/update_ajax') }}" method="POST" id="form-edit">
         @csrf
         @method('PUT')
         <div id="modal-master" class="modal-dialog modal-lg" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLabel">Edit Data Transaksi</h5>
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
                        <label for="user_id">Pegawai</label>
                        <select name="user_id" id="user_id" class="form-control" required>
                            <option value="">- Pilih Pegawai -</option>
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
                     <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                     <button type="submit" class="btn btn-primary">Simpan</button>
                 </div>
             </div>
         </div>
     </form>
 
     <script>
         $(document).ready(function() {
             $("#form-edit").validate({
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
                 submitHandler: function(form) {
                     $.ajax({
                         url: form.action,
                         type: form.method,
                         data: $(form).serialize(),
                         success: function(response) {
                             if (response.status) {
                                 $('#myModal').modal('hide');
                                 Swal.fire({
                                     icon: 'success',
                                     title: 'Berhasil',
                                     text: response.message
                                 });
                                 dataPenjualan.ajax.reload();
                             } else {
                                 $('.error-text').text('');
                                 $.each(response.msgField, function(prefix, val) {
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
                 errorPlacement: function(error, element) {
                     error.addClass('invalid-feedback');
                     element.closest('.form-group').append(error);
                 },
                 highlight: function(element, errorClass, validClass) {
                     $(element).addClass('is-invalid');
                 },
                 unhighlight: function(element, errorClass, validClass) {
                     $(element).removeClass('is-invalid');
                 }
             });
         });
     </script>
 @endempty