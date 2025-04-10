<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Stok</title>
</head>
<body>
    <h1>Form Tambah Data Stok</h1>
    <form method="post" action="/stok/tambah_simpan">
        {{ csrf_field() }}
        <label>Barang</label>
        <select name="barang_id">
            @foreach($barang as $b)
                <option value="{{ $b->barang_id }}">{{ $b->barang_nama }}</option>
            @endforeach
        </select><br>
        <label>User</label>
        <select name="user_id">
            @foreach($user as $u)
                <option value="{{ $u->user_id }}">{{ $u->nama }}</option>
            @endforeach
        </select><br>
        <label>Supplier</label>
        <select name="supplier_id">
            @foreach($supplier as $s)
                <option value="{{ $s->supplier_id }}">{{ $s->supplier_nama }}</option>
            @endforeach
        </select><br>
        <label>Tanggal</label>
        <input type="datetime-local" name="stok_tanggal"><br>
        <label>Jumlah</label>
        <input type="number" name="stok_jumlah"><br><br>
        <input type="submit" value="Simpan">
    </form>
</body>
</html>
