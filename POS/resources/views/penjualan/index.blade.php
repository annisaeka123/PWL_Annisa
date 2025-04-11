@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <a class="btn btn-sm btn-primary mt-1" href="{{ url('penjualan/create') }}">Tambah</a>
        </div>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <table class="table table-bordered table-striped table-hover table-sm text-center" id="table_penjualan">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kode</th>
                    <th>Pengguna</th>
                    <th>Pembeli</th>
                    <th>Tanggal</th>
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
        var dataPenjualan = $('#table_penjualan').DataTable({
            serverSide: true,
            ajax: {
                "url": "{{ url('penjualan/list') }}",
                "dataType": "json",
                "type": "POST",
                "data": function (d) {
                    d.user_id = $('#user_id').val();
                }
            },
            columns: [
                {
                    data: "penjualan_id",
                    className: "text-center",
                    orderable: true,
                    searchable: true
                }, {
                    data: "penjualan_kode",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "user.nama",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "pembeli",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "penjualan_tanggal",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "aksi",
                    className: "",
                    orderable: false,
                    searchable: false
                }
            ]
        });

        $('#user_id').on('change', function() {
            dataPenjualan.ajax.reload();
        });
    });
</script>
@endpush