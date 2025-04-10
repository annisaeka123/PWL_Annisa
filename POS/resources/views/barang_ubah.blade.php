<!DOCTYPE html>
<html>
<head>
    <title>Ubah Barang</title>
</head>
<body>
    <h1>Form Ubah Barang</h1>
    <form method="post" action="/barang/ubah_simpan/{{ $data->barang_id }}">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <label>Kode</label>
        <input type="text" name="barang_kode" value="{{ $data->barang_kode }}" required><br>
        <label>Nama</label>
        <input type="text" name="barang_nama" value="{{ $data->barang_nama }}" required><br>
        <label>Kategori</label>
        <select name="kategori_id">
            @foreach ($kategori as $k)
                <option value="{{ $k->kategori_id }}" {{ $data->kategori_id == $k->kategori_id ? 'selected' : '' }}>
                    {{ $k->kategori_nama }}
                </option>
            @endforeach
        </select><br>
        <label>Harga Beli</label>
        <input type="number" name="harga_beli" value="{{ $data->harga_beli }}" required><br>
        <label>Harga Jual</label>
        <input type="number" name="harga_jual" value="{{ $data->harga_jual }}" required><br><br>
        <input type="submit" value="Ubah">
    </form>
</body>
</html>
