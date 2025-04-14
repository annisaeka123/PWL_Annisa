<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LevelModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;

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

    public function create_ajax()
    {
        return view('level.create_ajax');
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

    // Menampilkan halaman form edit level ajax
    public function edit_ajax(string $id)
    {
        $level = LevelModel::find($id);
 
        return view('level.edit_ajax', ['level' => $level]);
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

    public function import()
    {
        return view('level.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_level' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_level');

            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);

            $spreadsheet = $reader->load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(null, false, true, true);

            $insert = [];

            if (count($data) > 1) {
                foreach ($data as $baris => $value) {
                    if ($baris > 1) {
                        $insert[] = [
                            'level_kode' => $value['A'],
                            'level_nama' => $value['B'],
                        ];
                    }
                }

                if (count($insert) > 0) {
                    LevelModel::insertOrIgnore($insert);
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diimport'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data yang diimport'
                ]);
            }
        }

        return redirect('/');
    }

    public function export_excel()
    {
        // Ambil semua data level
        $levels = LevelModel::select('level_id', 'level_kode', 'level_nama')->orderBy('level_nama')->get();
    
        // Buat spreadsheet baru
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
    
        // Header kolom
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Level');
        $sheet->setCellValue('C1', 'Nama Level');
    
        $sheet->getStyle('A1:C1')->getFont()->setBold(true);
    
        // Isi data
        $baris = 2;
        $no = 1;
        foreach ($levels as $level) {
            $sheet->setCellValue('A' . $baris, $no++);
            $sheet->setCellValue('B' . $baris, $level->level_kode);
            $sheet->setCellValue('C' . $baris, $level->level_nama);
            $baris++;
        }
    
        // Set kolom auto width
        foreach (range('A', 'C') as $kolom) {
            $sheet->getColumnDimension($kolom)->setAutoSize(true);
        }
    
        // Nama file
        $filename = 'Data_Level_' . date('Y-m-d_H-i-s') . '.xlsx';
    
        // Header untuk download file
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$filename\"");
        header('Cache-Control: max-age=0');
    
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

}



// class LevelControllerr extends Controller
// {
    /**
     * Jobsheet 5
     */
    // public function index()
    // {
    //     $breadcrumb = (object) [
    //         'title' => 'Daftar Level',
    //         'list' => ['Home', 'Level']
    //     ];

    //     $page = (object) [
    //         'title' => 'Daftar Level untuk Pengguna'
    //     ];

    //     $activeMenu = 'level'; // set menu yang sedang aktif

    //     $level = LevelModel::all(); // ambil data level untuk filter level
    
    //     return view('level.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    // }

    // // public function list(Request $request)
    // // {
    // //     $levels = LevelModel::select('level_id', 'level_kode', 'level_nama');

    // //     //Filter data level berdasarkan level_id
    // //     if ($request->level_id) {
    // //         $levels->where('level_id', $request->level_id);
    // //     }

    // //     return DataTables::of($levels)
    // //         // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
    // //         ->addIndexColumn()
    // //         ->addColumn('aksi', function ($level) { // menambahkan kolom aksi
    // //             $btn = '<a href="' . url('/level/' . $level->level_id) . '" class="btn btn-info btn-sm">Detail</a> ';
    // //             $btn .= '<a href="' . url('/level/' . $level->level_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
    // //             $btn .= '<form class="d-inline-block" method="POST" action="' . url('/level/' . $level->level_id) . '">'
    // //                 . csrf_field() . method_field('DELETE') .
    // //                 '<button type="submit" class="btn btn-danger btn-sm" 
    // //                 onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\')">Hapus</button></form>';
    // //             return $btn;
    // //         })
    // //         ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
    // //         ->make(true);
    // // }

    // public function create()
    // {
    //     $breadcrumb = (object) [
    //         'title' => 'Tambah Level',
    //         'list' => ['Home', 'Level', 'Tambah']
    //     ];

    //     $page = (object) [
    //         'title' => 'Tambah level baru'
    //     ];

    //     $level = LevelModel::all(); // ambil data level untuk ditampilkan di form
    //     $activeMenu = 'level'; // set menu yang sedang aktif

    //     return view('level.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    // }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'level_kode' => 'required|string|max:10|unique:m_level,level_kode',
    //         'level_nama' => 'required|string|max:100'   // nama harus diisi, berupa string, dan maksimal 100 karakter
            
    //     ]);

    //     LevelModel::create([
    //         'level_kode' => $request->level_kode,
    //         'level_nama' => $request->level_nama,
    //     ]);

    //     return redirect('/level')->with('success', 'Level baru berhasil disimpan');
    // }

    // public function show($id)
    // {
    //     $level = LevelModel::find($id);

    //     $breadcrumb = (object) [
    //         'title' => 'Detail Level',
    //         'list' => ['Home', 'Level', 'Detail']
    //     ];

    //     $page = (object) [
    //         'title' => 'Detail level'
    //     ];

    //     $activeMenu = 'level'; // set menu yang sedang aktif

    //     return view('level.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    // }

    // public function edit($id)
    // {
    //     $level = LevelModel::find($id);

    //     $breadcrumb = (object) [
    //         'title' => 'Edit Level',
    //         'list' => ['Home', 'Level', 'Edit']
    //     ];

    //     $page = (object) [
    //         'title' => 'Edit Level'
    //     ];

    //     $activeMenu = 'level'; // set menu yang sedang aktif

    //     return view('level.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    // }

    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'level_kode' => 'required|string|max:10',
    //         'level_nama' => 'required|string|max:100'   // nama harus diisi, berupa string, dan maksimal 100 karakter
    //     ]);

    //     LevelModel::find($id)->update([
    //         'level_kode' => $request->level_kode,
    //         'level_nama' => $request->level_nama
    //     ]);

    //     return redirect('/level')->with('success', 'Level berhasil diubah');
    // }

    // public function destroy($id)
    // {
    //     $check = LevelModel::find($id);
    
    //     if (!$check) { // untuk mengecek apakah data level dengan id yang dimaksud ada atau tidak
    //         return redirect('/level')->with('error', 'Level tidak ditemukan');
    //     }
    
    //     try {
    //         LevelModel::destroy($id); // Hapus data level
    
    //         return redirect('/level')->with('success', 'Data level berhasil dihapus');
    //     } catch (\Illuminate\Database\QueryException $e) {
    //         // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
    //         return redirect('/level')->with('error', 'Data level gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
    //     }
    // }


    /**
     * Jobsheet 6
     */
//     public function create_ajax()
//      {
//          return view('level.create_ajax');
//      }

//      public function store_ajax(Request $request)
//      {
//          // cek apakah request berupa ajax
//          if ($request->ajax() || $request->wantsJson()) {
//              $rules = [
//                  'level_kode' => 'required|string|min:3|unique:m_level,level_kode',
//                  'level_nama' => 'required|string|max:100'
//              ];
 
 
//              $validator = Validator::make($request->all(), $rules);
 
//              if ($validator->fails()) {
//                  return response()->json([
//                      'status' => false, // response status, false: error/gagal, true: berhasil
//                      'message' => 'Validasi Gagal',
//                      'msgField' => $validator->errors() // pesan error validasi
//                  ]);
//              }
 
//              LevelModel::create($request->all());
 
//              return response()->json([
//                  'status' => true,
//                  'message' => 'Data Level berhasil disimpan'
//              ]);
//          }
 
//          redirect('/');
//      }
 
//      // Ambil data level dalam bentuk json untuk datatables
//      public function list(Request $request)
//      {
//          $levels = LevelModel::select('level_id', 'level_kode', 'level_nama');
 
//          return DataTables::of($levels)
//              ->addIndexColumn()  // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
//              ->addColumn('aksi', function ($level) {  // menambahkan kolom aksi
     
//                  /* $btn = '<a href="'.url('/level/' . $level->level_id).'" class="btn btn-info btn-sm">Detail</a> ';
//              $btn .= '<a href="'.url('/level/' . $level->level_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
//              $btn .= '<form class="d-inline-block" method="POST" action="'. url('/level/'.$level->level_id).'">'
//              . csrf_field() . method_field('DELETE') .
//              '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';*/
//                  $btn = '<button onclick="modalAction(\'' . url('/level/' . $level->level_id) . '\')" class="btn btn-info btn-sm">Detail</button> ';
//                  $btn .= '<button onclick="modalAction(\'' . url('/level/' . $level->level_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
//                  $btn .= '<button onclick="modalAction(\'' . url('/level/' . $level->level_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
 
//                  return $btn;
//              })
//              ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
//              ->make(true);
//      }
 
//      // Menampilkan halaman form edit level ajax
//      public function edit_ajax(string $id)
//      {
//          $level = LevelModel::find($id);
 
//          return view('level.edit_ajax', ['level' => $level]);
//      }

//      public function update_ajax(Request $request, $id)
//      {
//          // cek apakah request dari ajax
//          if ($request->ajax() || $request->wantsJson()) {
//              $rules = [
//                  'level_kode' => 'required|max:20|unique:m_level,level_kode,' . $id . ',level_id',
//                  'level_nama' => 'required|max:100'
//              ];
 
//              // use Illuminate\Support\Facades\Validator;
//              $validator = Validator::make($request->all(), $rules);
 
//              if ($validator->fails()) {
//                  return response()->json([
//                      'status' => false, // respon json, true: berhasil, false: gagal
//                      'message' => 'Validasi gagal.',
//                      'msgfield' => $validator->errors() // menunjukkan field mana yang error
//                  ]);
//              }
 
//              $check = LevelModel::find($id);
//              if ($check) {
//                  $check->update($request->all());
//                  return response()->json([
//                      'status' => true,
//                      'message' => 'Data berhasil diupdate'
//                  ]);
//              } else {
//                  return response()->json([
//                      'status' => false,
//                      'message' => 'Data tidak ditemukan'
//                  ]);
//              }
//          }
//          return redirect('/');
//      }

//      public function confirm_ajax(string $id)
//      {
//          $level = LevelModel::find($id);
 
//          return view('level.confirm_ajax', ['level' => $level]);
//      }
 
//      public function delete_ajax(Request $request, $id)
//      {
//          // cek apakah request dari ajax
//          if ($request->ajax() || $request->wantsJson()) {
//              $level = LevelModel::find($id);
//              if ($level) {
//                  $level->delete();
//                  return response()->json([
//                      'status' => true,
//                      'message' => 'Data berhasil dihapus'
//                  ]);
//              } else {
//                  return response()->json([
//                      'status' => false,
//                      'message' => 'Data tidak ditemukan'
//                  ]);
//              }
//          }
//          return redirect('/');
//      }
// }
