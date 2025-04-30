@extends('layouts.template')

@section('content')

<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Halo 👋</h3> <br>
        <h3 class="card-title">Selamat datang di aplikasi manajemen penjualan!</h3>
    </div>
    <!-- Main content -->
<section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <!-- Kategori -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3>{{ $kategoriCount }}</h3>
              <p>Data Kategori</p>
            </div>
          </div>
        </div>
        <!-- ./col -->
  
        <!-- Barang -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3>{{ $barangCount }}</h3>
              <p>Data Barang</p>
            </div>
          </div>
        </div>
        <!-- ./col -->
  
        <!-- Supplier -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>{{ $supplierCount }}</h3>
              <p>Data Supplier</p>
            </div>
          </div>
        </div>
        <!-- ./col -->
  
        <!-- Stok -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>{{ $stokCount }}</h3>
              <p>Data Stok</p>
            </div>
          </div>
        </div>
        <!-- ./col -->
      </div>
    </div>
  </section>
  
    <div class="card-body">
        <p>Berikut adalah <strong>10 transaksi penjualan terbaru</strong>.</p>

        <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped table-hover table-sm text-center">
                <thead class="bg-light">
                    <tr>
                        <th>ID</th>
                        <th>Kode</th>
                        <th>Pegawai</th>
                        <th>Pembeli</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($latestPenjualan as $item)
                    <tr>
                        <td>{{ $item->penjualan_id }}</td>
                        <td>{{ $item->penjualan_kode }}</td>
                        <td>{{ $item->user->nama ?? '-' }}</td>
                        <td>{{ $item->pembeli }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->penjualan_tanggal)->format('d-m-Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">Belum ada transaksi penjualan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
