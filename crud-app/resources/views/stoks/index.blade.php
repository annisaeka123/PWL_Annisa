<!DOCTYPE html> 
<html> 
<head> 
    <title>Stok List</title> 
</head> 
<body> 
    <h1>Stok</h1> 
    @if(session('berhasil')) 
        <p>{{ session('berhasil')}}</p> 
    @endif 
    <a href="{{ route('stoks.create') }}">Tambah Stok</a> 
    <ul> 
        @foreach ($stoks as $stok) 
            <li> 
                {{ $stok->{'nama_barang'} }}
                <a href="{{ route('stoks.edit', $stok) }}">Edit</a> 
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