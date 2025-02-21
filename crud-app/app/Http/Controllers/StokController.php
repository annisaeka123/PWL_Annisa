<?php

//Menentukan lokasi controller dalam struktur proyek Laravel
namespace App\Http\Controllers;

//Menggunakan model Stok untuk berinteraksi dengan database
use App\Models\Stok;
//Memungkinkan pengambilan data dari request yang dikirimkan oleh user
use Illuminate\Http\Request;

//Mendefinisikan kelas StokController yang merupakan turunan dari Controller.
//Digunakan untuk mengatur CRUD data stok.
class StokController extends Controller
{
    /**
     * Menampilkan daftar stok
     */
    public function index()
    {
        $stoks = Stok::all(); // Mengambil semua data dari tabel stoks
        return view('stoks.index', compact('stoks')); //Mengirimkan data $stoks ke view stoks.index untuk ditampilkan
    }

    /**
     * Menampilkan form tambah stok
     */
    public function create()
    {
        return view('stoks.create');//Mengembalikan tampilan stoks.create yang berisi formulir tambah stok
    }

    /**
     * Menyimpan data stok baru
     */
    public function store(Request $request)
    {
        $request->validate([ //validate() → Memastikan input nama_barang wajib diisi dan jumlah_barang harus berupa angka.
            'nama_barang' => 'required',
            'jumlah_barang' => 'required|integer',
        ]);

        //Hanya masukkan atribut yang diizinkan
        Stok::create($request->only(['nama_barang', 'jumlah_barang']));//Menyimpan data ke database dengan hanya mengambil input yang diizinkan.
        return redirect()->route('stoks.index')->with('berhasil', 'Stok berhasil ditambahkan.');//Mengarahkan pengguna kembali ke halaman daftar stok dengan pesan sukses.
    }

    /**
     * Menampilkan detail stok
     */
    public function show(Stok $stok)
    {
        return view('stoks.show', compact('stok'));//Mengirimkan data stok tertentu ($stok) ke tampilan stoks.show untuk ditampilkan.
    }

    /**
     * Menampilkan form edit stok
     */
    public function edit(Stok $stok)
    {
        return view('stoks.edit', compact('stok'));//Mengirimkan data stok ke tampilan stoks.edit agar bisa diedit.
    }

    /**
     * Memperbarui data stok
     */
    public function update(Request $request, Stok $stok)
    {
        $request->validate([ //Validasi → Pastikan nama_barang dan jumlah_barang diisi sebelum update.
            'nama_barang' => 'required',
            'jumlah_barang' => 'required',
        ]);

        //Hanya masukkan atribut yang diizinkan
        $stok->update($request->only(['nama_barang', 'jumlah_barang']));//Update data → $stok->update() akan memperbarui data sesuai input pengguna
        return redirect()->route('stoks.index')->with('berhasil', 'Stok berhasil ditambahkan.');//Redirect → Mengembalikan ke halaman daftar stok dengan pesan sukses.

    }

    /**
     * Menghapus data stok
     */
    public function destroy(Stok $stok)
    {
        $stok->delete(); //Menghapus data stok dari database.
        return redirect()->route('stoks.index')->with('berhasil', 'Stok berhasil dihapus.');//Mengembalikan pengguna ke daftar stok dengan pesan sukses.
    }
}
