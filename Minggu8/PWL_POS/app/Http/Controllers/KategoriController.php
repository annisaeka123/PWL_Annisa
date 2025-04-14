<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\KategoriModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;

class KategoriController extends Controller
{

    /**
     * Jobsheet 8
     */

    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Kategori',
            'list' => ['Home', 'Kategori']
        ];

        $page = (object) [
            'title' => 'Daftar Kategori untuk Barang'
        ];

        $activeMenu = 'kategori'; // set menu yang sedang aktif

        $kategori = KategoriModel::all(); // ambil data kategori untuk filter kategori
    
        return view('kategori.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    // Ambil data kategori dalam bentuk json untuk datatables
    public function list()
    {
        $kategoris = KategoriModel::select('kategori_id', 'kategori_kode', 'kategori_nama');

        return DataTables::of($kategoris)
            ->addIndexColumn()  // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($kategori) {  // menambahkan kolom aksi
                $btn = '<button onclick="modalAction(\'' . url('/kategori/' . $kategori->kategori_id) . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/kategori/' . $kategori->kategori_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/kategori/' . $kategori->kategori_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';

                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    } 

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Kategori',
            'list' => ['Home', 'Kategori', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah kategori baru'
        ];

        $kategori = KategoriModel::all(); // ambil data kategori untuk ditampilkan di form
        $activeMenu = 'kategori'; // set menu yang sedang aktif

        return view('kategori.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    public function create_ajax()
    {
        return view('kategori.create_ajax');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_kode' => 'required|string|max:10|unique:m_kategori,kategori_kode',
            'kategori_nama' => 'required|string|max:100' 
        ]);

        KategoriModel::create([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama
        ]);

        return redirect('/kategori')->with('success', 'Kategori baru berhasil disimpan');
    }

    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_kode' => 'required|string|min:3|unique:m_kategori,kategori_kode',
                'kategori_nama' => 'required|string|max:100'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // response status, false: error/gagal, true: berhasil
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors() // pesan error validasi
                ]);
            }

            KategoriModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data kategori berhasil disimpan'
            ]);
        }

        redirect('/');
    }

    public function edit($id)
    {
        $kategori = KategoriModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Kategori',
            'list' => ['Home', 'Kategori', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Kategori'
        ];

        $activeMenu = 'kategori'; // set menu yang sedang aktif

        return view('kategori.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    // Menampilkan halaman form edit kategori ajax
    public function edit_ajax(string $id)
    {
        $kategori = KategoriModel::find($id);

        return view('kategori.edit_ajax', ['kategori' => $kategori]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_kode' => 'required|string|max:10',
            'kategori_nama' => 'required|string|max:100'  
        ]);

        KategoriModel::find($id)->update([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama
        ]);

        return redirect('/kategori')->with('success', 'Kategori berhasil diubah');
    }

    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_kode' => 'required|max:20|unique:m_kategori,kategori_kode,' . $id . ',kategori_id',
                'kategori_nama' => 'required|max:100'
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

            $check = KategoriModel::find($id);
            if ($check) {
                if (!$request->filled('password')) { // jika password tidak diisi, maka hapus dari request
                    $request->request->remove('password');
                }

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
        $kategori = KategoriModel::find($id);

        return view('kategori.confirm_ajax', ['kategori' => $kategori]);
    }

    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $kategori = KategoriModel::find($id);
            if ($kategori) {
                $kategori->delete();
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
        return view('kategori.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_kategori' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_kategori');

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
                            'kategori_kode' => $value['A'],
                            'kategori_nama' => $value['B'],
                            'created_at'    => now(),
                        ];
                    }
                }

                if (count($insert) > 0) {
                    KategoriModel::insertOrIgnore($insert);
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
        // ambil data kategori yang akan di-export
        $kategori = KategoriModel::select('kategori_kode', 'kategori_nama')
                        ->orderBy('kategori_kode')
                        ->get();
    
        // load library excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
    
        // buat header kolom
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Kategori');
        $sheet->setCellValue('C1', 'Nama Kategori');
    
        $sheet->getStyle('A1:C1')->getFont()->setBold(true); // bold header
    
        $no = 1; // nomor data dimulai dari 1
        $baris = 2; // baris data dimulai dari baris ke 2
    
        foreach ($kategori as $value) {
            $sheet->setCellValue('A'.$baris, $no);
            $sheet->setCellValue('B'.$baris, $value->kategori_kode);
            $sheet->setCellValue('C'.$baris, $value->kategori_nama);
            $baris++;
            $no++;
        }
    
        // auto size kolom
        foreach(range('A', 'C') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
    
        $sheet->setTitle('Data Kategori'); // set judul sheet
    
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Kategori '.date('Y-m-d H:i:s').'.xlsx';
    
        // atur header untuk download file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: '. gmdate('D, d M Y H:i:s').' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');
    
        $writer->save('php://output');
        exit;
    }
    

}


// class KategoriController extends Controller
// {
    /**
     * Jobsheet 5
     */

    // public function index()
    // {
    //     $breadcrumb = (object) [
    //         'title' => 'Daftar Kategori',
    //         'list' => ['Home', 'Kategori']
    //     ];

    //     $page = (object) [
    //         'title' => 'Daftar Kategori untuk Barang'
    //     ];

    //     $activeMenu = 'kategori'; // set menu yang sedang aktif

    //     $kategori = KategoriModel::all(); // ambil data kategori untuk filter kategori
    
    //     return view('kategori.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    // }

    // public function list(Request $request)
    // {
    //     $kategoris = KategoriModel::select('kategori_id', 'kategori_kode', 'kategori_nama');

    //     //Filter data kategori berdasarkan kategori_id
    //     if ($request->kategori_id) {
    //         $kategoris->where('kategori_id', $request->kategori_id);
    //     }

    //     return DataTables::of($kategoris)
    //         // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
    //         ->addIndexColumn()
    //         ->addColumn('aksi', function ($kategori) { // menambahkan kolom aksi
    //             $btn = '<a href="' . url('/kategori/' . $kategori->kategori_id) . '" class="btn btn-info btn-sm">Detail</a> ';
    //             $btn .= '<a href="' . url('/kategori/' . $kategori->kategori_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
    //             $btn .= '<form class="d-inline-block" method="POST" action="' . url('/kategori/' . $kategori->kategori_id) . '">'
    //                 . csrf_field() . method_field('DELETE') .
    //                 '<button type="submit" class="btn btn-danger btn-sm" 
    //                 onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\')">Hapus</button></form>';
    //             return $btn;
    //         })
    //         ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
    //         ->make(true);
    // }

    // public function create()
    // {
    //     $breadcrumb = (object) [
    //         'title' => 'Tambah Kategori',
    //         'list' => ['Home', 'Kategori', 'Tambah']
    //     ];

    //     $page = (object) [
    //         'title' => 'Tambah kategori baru'
    //     ];

    //     $kategori = KategoriModel::all(); // ambil data kategori untuk ditampilkan di form
    //     $activeMenu = 'kategori'; // set menu yang sedang aktif

    //     return view('kategori.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    // }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'kategori_kode' => 'required|string|max:10|unique:m_kategori,kategori_kode',
    //         'kategori_nama' => 'required|string|max:100' 
    //     ]);

    //     KategoriModel::create([
    //         'kategori_kode' => $request->kategori_kode,
    //         'kategori_nama' => $request->kategori_nama
    //     ]);

    //     return redirect('/kategori')->with('success', 'Kategori baru berhasil disimpan');
    // }

    // public function show($id)
    // {
    //     $kategori = KategoriModel::find($id);

    //     $breadcrumb = (object) [
    //         'title' => 'Detail Kategori',
    //         'list' => ['Home', 'Kategori', 'Detail']
    //     ];

    //     $page = (object) [
    //         'title' => 'Detail kategori'
    //     ];

    //     $activeMenu = 'kategori'; // set menu yang sedang aktif

    //     return view('kategori.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    // }

    // public function edit($id)
    // {
    //     $kategori = KategoriModel::find($id);

    //     $breadcrumb = (object) [
    //         'title' => 'Edit Kategori',
    //         'list' => ['Home', 'Kategori', 'Edit']
    //     ];

    //     $page = (object) [
    //         'title' => 'Edit Kategori'
    //     ];

    //     $activeMenu = 'kategori'; // set menu yang sedang aktif

    //     return view('kategori.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    // }

    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'kategori_kode' => 'required|string|max:10',
    //         'kategori_nama' => 'required|string|max:100'  
    //     ]);

    //     KategoriModel::find($id)->update([
    //         'kategori_kode' => $request->kategori_kode,
    //         'kategori_nama' => $request->kategori_nama
    //     ]);

    //     return redirect('/kategori')->with('success', 'Kategori berhasil diubah');
    // }

    // public function destroy($id)
    // {
    //     $check = KategoriModel::find($id);
    
    //     if (!$check) { // untuk mengecek apakah data kategori dengan id yang dimaksud ada atau tidak
    //         return redirect('/kategori')->with('error', 'Kategori tidak ditemukan');
    //     }
    
    //     try {
    //         KategoriModel::destroy($id); // Hapus data kategori
    
    //         return redirect('/kategori')->with('success', 'Data kategori berhasil dihapus');
    //     } catch (\Illuminate\Database\QueryException $e) {
    //         // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
    //         return redirect('/kategori')->with('error', 'Data gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
    //     }
    // }


    /**
     * Jobsheet 6
     */
//     public function create_ajax()
//     {
//         return view('kategori.create_ajax');
//     }

//     public function store_ajax(Request $request)
//     {
//         // cek apakah request berupa ajax
//         if ($request->ajax() || $request->wantsJson()) {
//             $rules = [
//                 'kategori_kode' => 'required|string|min:3|unique:m_kategori,kategori_kode',
//                 'kategori_nama' => 'required|string|max:100'
//             ];


//             $validator = Validator::make($request->all(), $rules);

//             if ($validator->fails()) {
//                 return response()->json([
//                     'status' => false, // response status, false: error/gagal, true: berhasil
//                     'message' => 'Validasi Gagal',
//                     'msgField' => $validator->errors() // pesan error validasi
//                 ]);
//             }

//             KategoriModel::create($request->all());

//             return response()->json([
//                 'status' => true,
//                 'message' => 'Data kategori berhasil disimpan'
//             ]);
//         }

//         redirect('/');
//     }

//     // Ambil data kategori dalam bentuk json untuk datatables
//     public function list(Request $request)
//     {
//         $kategoris = KategoriModel::select('kategori_id', 'kategori_kode', 'kategori_nama');

//         return DataTables::of($kategoris)
//             ->addIndexColumn()  // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
//             ->addColumn('aksi', function ($kategori) {  // menambahkan kolom aksi
    
//                 /* $btn = '<a href="'.url('/kategori/' . $kategori->kategori_id).'" class="btn btn-info btn-sm">Detail</a> ';
//             $btn .= '<a href="'.url('/kategori/' . $kategori->kategori_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
//             $btn .= '<form class="d-inline-block" method="POST" action="'. url('/kategori/'.$kategori->kategori_id).'">'
//             . csrf_field() . method_field('DELETE') .
//             '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';*/
//                 $btn = '<button onclick="modalAction(\'' . url('/kategori/' . $kategori->kategori_id) . '\')" class="btn btn-info btn-sm">Detail</button> ';
//                 $btn .= '<button onclick="modalAction(\'' . url('/kategori/' . $kategori->kategori_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
//                 $btn .= '<button onclick="modalAction(\'' . url('/kategori/' . $kategori->kategori_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';

//                 return $btn;
//             })
//             ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
//             ->make(true);
//     }

//     // Menampilkan halaman form edit kategori ajax
//     public function edit_ajax(string $id)
//     {
//         $kategori = KategoriModel::find($id);

//         return view('kategori.edit_ajax', ['kategori' => $kategori]);
//     }

//     public function update_ajax(Request $request, $id)
//     {
//         // cek apakah request dari ajax
//         if ($request->ajax() || $request->wantsJson()) {
//             $rules = [
//                 'kategori_kode' => 'required|max:20|unique:m_kategori,kategori_kode,' . $id . ',kategori_id',
//                 'kategori_nama' => 'required|max:100'
//             ];

//             // use Illuminate\Support\Facades\Validator;
//             $validator = Validator::make($request->all(), $rules);

//             if ($validator->fails()) {
//                 return response()->json([
//                     'status' => false, // respon json, true: berhasil, false: gagal
//                     'message' => 'Validasi gagal.',
//                     'msgfield' => $validator->errors() // menunjukkan field mana yang error
//                 ]);
//             }

//             $check = KategoriModel::find($id);
//             if ($check) {
//                 if (!$request->filled('password')) { // jika password tidak diisi, maka hapus dari request
//                     $request->request->remove('password');
//                 }

//                 $check->update($request->all());
//                 return response()->json([
//                     'status' => true,
//                     'message' => 'Data berhasil diupdate'
//                 ]);
//             } else {
//                 return response()->json([
//                     'status' => false,
//                     'message' => 'Data tidak ditemukan'
//                 ]);
//             }
//         }
//         return redirect('/');
//     }

//     public function confirm_ajax(string $id)
//     {
//         $kategori = KategoriModel::find($id);

//         return view('kategori.confirm_ajax', ['kategori' => $kategori]);
//     }

//     public function delete_ajax(Request $request, $id)
//     {
//         // cek apakah request dari ajax
//         if ($request->ajax() || $request->wantsJson()) {
//             $kategori = KategoriModel::find($id);
//             if ($kategori) {
//                 $kategori->delete();
//                 return response()->json([
//                     'status' => true,
//                     'message' => 'Data berhasil dihapus'
//                 ]);
//             } else {
//                 return response()->json([
//                     'status' => false,
//                     'message' => 'Data tidak ditemukan'
//                 ]);
//             }
//         }
//         return redirect('/');
//     }

// }

    // public function index()
    // {
    //     // $data = [
    //     //     'kategori_kode' => 'SNK',
    //     //     'kategori_nama' => 'Snack/Makanan Ringan',
    //     //     'created_at' => now()
    //     // ];

    //     // DB::table('m_kategori')->insert($data);
    //     // return 'Insert data baru berhasil';

    //     // $row = DB::table('m_kategori')->where('kategori_kode', 'SNK')->update(['kategori_nama' => 'Camilan']);
    //     // return 'Update data berhasil. Jumlah data yang diupdate: '.$row.' baris';

    //     // $row = DB::table('m_kategori')->where('kategori_kode', 'SNK')->delete();
    //     // return 'Delete data berhasil. Jumlah data yang dihapus: '.$row.' baris';
        
    //     $data = DB::table('m_kategori')->get();
    //     return view('kategori', ['data' => $data]);
    // }
