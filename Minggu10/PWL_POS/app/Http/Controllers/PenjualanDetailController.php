<?php

namespace App\Http\Controllers;

use App\Models\PenjualanDetailModel;
use App\Models\PenjualanModel;
use App\Models\BarangModel;
use Illuminate\Http\Request;

class PenjualanDetailController extends Controller
{
    public function index()
    {
        $data = PenjualanDetailModel::with(['penjualan', 'barang'])->get();
        return view('penjualan_detail', compact('data'));
    }

    public function tambah()
    {
        $penjualan = PenjualanModel::all();
        $barang = BarangModel::all();
        return view('penjualan_detail_tambah', compact('penjualan', 'barang'));
    }

    public function tambah_simpan(Request $request)
    {
        PenjualanDetailModel::create($request->all());
        return redirect('penjualan_detail');
    }

    public function ubah($id)
    {
        $data = PenjualanDetailModel::find($id);
        $penjualan = PenjualanModel::all();
        $barang = BarangModel::all();
        return view('penjualanDetail_ubah', compact('data', 'penjualan', 'barang'));
    }

    public function ubah_simpan(Request $request, $id)
    {
        $data = PenjualanDetailModel::find($id);
        $data->update($request->all());
        return redirect('penjualan_detail');
    }

    public function hapus($id)
    {
        PenjualanDetailModel::find($id)->delete();
        return redirect('penjualan_detail');
    }

    public function show($id)
    {
        $detail = PenjualanDetailModel::with(['barang', 'penjualan'])->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Penjualan',
            'list' => ['Home', 'Transaksi Penjualan', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail data Transaksi Penjualan'
        ];

        $activeMenu = 'penjualanDetail';

        return view('penjualanDetail.index', compact('breadcrumb', 'page', 'detail', 'activeMenu'));
    }
}
