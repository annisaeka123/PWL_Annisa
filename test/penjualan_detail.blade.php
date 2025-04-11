<!DOCTYPE html>
<html>
<head>
    <title>Data Penjualan Detail</title>
</head>
<body>
    <h1>Data Penjualan Detail</h1>
    <a href="/penjualan_detail/tambah">Tambah Data</a>
    <table border="1" cellpadding="2" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Kode Penjualan</th>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Aksi</th>
        </tr>
        @foreach ($data as $row)
        <tr>
            <td>{{ $row->detail_id }}</td>
            <td>{{ $row->penjualan->penjualan_kode ?? '-' }}</td>
            <td>{{ $row->barang->barang_nama ?? '-' }}</td>
            <td>{{ $row->harga }}</td>
            <td>{{ $row->jumlah }}</td>
            <td>
                <a href="/penjualan_detail/ubah/{{ $row->detail_id }}">Ubah</a>
                <a href="/penjualan_detail/hapus/{{ $row->detail_id }}" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>
