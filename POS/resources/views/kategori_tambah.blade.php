<!DOCTYPE html>
<html lang="id">

<head>
    <title>Tambah Data Kategori</title>
</head>

<body>
    <h1>Form Tambah Data Kategori</h1>
    <form method="POST" action="/kategori/tambah_simpan">
        {{ csrf_field() }}
        
        <label>Kode Kategori</label>
        <input type="text" name="kategori_kode" placeholder="Masukkan Kode Kategori" required><br><br>
        
        <label>Nama Kategori</label>
        <input type="text" name="kategori_nama" placeholder="Masukkan Nama Kategori" required><br><br>

        <input type="submit" value="Simpan">
    </form>
    <br>
    <a href="/kategori">Kembali</a>
</body>

</html>
