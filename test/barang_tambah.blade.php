<!DOCTYPE html>
<html>
<head>
    <title>Tambah Barang</title>
</head>
<body>
    <h1>Form Tambah Barang</h1>
    <form method="post" action="/barang/tambah_simpan">
        {{ csrf_field() }}
        <label>Kode</label>
        <input type="text" name="barang_kode" required><br>
        <label>Nama</label>
        <input type="text" name="barang_nama" required><br>
        <label>Kategori</label>
        <select name="kategori_id">
            @foreach ($kategori as $k)
                <option value="{{ $k->kategori_id }}">{{ $k->kategori_nama }}</option>
            @endforeach
        </select><br>
        <label>Harga Beli</label>
        <input type="number" name="harga_beli" required><br>
        <label>Harga Jual</label>
        <input type="number" name="harga_jual" required><br><br>
        <input type="submit" value="Simpan">
    </form>
</body>
</html>
