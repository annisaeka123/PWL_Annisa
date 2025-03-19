@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Kategori')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'Kagegori')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-end">
                    <a href="{{ url('/kategori/create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Kategori
                    </a>
                </div>
            </div>
            <div class="card-body">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
    $(document).on('click', '.delete-btn', function() {
        let id = $(this).data('id');
        if (confirm('Apakah Anda yakin ingin menghapus kategori ini?')) {
            $.ajax({
                url: "{{ url('/kategori') }}/" + id + "/delete",
                type: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    alert(response.success);
                    location.reload();
                },
                error: function(xhr) {
                    alert('Gagal menghapus kategori!');
                }
            });
        }
    });
</script>
@endpush

{{-- @section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Manage Kategori</div>
            <div class="card-body">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
@endsection --}}

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush