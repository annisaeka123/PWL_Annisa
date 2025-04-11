<!DOCTYPE html>
<html>
<head>
    <title>Ubah Data Stok</title>
</head>
<body>
    <h1>Form Ubah Data Stok</h1>
    <a href="/stok">Kembali</a><br><br>
    <form method="post" action="/stok/ubah_simpan/{{ $stok->stok_id }}">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <label>Barang</label>
        <select name="barang_id">
            @foreach($barang as $b)
                <option value="{{ $b->barang_id }}" {{ $stok->barang_id == $b->barang_id ? 'selected' : '' }}>{{ $b->barang_nama }}</option>
            @endforeach
        </select><br>
        <label>User</label>
        <select name="user_id">
            @foreach($user as $u)
                <option value="{{ $u->user_id }}" {{ $stok->user_id == $u->user_id ? 'selected' : '' }}>{{ $u->nama }}</option>
            @endforeach
        </select><br>
        <label>Supplier</label>
        <select name="supplier_id">
            @foreach($supplier as $s)
                <option value="{{ $s->supplier_id }}" {{ $stok->supplier_id == $s->supplier_id ? 'selected' : '' }}>{{ $s->supplier_nama }}</option>
            @endforeach
        </select><br>
        <label>Tanggal</label>
        <input type="datetime-local" name="stok_tanggal" value="{{ \Carbon\Carbon::parse($stok->stok_tanggal)->format('Y-m-d\TH:i') }}"><br>
        <label>Jumlah</label>
        <input type="number" name="stok_jumlah" value="{{ $stok->stok_jumlah }}"><br><br>
        <input type="submit" value="Ubah">
    </form>
</body>
</html>
