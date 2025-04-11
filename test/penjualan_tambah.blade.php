<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Penjualan</title>
</head>
<body>
    <h1>Form Tambah Data Penjualan</h1>
    <form method="post" action="/penjualan/tambah_simpan">
        {{ csrf_field() }}
        <label>Kode Penjualan</label>
        <input type="text" name="penjualan_kode"><br>
        <label>Pembeli</label>
        <input type="text" name="pembeli"><br>
        <label>Tanggal</label>
        <input type="date" name="penjualan_tanggal"><br>
        <label>User</label>
        <select name="user_id">
            @foreach($user as $u)
                <option value="{{ $u->user_id }}">{{ $u->nama }}</option>
            @endforeach
        </select><br><br>
        <input type="submit" value="Simpan">
    </form>
</body>
</html>
