@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <button onclick="modalAction('{{ url('/stok/import') }}')" class="btn btn-sm btn-info mt-1">Import Stok</button>
            <a href="{{ url('/stok/export_excel') }}" class="btn btn-sm btn-primary mt-1"><i class="fa fa-file-excel"></i> Export Stok</a>
            <a href="{{ url('/stok/export_pdf') }}" class="btn btn-sm btn-warning mt-1"><i class="fa fa-file-pdf"></i> Export Stok</a>
            <button onclick="modalAction('{{ url('stok/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah Stok</button>
        </div>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <table class="table table-bordered table-striped table-hover table-sm text-center" id="table_stok">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Supplier</th>
                    <th>Barang</th>
                    <th>Pegawai</th>
                    <th>Tanggal Stok</th>
                    <th>Jumlah Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('css')
@endpush

@push('js')
<script>
    function modalAction(url = '') {
        $('#myModal').load(url, function () {
            $('#myModal').modal('show');
        });
    }

    var dataStok;
    $(document).ready(function() {
        dataStok = $('#table_stok').DataTable({
            // serverSide: true, jika ingin menggunakan server side processing
            serverSide: true,
            ajax: {
                "url": "{{ url('stok/list') }}",
                "dataType": "json",
                "type": "POST",
                "data": function (d) {
                    d.supplier_id = $('#supplier_id').val();
                }
            },
            columns: [
                {
                    data: "stok_id",
                    className: "text-center",
                    orderable: true,
                    searchable: true
                }, {
                    data: "supplier.supplier_nama",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "barang.barang_nama",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "user.nama",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "stok_tanggal",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "stok_jumlah",
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

        $('#supplier_id').on('change', function() {
            dataStok.ajax.reload();
        });
    });
</script>
@endpush