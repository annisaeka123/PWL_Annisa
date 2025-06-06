@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <a class="btn btn-sm btn-primary mt-1" href="{{ url('kategori/create') }}">Tambah</a>
        </div>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <table class="table table-bordered table-striped table-hover table-sm" id="table_kategori">
            <thead>
                <tr>
                    <th>ID  </th>
                    <th>Kode Kategori</th>
                    <th>Nama Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@push('css')
@endpush

@push('js')
<script>
    $(document).ready(function() {
        var dataKategori = $('#table_kategori').DataTable({
            // serverSide: true, jika ingin menggunakan server side processing
            serverSide: true,
            ajax: {
                "url": "{{ url('kategori/list') }}",
                "dataType": "json",
                "type": "POST",
                "data": function (d) {
                    d.kategori_id = $('#kategori_id').val();
                }
            },
            columns: [
                {
                data: "kategori_id",
                className: "text-center",
                orderable: true,
                searchable: true
            }, {
                data: "kategori_kode",
                className: "",
                // orderable: true, jika ingin kolom ini bisa diurutkan
                orderable: false,
                // searchable: true, jika ingin kolom ini bisa dicari
                searchable: true
            }, {
                data: "kategori_nama",
                className: "",
                orderable: true,
                searchable: true
            }, {
                data: "aksi",
                className: "",
                orderable: false,   //orderable: true, jika ingin kolom ini bisa diurutkan
                searchable: false   //searchable: true, jika ingin kolom ini bisa dicari
            }
        ]
    });
    $('#kategori_id').on('change', function() {
        dataKategori.ajax.reload();
    });
});
</script>
@endpush

