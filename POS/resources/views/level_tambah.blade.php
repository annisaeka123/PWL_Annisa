<!DOCTYPE html>
<html lang="id">

<head>
    <title>Tambah Level</title>
</head>

<body>
    <h1>Form Tambah Level</h1>
    <a href="/level">Kembali</a><br><br>
    
    <form method="POST" action="/level/tambah_simpan">
        {{ csrf_field() }}
        <label>Kode Level</label>
        <input type="text" name="level_kode" placeholder="Masukkan Kode Level"><br>

        <label>Nama Level</label>
        <input type="text" name="level_nama" placeholder="Masukkan Nama Level"><br><br>

        <input type="submit" class="btn btn-success" value="Simpan">
    </form>
</body>

</html>
