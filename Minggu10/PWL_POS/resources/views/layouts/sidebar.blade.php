@php
    // Jika variabel belum diset dari controller, isi default agar tidak error
    $activeMenu = $activeMenu ?? '';
@endphp

<div class="sidebar">
    <!-- Profile -->
    <li class="nav-item">
        <a href="{{ route('profile.index') }}" class="nav-link {{ ($activeMenu == 'profile') ? 'active' : '' }}">
            <!-- Jika foto ada, tampilkan foto profil, jika tidak tampilkan ikon default -->
            <img src="{{ Auth::user()->foto ? asset('uploads/foto_user/' . Auth::user()->foto) : asset('default-user.png') }}" 
                 class="img-circle elevation-2" alt="User Image" style="width: 30px; height: 30px;">
            <p>Profil Saya</p>
        </a>
    </li>

    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                {{-- Dashboard - Semua user bisa akses --}}
                <li class="nav-item">
                    <a href="{{ url('/') }}" class="nav-link {{ ($activeMenu == 'dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
    
                {{-- Hanya untuk ADM --}}
                @if(auth()->user()->level->level_kode == 'ADM')
                    <li class="nav-header">Data Pegawai</li>
                    <li class="nav-item">
                        <a href="{{ url('/level') }}" class="nav-link {{ ($activeMenu == 'level') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-layer-group"></i>
                            <p>Level User</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/user') }}" class="nav-link {{ ($activeMenu == 'user') ? 'active' : '' }}">
                            <i class="nav-icon far fa-user"></i>
                            <p>Data User</p>
                        </a>
                    </li>
                @endif
    
                {{-- Untuk ADM & MNG --}}
                @if(in_array(auth()->user()->level->level_kode, ['ADM', 'MNG']))
                    <li class="nav-header">Data Supplier</li>
                    <li class="nav-item">
                        <a href="{{ url('/supplier') }}" class="nav-link {{ ($activeMenu == 'supplier') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-truck"></i>
                            <p>Supplier</p>
                        </a>
                    </li>
                @endif
    
                {{-- Untuk Semua (ADM, MNG, STF, KSR) --}}
                @if(in_array(auth()->user()->level->level_kode, ['ADM', 'MNG', 'STF', 'KSR']))
                    <li class="nav-header">Data Barang</li>
                    @if(in_array(auth()->user()->level->level_kode, ['ADM', 'MNG']))
                        <li class="nav-item">
                            <a href="{{ url('/kategori') }}" class="nav-link {{ ($activeMenu == 'kategori') ? 'active' : '' }}">
                                <i class="nav-icon far fa-bookmark"></i>
                                <p>Kategori Barang</p>
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a href="{{ url('/barang') }}" class="nav-link {{ ($activeMenu == 'barang') ? 'active' : '' }}">
                            <i class="nav-icon far fa-list-alt"></i>
                            <p>Data Barang</p>
                        </a>
                    </li>
                    <li class="nav-header">Data Transaksi</li>
                    <li class="nav-item">
                        <a href="{{ url('/stok') }}" class="nav-link {{ ($activeMenu == 'stok') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-cubes"></i>
                            <p>Stok Barang</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/penjualan') }}" class="nav-link {{ ($activeMenu == 'penjualan') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-cash-register"></i>
                            <p>Transaksi Penjualan</p>
                        </a>
                    </li>
                @endif
            {{-- Button logout --}}
            <li class="mt-5">
                <a href="{{ url('/logout') }}" class="nav-link {{ ($activeMenu == 'logout') ? 'active' : '' }}">
                    <button type="submit" class="btn btn-danger">Logout</button>
                </a>
            </li>
        </ul>
    </nav>
</div
