<!DOCTYPE html>
<html>
<head>
    <title>Data User</title>
</head>
<body>
    <h1>Data User</h1>
    <a href="/user/tambah">+ Tambah User</a>
    <table border="1" cellpadding="2" cellspacing="0">
        
        <!--JOBSHEET 4-->

        <!-- PRAKTIKUM 2.7 - LANGKAH 5 -->
        <tr>
            <td>ID</td>
            <td>Username</td>
            <td>Nama</td>
            <td>ID Level Pengguna</td>
            <td>Kode Level</td>
            <td>Nama Level</td>
            <td>Aksi</td>
        </tr>
        @foreach ($data as $d)
        <tr>
            <td>{{ $d->user_id }}</td>
            <td>{{ $d->username }}</td>
            <td>{{ $d->nama }}</td>
            <td>{{ $d->level_id }}</td>
            <td>{{ $d->level->level_kode }}</td>
            <td>{{ $d->level->level_nama }}</td>
            <td><a href="/user/ubah/{{ $d->user_id }}">Ubah</a></td>
            <td><a href="/user/hapus/{{ $d->user_id }}">Hapus</a></td>
        </tr>
        @endforeach
        
        <!-- PRAKTIKUM 2.6 - LANGKAH 1 -->
        {{-- <tr>
            <td>ID</td>
            <td>Username</td>
            <td>Nama</td>
            <td>ID Level Pengguna</td>
            <td>Aksi</td>
        </tr>
        @foreach ($data as $d)
        <tr>
            <td>{{ $d->user_id }}</td>
            <td>{{ $d->username }}</td>
            <td>{{ $d->nama }}</td>
            <td>{{ $d->level_id }}</td>
            <td><a href="/user/ubah/{{ $d->user_id }}">Ubah</a></td>
            <td><a href="/user/hapus/{{ $d->user_id }}">Hapus</a></td>
        </tr>
        @endforeach --}}

        <!--------------------------------------->

        <!-- PRAKTIKUM 2.3 -->
        {{-- <tr>
            <th>Jumlah Pengguna</th>
        </tr>
        <tr>
            <td>{{ $data }}</td>
        </tr> --}}

        <!--------------------------------------->
        <!--PRAKTIKUM 2.1/2.4-->
        {{-- <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Nama</th>
            <th>ID Level Pengguna</th>
        </tr> --}}
        {{-- @foreach ($data as $d) --}}
        {{-- <tr>
            <td>{{ $data->user_id }}</td>
            <td>{{ $data->username }}</td>
            <td>{{ $data->nama }}</td>
            <td>{{ $data->level_id }}</td>
        </tr> --}}
        {{-- @endforeach --}}

    </table>
</body>
</html>

