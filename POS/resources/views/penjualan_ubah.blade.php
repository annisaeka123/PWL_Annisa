<!DOCTYPE html>
<html>
<head>
    <title>Ubah Data Penjualan</title>
</head>
<body>
    <h1>Form Ubah Data Penjualan</h1>
    <a href="/penjualan">Kembali</a><br><br>
    <form method="post" action="/penjualan/ubah_simpan/{{ $penjualan->penjualan_id }}">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <label>Kode Penjualan</label>
        <input type="text" name="penjualan_kode" value="{{ $penjualan->penjualan_kode }}"><br>
        <label>Pembeli</label>
        <input type="text" name="pembeli" value="{{ $penjualan->pembeli }}"><br>
        <label>Tanggal</label>
        <input type="date" name="penjualan_tanggal" value="{{ $penjualan->penjualan_tanggal }}"><br>
        <label>User</label>
        <select name="user_id">
            @foreach($user as $u)
                <option value="{{ $u->user_id }}" {{ $penjualan->user_id == $u->user_id ? 'selected' : '' }}>{{ $u->nama }}</option>
            @endforeach
        </select><br><br>
        <input type="submit" value="Ubah">
    </form>
</body>
</html>
