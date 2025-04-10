<!DOCTYPE html>
<html lang="id">

<head>
    <title>Data Kategori</title>
</head>

<body>
    <h1>Data Kategori</h1>
    <a href="/kategori/tambah">+ Tambah Kategori</a>
    <table border="1" cellpadding="2" cellspacing="0">
        <tr>
            <td>ID</td>
            <td>Kode Kategori</td>
            <td>Nama Kategori</td>
            <td>Aksi</td>
        </tr>
        @foreach ($data as $kategori)
        <tr>
            <td>{{ $kategori->kategori_id }}</td>
            <td>{{ $kategori->kategori_kode }}</td>
            <td>{{ $kategori->kategori_nama }}</td>
            <td>
                <a href="/kategori/ubah/{{ $kategori->kategori_id }}">Ubah</a> |
                <a href="/kategori/hapus/{{ $kategori->kategori_id }}">Hapus</a>
            </td>
        </tr>
        @endforeach
    </table>
</body>

</html>
