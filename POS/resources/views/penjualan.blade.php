<!DOCTYPE html>
<html>
<head>
    <title>Data Penjualan</title>
</head>
<body>
    <h1>Data Penjualan</h1>
    <a href="/penjualan/tambah">Tambah Data</a>
    <table border="1" cellpadding="2" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Kode</th>
            <th>Pembeli</th>
            <th>Tanggal</th>
            <th>User</th>
            <th>Aksi</th>
        </tr>
        @foreach ($data as $row)
        <tr>
            <td>{{ $row->penjualan_id }}</td>
            <td>{{ $row->penjualan_kode }}</td>
            <td>{{ $row->pembeli }}</td>
            <td>{{ $row->penjualan_tanggal }}</td>
            <td>{{ $row->user->nama }}</td>
            <td>
                <a href="/penjualan/ubah/{{ $row->penjualan_id }}">Ubah</a>
                <a href="/penjualan/hapus/{{ $row->penjualan_id }}" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>
