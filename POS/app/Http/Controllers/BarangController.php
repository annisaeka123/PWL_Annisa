<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangModel;
use App\Models\KategoriModel;

class BarangController extends Controller
{
    public function index()
    {
        $data = BarangModel::with('kategori')->get();
        return view('barang', ['data' => $data]);
    }

    public function tambah()
    {
        $kategori = KategoriModel::all();
        return view('barang_tambah', ['kategori' => $kategori]);
    }

    public function tambah_simpan(Request $request)
    {
        BarangModel::create([
            'kategori_id' => $request->kategori_id,
            'barang_kode' => $request->barang_kode,
            'barang_nama' => $request->barang_nama,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
        ]);

        return redirect('/barang');
    }

    public function ubah($id)
    {
        $barang = BarangModel::find($id);
        $kategori = KategoriModel::all();
        return view('barang_ubah', ['data' => $barang, 'kategori' => $kategori]);
    }

    public function ubah_simpan($id, Request $request)
    {
        $barang = BarangModel::find($id);
        $barang->update([
            'kategori_id' => $request->kategori_id,
            'barang_kode' => $request->barang_kode,
            'barang_nama' => $request->barang_nama,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
        ]);

        return redirect('/barang');
    }

    public function hapus($id)
    {
        $barang = BarangModel::find($id);
        $barang->delete();
        return redirect('/barang');
    }
}
