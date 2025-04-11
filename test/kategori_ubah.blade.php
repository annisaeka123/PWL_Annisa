<!DOCTYPE html>
<html lang="id">

<head>
    <title>Ubah Data Kategori</title>
</head>

<body>
    <h1>Form Ubah Data Kategori</h1>
    <a href="/kategori">Kembali</a><br><br>

    <form method="POST" action="/kategori/ubah_simpan/{{ $data->kategori_id }}">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <label>Kode Kategori</label>
        <input type="text" name="kategori_kode" value="{{ $data->kategori_kode }}" required><br><br>

        <label>Nama Kategori</label>
        <input type="text" name="kategori_nama" value="{{ $data->kategori_nama }}" required><br><br>

        <input type="submit" value="Ubah">
    </form>
</body>

</html>
