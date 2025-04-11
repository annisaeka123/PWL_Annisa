<!DOCTYPE html>
<html>
<head>
    <title>Data Supplier</title>
</head>
<body>
    <h1>Data Supplier</h1>
    <a href="/supplier/tambah">Tambah Data</a>
    <table border="1" cellpadding="2" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Kode</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>
        @foreach ($data as $row)
        <tr>
            <td>{{ $row->supplier_id }}</td>
            <td>{{ $row->supplier_kode }}</td>
            <td>{{ $row->supplier_nama }}</td>
            <td>{{ $row->supplier_alamat }}</td>
            <td>
                <a href="/supplier/ubah/{{ $row->supplier_id }}">Ubah</a>
                <a href="/supplier/hapus/{{ $row->supplier_id }}" onclick="return confirm('Hapus data ini?')">Hapus</a>
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>
