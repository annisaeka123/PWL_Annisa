@extends('template.master')

@section('konten')
<form action="{{ url('penjualan_detail/tambah_simpan') }}" method="POST">
    @csrf
    Penjualan:
    <select name="penjualan_id" class="form-control">
        @foreach($penjualan as $p)
        <option value="{{ $p->penjualan_id }}">{{ $p->penjualan_kode }}</option>
        @endforeach
    </select>
    Barang:
    <select name="barang_id" class="form-control">
        @foreach($barang as $b)
        <option value="{{ $b->barang_id }}">{{ $b->barang_nama }}</option>
        @endforeach
    </select>
    Harga:
    <input type="number" name="harga" class="form-control">
    Jumlah:
    <input type="number" name="jumlah" class="form-control">
    <button class="btn btn-primary mt-2">Simpan</button>
</form>
@endsection
