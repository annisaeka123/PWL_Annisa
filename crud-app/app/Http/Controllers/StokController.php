<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use Illuminate\Http\Request;

class StokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stoks = Stok::all();
        return view('stoks.index', compact('stoks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('stoks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'jumlah_barang' => 'required|integer',
        ]);

        //Hanya masukkan atribut yang diizinkan
        Stok::create($request->only(['nama_barang', 'jumlah_barang']));
        return redirect()->route('stoks.index')->with('berhasil', 'Stok berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Stok $stok)
    {
        return view('stoks.show', compact('stok'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stok $stok)
    {
        return view('stoks.edit', compact('stok'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stok $stok)
    {
        $request->validate([
            'nama_barang' => 'required',
            'jumlah_barang' => 'required',
        ]);

        //Hanya masukkan atribut yang diizinkan
        $stok->update($request->only(['nama_barang', 'jumlah_barang']));
        return redirect()->route('stoks.index')->with('berhasil', 'Stok berhasil ditambahkan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stok $stok)
    {
        $stok->delete();
        return redirect()->route('stoks.index')->with('berhasil', 'Stok berhasil dihapus.');
    }
}
