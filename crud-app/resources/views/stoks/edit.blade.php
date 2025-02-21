<!DOCTYPE html> 
<html> 
<head> 
    <title>Edit Stok</title> 
</head> 
<body> 
    <h1>Edit Stok</h1> 
    <form action="{{ route('stoks.update', $stok) }}" method="POST"> 
        @csrf 
        @method('PUT') 
        <label for="nama_barang">Nama Barang: </label> 
        <input type="text" name="nama_barang" required> 
        <br> 
        <label for="jumlah_barang">Jumlah Barang: </label> 
        <input type="text" name="jumlah_barang" required> 
        <br> 
        <button type="submit">Update Stok</button> 
    </form> 
    <a href="{{ route('stoks.index') }}">Kembali ke List</a> 
</body> 
</html>