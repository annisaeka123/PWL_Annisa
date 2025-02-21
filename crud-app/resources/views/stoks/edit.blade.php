<!DOCTYPE html> 
<html> 
<head> 
    <title>Edit Stok</title> 
</head> 
<body> 
    <h1>Edit Stok</h1> 

    {{-- Form untuk mengedit stok --}}
    <form action="{{ route('stoks.update', $stok) }}" method="POST"> 
        @csrf {{-- Laravel CSRF protection untuk keamanan form --}}
        @method('PUT') {{-- Metode HTTP untuk update data --}}

        {{-- Input Nama Barang (Menggunakan Value Default dari Database) --}}
        <label for="nama_barang">Nama Barang: </label> 
        <input type="text" name="nama_barang" required> 
        <br> 

        {{-- Input Jumlah Barang (Menggunakan Value Default dari Database) --}}
        <label for="jumlah_barang">Jumlah Barang: </label> 
        <input type="text" name="jumlah_barang" required> 
        <br> 

        {{-- Tombol submit untuk menyimpan perubahan --}}
        <button type="submit">Update Stok</button> 
    </form> 

    <a href="{{ route('stoks.index') }}">Kembali ke List</a> {{-- Tombol kembali ke halaman daftar stok --}}
</body> 
</html>