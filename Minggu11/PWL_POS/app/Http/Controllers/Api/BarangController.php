<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarangModel;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    public function index()
    {
        $data = BarangModel::all();
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barang_kode' => 'required|string|max:10|unique:m_barang,barang_kode',
            'barang_nama' => 'required|string|max:100',
            'harga_beli' => 'required|integer',
            'harga_jual' => 'required|integer',
            'kategori_id' => 'required|exists:m_kategori,kategori_id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $barang = BarangModel::create([
            'barang_kode' => $request->barang_kode,
            'barang_nama' => $request->barang_nama,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'kategori_id' => $request->kategori_id,
            'image' => $request->image->hashname(),
        ]);

        //return response JSON user is created
        if ($barang) {
            return response()->json([
                'success' => true,
                'barang' => $barang,
            ], 201);
        }

        //return JSON process insert failed
        return response()->json([
            'success' => false,
        ], 409);
    }

    public function show(BarangModel $barang)
    {
        return BarangModel::find($barang);
    }

    public function update(Request $request, BarangModel $barang)
    {
        $barang->update($request->all());
        return BarangModel::find($barang);
    }

    public function destroy(BarangModel $barang)
    {
        $barang->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data terhapus',
        ]);
    }

    // JOBSHEET 10
    // public function index()
    // {
    //     return BarangModel::all();
    // }

    // public function store(Request $request)
    // {
    //     $barang = BarangModel::create($request->all());
    //     return response()->json($barang, 201);
    // }
}
