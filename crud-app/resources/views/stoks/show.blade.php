<!DOCTYPE html> 
<html> 
<head> 
    <title>Item List</title> 
</head> 
<body> 
    <h1>Items</h1> 
    @if(session('berhasil')) {{-- Menampilkan pesan sukses jika ada --}}
        <p>{{ session('berhasil') }}</p> 
    @endif 

    {{-- Tombol untuk menambah stok --}}
    <a href="{{ route('stoks.create') }}">Tambah Stok</a> 
    <ul> 
        @foreach ($stoks as $stok) 
        <li> 
            {{ $stok->nama_barang }} 
            <a href="{{ route('stoks.edit', $stok) }}">Edit</a>  {{-- Tombol Edit --}}

            {{-- Form untuk menghapus stok --}}
            <form action="{{ route('stoks.destroy', $stok) }}" method="POST" style="display:inline;"> 
                @csrf 
                @method('DELETE') 
                <button type="submit">Hapus</button> 
            </form> 
        </li> 
        @endforeach 
    </ul> 
</body> 
</html>