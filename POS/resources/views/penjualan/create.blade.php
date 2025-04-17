@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Tambah Penjualan</h3>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('penjualan.store') }}">
            @csrf

            <div class="form-group row">
                <label for="user_id" class="col-2 control-label">Pegawai</label>
                <div class="col-10">
                    <select name="user_id" id="user_id" class="form-control" required>
                        <option value="">Pilih Pegawai</option>
                        @foreach($users as $user)
                            <option value="{{ $user->user_id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="pembeli" class="col-2 control-label">Pembeli</label>
                <div class="col-10">
                    <input type="text" name="pembeli" id="pembeli" class="form-control" required>
                    @error('pembeli')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="penjualan_kode" class="col-2 control-label">Kode Penjualan</label>
                <div class="col-10">
                    <input type="text" name="penjualan_kode" id="penjualan_kode" class="form-control" required>
                    @error('penjualan_kode')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="penjualan_tanggal" class="col-2 control-label">Tanggal Penjualan</label>
                <div class="col-10">
                    <input type="date" name="penjualan_tanggal" id="penjualan_tanggal" class="form-control" required>
                    @error('penjualan_tanggal')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-10 offset-2">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
