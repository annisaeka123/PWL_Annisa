<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Supplier</title>
</head>
<body>
    <h1>Form Tambah Data Supplier</h1>
    <form method="post" action="/supplier/tambah_simpan">
        {{ csrf_field() }}
        <label>Kode</label>
        <input type="text" name="supplier_kode" placeholder="Masukan Kode Supplier"><br>
        <label>Nama</label>
        <input type="text" name="supplier_nama" placeholder="Masukan Nama Supplier"><br>
        <label>Alamat</label>
        <textarea name="supplier_alamat" placeholder="Masukan Alamat Supplier"></textarea><br><br>
        <input type="submit" value="Simpan">
    </form>
</body>
</html>
