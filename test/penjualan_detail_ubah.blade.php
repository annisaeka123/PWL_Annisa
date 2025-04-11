@extends('template.master')

@section('konten')
<form action="{{ url('penjualan_detail/ubah_simpan/' . $data->detail_id) }}" method="POST">
    @csrf
    @method('PUT')
    Penjualan:
    <select name="penjualan_id" class="form-control">
        @foreach($penjualan as $p)
        <option value="{{ $p->penjualan_id }}" {{ $data->penjualan_id == $p->penjualan_id ? 'selected' : '' }}>{{ $p->penjualan_kode }}</option>
        @endforeach
    </select>
    Barang:
    <select name="barang_id" class="form-control">
        @foreach($barang as $b)
        <option value="{{ $b->barang_id }}" {{ $data->barang_id == $b->barang_id ? 'selected' : '' }}>{{ $b->barang_nama }}</option>
        @endforeach
    </select>
    Harga:
    <input type="number" name="harga" value="{{ $data->harga }}" class="form-control">
    Jumlah:
    <input type="number" name="jumlah" value="{{ $data->jumlah }}" class="form-control">
    <button class="btn btn-primary mt-2">Ubah</button>
</form>
@endsection
