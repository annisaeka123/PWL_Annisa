@extends('adminlte::page')

@section('title', 'Edit Kategori')

@section('content_header')
    <h1>Edit Kategori</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('kategori.update', $kategori->kategori_id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="kodeKategori">Kode Kategori</label>
                    <input type="text" name="kodeKategori" id="kodeKategori" class="form-control" value="{{ $kategori->kategori_kode }}" required>
                </div>
                <div class="form-group">
                    <label for="namaKategori">Nama Kategori</label>
                    <input type="text" name="namaKategori" id="namaKategori" class="form-control" value="{{ $kategori->kategori_nama }}" required>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Update</button>
                <a href="{{ url('/kategori') }}" class="btn btn-secondary mt-3">Batal</a>
            </form>
        </div>
    </div>
@stop
