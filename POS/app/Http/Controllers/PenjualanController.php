<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenjualanModel;
use App\Models\UserModel;

class PenjualanController extends Controller
{
    public function index()
    {
        $data = PenjualanModel::with('user')->get();
        return view('penjualan', ['data' => $data]);
    }

    public function tambah()
    {
        $user = UserModel::all();
        return view('penjualan_tambah', compact('user'));
    }

    public function tambah_simpan(Request $request)
    {
        PenjualanModel::create([
            'user_id' => $request->user_id,
            'penjualan_kode' => $request->penjualan_kode,
            'pembeli' => $request->pembeli,
            'penjualan_tanggal' => $request->penjualan_tanggal
        ]);

        return redirect('/penjualan');
    }

    public function ubah($id)
    {
        $penjualan = PenjualanModel::find($id);
        $user = UserModel::all();
        return view('penjualan_ubah', compact('penjualan', 'user'));
    }

    public function ubah_simpan($id, Request $request)
    {
        $penjualan = PenjualanModel::find($id);

        $penjualan->user_id = $request->user_id;
        $penjualan->penjualan_kode = $request->penjualan_kode;
        $penjualan->pembeli = $request->pembeli;
        $penjualan->penjualan_tanggal = $request->penjualan_tanggal;

        $penjualan->save();

        return redirect('/penjualan');
    }

    public function hapus($id)
    {
        $penjualan = PenjualanModel::find($id);
        $penjualan->delete();

        return redirect('/penjualan');
    }
}
