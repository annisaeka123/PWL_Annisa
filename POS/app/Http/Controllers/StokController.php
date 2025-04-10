<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StokModel;
use App\Models\BarangModel;
use App\Models\UserModel;
use App\Models\SupplierModel;

class StokController extends Controller
{
    public function index()
    {
        $data = StokModel::with(['barang', 'user', 'supplier'])->get();
        return view('stok', ['data' => $data]);
    }

    public function tambah()
    {
        $barang = BarangModel::all();
        $user = UserModel::all();
        $supplier = SupplierModel::all();

        return view('stok_tambah', compact('barang', 'user', 'supplier'));
    }

    public function tambah_simpan(Request $request)
    {
        StokModel::create([
            'barang_id' => $request->barang_id,
            'user_id' => $request->user_id,
            'supplier_id' => $request->supplier_id,
            'stok_tanggal' => $request->stok_tanggal,
            'stok_jumlah' => $request->stok_jumlah
        ]);

        return redirect('/stok');
    }

    public function ubah($id)
    {
        $stok = StokModel::find($id);
        $barang = BarangModel::all();
        $user = UserModel::all();
        $supplier = SupplierModel::all();

        return view('stok_ubah', compact('stok', 'barang', 'user', 'supplier'));
    }

    public function ubah_simpan($id, Request $request)
    {
        $stok = StokModel::find($id);

        $stok->barang_id = $request->barang_id;
        $stok->user_id = $request->user_id;
        $stok->supplier_id = $request->supplier_id;
        $stok->stok_tanggal = $request->stok_tanggal;
        $stok->stok_jumlah = $request->stok_jumlah;

        $stok->save();

        return redirect('/stok');
    }

    public function hapus($id)
    {
        $stok = StokModel::find($id);
        $stok->delete();

        return redirect('/stok');
    }
}
