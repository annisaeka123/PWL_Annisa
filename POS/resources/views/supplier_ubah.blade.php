<!DOCTYPE html>
<html>
<head>
    <title>Ubah Data Supplier</title>
</head>
<body>
    <h1>Form Ubah Data Supplier</h1>
    <a href="/supplier">Kembali</a><br><br>
    <form method="post" action="/supplier/ubah_simpan/{{ $data->supplier_id }}">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <label>Kode</label>
        <input type="text" name="supplier_kode" value="{{ $data->supplier_kode }}"><br>
        <label>Nama</label>
        <input type="text" name="supplier_nama" value="{{ $data->supplier_nama }}"><br>
        <label>Alamat</label>
        <textarea name="supplier_alamat">{{ $data->supplier_alamat }}</textarea><br><br>
        <input type="submit" value="Ubah">
    </form>
</body>
</html>
