<!DOCTYPE html> 
<html> 
<head> 
    <title>Tambah Stok</title> 
</head> 
<body> 
    <h1>Tambah Stok</h1> 
    <form action="{{ route('stoks.store') }}" method="POST"> 
        @csrf 
        <label for="nama_barang">Nama Barang: </label> 
        <input type="text" name="nama_barang" required> 
        <br> 
        <label for="jumlah_barang">Jumlah Barang: </label> 
        <input type="text" name="jumlah_barang" required>  
        <br> 
        <button type="submit">Tambah Stok</button> 
    </form> 
    <a href="{{ route('stoks.index') }}">Kembali ke List</a> 
</body> 
</html>