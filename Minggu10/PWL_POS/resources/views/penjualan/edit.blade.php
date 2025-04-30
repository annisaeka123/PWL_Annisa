@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ url('penjualan/' . $penjualan->penjualan_id) }}" class="form-horizontal">
            @csrf
            {!! method_field('PUT') !!}

            <div class="form-group row">
                <label class="col-1 control-label col-form-label">User</label>
                <div class="col-11">
                    <select class="form-control" name="user_id" required>
                        <option value="">- Pilih User -</option>
                        @foreach($user as $user)
                        <option value="{{ $user->user_id }}" @if($user->user_id == $penjualan->user_id) selected @endif>
                            {{ $user->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('user_id')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Pembeli</label>
                <div class="col-11">
                    <input type="text" class="form-control" name="pembeli" value="{{ old('pembeli', $penjualan->pembeli) }}" required>
                    @error('pembeli')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Kode Penjualan</label>
                <div class="col-11">
                    <input type="text" class="form-control" name="penjualan_kode" value="{{ old('penjualan_kode', $penjualan->penjualan_kode) }}" required>
                    @error('penjualan_kode')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Tanggal Penjualan</label>
                <div class="col-11">
                    <input type="date" class="form-control" name="penjualan_tanggal" value="{{ old('penjualan_tanggal', $penjualan->penjualan_tanggal) }}" required>
                    @error('penjualan_tanggal')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-11 offset-1">
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    <a href="{{ url('penjualan') }}" class="btn btn-sm btn-default ml-1">Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
