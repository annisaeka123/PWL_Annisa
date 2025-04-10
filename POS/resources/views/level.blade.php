<!DOCTYPE html>
<html lang="id">

<head>
    <title>Data Level</title>
</head>

<body>
    <h1>Data Level</h1>
    <a href="/level/tambah">+ Tambah Level</a>
    <table border="1" cellpadding="2" cellspacing="0">
        <tr>
            <td>ID</td>
            <td>Kode Level</td>
            <td>Nama Level</td>
            <td>Aksi</td>
        </tr>
        @foreach ($levels as $level)
        <tr>
            <td>{{ $level->level_id }}</td>
            <td>{{ $level->level_kode }}</td>
            <td>{{ $level->level_nama }}</td>
            <td>
                <a href="/level/ubah/{{ $level->level_id }}">Ubah</a> |
                <a href="/level/hapus/{{ $level->level_id }}" onclick="return confirm('Apakah Anda yakin ingin menghapus level ini?')">Hapus</a>
            </td>
        </tr>
        @endforeach
    </table>
</body>

</html>
