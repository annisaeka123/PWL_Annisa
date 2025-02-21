<!DOCTYPE html> 
<html> 
<head> 
    <title>Stok List</title> 
</head> 
<body> 
    <h1>Stok</h1> 
    @if(session('berhasil')) {{-- Mengecek apakah ada pesan sukses dalam session --}}
        <p>{{ session('berhasil')}}</p> {{-- Jika ada, pesan sukses akan ditampilkan dalam elemen <p> --}}
    @endif 
    <a href="{{ route('stoks.create') }}">Tambah Stok</a>  {{-- Membuat tombol yang mengarah ke halaman tambah stok (stoks.create) --}}
    <ul> 
        @foreach ($stoks as $stok)  {{-- Looping untuk menampilkan semua data stok --}}
            <li> 
                {{ $stok->{'nama_barang'} }} {{-- Menampilkan nama barang --}}
                <a href="{{ route('stoks.edit', $stok) }}">Edit</a>  {{-- Tombol untuk mengedit stok --}}
                <form action="{{ route('stoks.destroy', $stok) }}" method="POST" style="display:inline;">  {{-- Form untuk menghapus stok --}}
                    @csrf  {{-- Proteksi keamanan CSRF --}}
                    @method('DELETE') {{-- Mengubah method POST menjadi DELETE --}}
                    <button type="submit">Hapus</button> 
                </form> 
            </li> 
        @endforeach 
    </ul> 
</body> 
</html>