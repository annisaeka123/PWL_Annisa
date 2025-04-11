<!DOCTYPE html>
<html>
<head>
    <title>Data Stok</title>
</head>
<body>
    <h1>Data Stok</h1>
    <a href="/stok/tambah">Tambah Data</a>
    <table border="1" cellpadding="2" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Barang</th>
            <th>User</th>
            <th>Supplier</th>
            <th>Tanggal</th>
            <th>Jumlah</th>
            <th>Aksi</th>
        </tr>
        @foreach ($data as $row)
        <tr>
            <td>{{ $row->stok_id }}</td>
            <td>{{ $row->barang->barang_nama }}</td>
            <td>{{ $row->user->nama }}</td>
            <td>{{ $row->supplier->supplier_nama }}</td>
            <td>{{ $row->stok_tanggal }}</td>
            <td>{{ $row->stok_jumlah }}</td>
            <td>
                <a href="/stok/ubah/{{ $row->stok_id }}">Ubah</a>
                <a href="/stok/hapus/{{ $row->stok_id }}" onclick="return confirm('Hapus data ini?')">Hapus</a>
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>
