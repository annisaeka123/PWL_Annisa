<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LevelModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class LevelController extends Controller
{

    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Level',
            'list' => ['Home', 'Level']
        ];

        $page = (object) [
            'title' => 'Daftar Level untuk Pengguna'
        ];

        $activeMenu = 'level'; // set menu yang sedang aktif

        $level = LevelModel::all(); // ambil data level untuk filter level
    
        return view('level.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Level',
            'list' => ['Home', 'Level', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah level baru'
        ];

        $level = LevelModel::all(); // ambil data level untuk ditampilkan di form
        $activeMenu = 'level'; // set menu yang sedang aktif

        return view('level.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'level_kode' => 'required|string|max:10|unique:m_level,level_kode',
            'level_nama' => 'required|string|max:100'   // nama harus diisi, berupa string, dan maksimal 100 karakter
            
        ]);

        LevelModel::create([
            'level_kode' => $request->level_kode,
            'level_nama' => $request->level_nama,
        ]);

        return redirect('/level')->with('success', 'Level baru berhasil disimpan');
    }

    public function show($id)
    {
        $level = LevelModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Level',
            'list' => ['Home', 'Level', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail level'
        ];

        $activeMenu = 'level'; // set menu yang sedang aktif

        return view('level.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    public function edit($id)
    {
        $level = LevelModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Level',
            'list' => ['Home', 'Level', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Level'
        ];

        $activeMenu = 'level'; // set menu yang sedang aktif

        return view('level.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'level_kode' => 'required|string|max:10',
            'level_nama' => 'required|string|max:100'   // nama harus diisi, berupa string, dan maksimal 100 karakter
        ]);

        LevelModel::find($id)->update([
            'level_kode' => $request->level_kode,
            'level_nama' => $request->level_nama
        ]);

        return redirect('/level')->with('success', 'Level berhasil diubah');
    }

    public function destroy($id)
    {
        $check = LevelModel::find($id);
    
        if (!$check) { // untuk mengecek apakah data level dengan id yang dimaksud ada atau tidak
            return redirect('/level')->with('error', 'Level tidak ditemukan');
        }
    
        try {
            LevelModel::destroy($id); // Hapus data level
    
            return redirect('/level')->with('success', 'Data level berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/level')->with('error', 'Data level gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function create_ajax()
     {
         return view('level.create_ajax');
     }

     public function store_ajax(Request $request)
     {
         // cek apakah request berupa ajax
         if ($request->ajax() || $request->wantsJson()) {
             $rules = [
                 'level_kode' => 'required|string|min:3|unique:m_level,level_kode',
                 'level_nama' => 'required|string|max:100'
             ];
 
 
             $validator = Validator::make($request->all(), $rules);
 
             if ($validator->fails()) {
                 return response()->json([
                     'status' => false, // response status, false: error/gagal, true: berhasil
                     'message' => 'Validasi Gagal',
                     'msgField' => $validator->errors() // pesan error validasi
                 ]);
             }
 
             LevelModel::create($request->all());
 
             return response()->json([
                 'status' => true,
                 'message' => 'Data Level berhasil disimpan'
             ]);
         }
 
         redirect('/');
     }
 
     // Ambil data level dalam bentuk json untuk datatables
     public function list(Request $request)
     {
         $levels = LevelModel::select('level_id', 'level_kode', 'level_nama');
 
         return DataTables::of($levels)
             ->addIndexColumn()  // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
             ->addColumn('aksi', function ($level) {  // menambahkan kolom aksi
                 $btn = '<button onclick="modalAction(\'' . url('/level/' . $level->level_id) . '\')" class="btn btn-info btn-sm">Detail</button> ';
                 $btn .= '<button onclick="modalAction(\'' . url('/level/' . $level->level_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                 $btn .= '<button onclick="modalAction(\'' . url('/level/' . $level->level_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
 
                 return $btn;
             })
             ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
             ->make(true);
     }
 
     // Menampilkan halaman form edit level ajax
     public function edit_ajax(string $id)
     {
         $level = LevelModel::find($id);
 
         return view('level.edit_ajax', ['level' => $level]);
     }

     public function update_ajax(Request $request, $id)
     {
         // cek apakah request dari ajax
         if ($request->ajax() || $request->wantsJson()) {
             $rules = [
                 'level_kode' => 'required|max:20|unique:m_level,level_kode,' . $id . ',level_id',
                 'level_nama' => 'required|max:100'
             ];
 
             // use Illuminate\Support\Facades\Validator;
             $validator = Validator::make($request->all(), $rules);
 
             if ($validator->fails()) {
                 return response()->json([
                     'status' => false, // respon json, true: berhasil, false: gagal
                     'message' => 'Validasi gagal.',
                     'msgfield' => $validator->errors() // menunjukkan field mana yang error
                 ]);
             }
 
             $check = LevelModel::find($id);
             if ($check) {
                 $check->update($request->all());
                 return response()->json([
                     'status' => true,
                     'message' => 'Data berhasil diupdate'
                 ]);
             } else {
                 return response()->json([
                     'status' => false,
                     'message' => 'Data tidak ditemukan'
                 ]);
             }
         }
         return redirect('/');
     }

     public function confirm_ajax(string $id)
     {
         $level = LevelModel::find($id);
 
         return view('level.confirm_ajax', ['level' => $level]);
     }
 
     public function delete_ajax(Request $request, $id)
     {
         // cek apakah request dari ajax
         if ($request->ajax() || $request->wantsJson()) {
             $level = LevelModel::find($id);
             if ($level) {
                 $level->delete();
                 return response()->json([
                     'status' => true,
                     'message' => 'Data berhasil dihapus'
                 ]);
             } else {
                 return response()->json([
                     'status' => false,
                     'message' => 'Data tidak ditemukan'
                 ]);
             }
         }
         return redirect('/');
     }

}
