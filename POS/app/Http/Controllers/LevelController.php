<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LevelModel;

class LevelController extends Controller
{
    public function index()
    {
        $levels = LevelModel::all();
        return view('level', ['levels' => $levels]);
    }

    public function tambah()
    {
        return view('level_tambah');
    }

    public function tambah_simpan(Request $request)
    {
        $request->validate([
            'level_kode' => 'required|unique:m_level,level_kode',
            'level_nama' => 'required',
        ]);

        LevelModel::create([
            'level_kode' => $request->level_kode,
            'level_nama' => $request->level_nama,
        ]);

        return redirect('/level');
    }

    public function ubah($id)
    {
        $level = LevelModel::find($id);
        return view('level_ubah', ['level' => $level]);
    }

    public function ubah_simpan($id, Request $request)
    {
        $request->validate([
            'level_kode' => 'required|unique:m_level,level_kode,' . $id,
            'level_nama' => 'required',
        ]);

        $level = LevelModel::find($id);
        $level->level_kode = $request->level_kode;
        $level->level_nama = $request->level_nama;
        $level->save();

        return redirect('/level');
    }

    public function hapus($id)
    {
        $level = LevelModel::find($id);
        $level->delete();

        return redirect('/level');
    }
}
