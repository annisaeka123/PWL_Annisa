<!DOCTYPE html>
<html>
    <head>
        <title>Data Kategori Barang</title>
    </head>
    <body>
        <h1>Data Kategori Barang</h1>
        <table border="1" cellpadding="2" cellspacing="0">
            <tr>
                <th>ID</th>
                <th>ID Kategori</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
            </tr>
            @foreach ($data as $d)
            <tr>
                <td>{{ $d->barang_id }}</td>
                <td>{{ $d->kategori_id }}</td>
                <td>{{ $d->barang_kode }}</td>
                <td>{{ $d->barang_nama }}</td>
                <td>{{ $d->harga_beli }}</td>
                <td>{{ $d->harga_jual }}</td>
            </tr>
            @endforeach
        </table>
    </body>
</html>