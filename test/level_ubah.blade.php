<!DOCTYPE html>
<html lang="id">

<head>
    <title>Ubah Level</title>
</head>

<body>
    <h1>Form Ubah Level</h1>
    <a href="/level">Kembali</a><br><br>
    
    <form method="POST" action="/level/ubah_simpan/{{ $level->level_id }}">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <label>Kode Level</label>
        <input type="text" name="level_kode" value="{{ $level->level_kode }}" placeholder="Masukkan Kode Level"><br>

        <label>Nama Level</label>
        <input type="text" name="level_nama" value="{{ $level->level_nama }}" placeholder="Masukkan Nama Level"><br><br>

        <input type="submit" class="btn btn-success" value="Ubah">
    </form>
</body>

</html>
