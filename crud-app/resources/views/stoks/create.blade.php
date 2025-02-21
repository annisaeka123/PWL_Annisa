<!DOCTYPE html> 
<html> 
<head> 
    <title>Tambah Stok</title> 
</head> 
<body> 
    <h1>Tambah Stok</h1> 
    <form action="{{ route('stoks.store') }}" method="POST"> {{-- Form untuk menambahkan stok --}}
        @csrf {{-- Laravel CSRF protection untuk keamanan form --}}

        {{-- Input untuk Nama Barang --}}
        <label for="nama_barang">Nama Barang: </label> 
        <input type="text" name="nama_barang" required> 
        <br> 

         {{-- Input untuk Jumlah Barang --}}
        <label for="jumlah_barang">Jumlah Barang: </label> 
        <input type="text" name="jumlah_barang" required>  
        <br> 

         {{-- Tombol submit untuk menambah stok --}}
        <button type="submit">Tambah Stok</button> 
    </form> 

    <a href="{{ route('stoks.index') }}">Kembali ke List</a>  {{-- Tombol kembali ke halaman daftar stok --}}
</body> 
</html>