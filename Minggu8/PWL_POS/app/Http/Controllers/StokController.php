<?php

namespace App\Http\Controllers;

use App\Models\StokModel;
use App\Models\BarangModel;
use App\Models\UserModel;
use App\Models\SupplierModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;

class StokController extends Controller
{

    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Data Stok',
            'list' => ['Home', 'Stok']
        ];

        $page = (object) [
            'title' => 'Daftar data stok barang'
        ];

        $activeMenu = 'stok';

        $barang = BarangModel::all(); // untuk filter barang

        return view('stok.index', compact('breadcrumb', 'page', 'activeMenu', 'barang'));
    }

    // Ambil data stok dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $stok = StokModel::with(['barang', 'supplier', 'user'])
            ->select('stok_id', 'barang_id', 'supplier_id', 'user_id', 'stok_tanggal', 'stok_jumlah');

        return DataTables::of($stok)
            ->addIndexColumn() // kolom index otomatis (DT_RowIndex)
            ->addColumn('barang_nama', function ($s) {
                return $s->barang->barang_nama ?? '-';
            })
            ->addColumn('supplier_nama', function ($s) {
                return $s->supplier->supplier_nama ?? '-';
            })
            ->addColumn('user_nama', function ($s) {
                return $s->user->nama ?? '-';
            })
            ->addColumn('aksi', function ($s) {
                $btn = '<button onclick="modalAction(\'' . url('/stok/' . $s->stok_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/stok/' . $s->stok_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/stok/' . $s->stok_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // agar html di kolom aksi dirender
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Stok',
            'list' => ['Home', 'Stok', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah data stok baru'
        ];

        $barang = BarangModel::all();
        $user = UserModel::all();
        $supplier = SupplierModel::all();
        $activeMenu = 'stok';

        return view('stok.create', compact('breadcrumb', 'page', 'barang', 'user', 'supplier', 'activeMenu'));
    }

    public function create_ajax()
    {
        $barang = BarangModel::all();
        $supplier = SupplierModel::all();
        $user = UserModel::all();

        return view('stok.create_ajax', compact('barang', 'supplier', 'user'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|integer',
            'user_id' => 'required|integer',
            'supplier_id' => 'required|integer',
            'stok_tanggal' => 'required|date',
            'stok_jumlah' => 'required|integer|min:1'
        ]);

        StokModel::create($request->all());

        return redirect('/stok')->with('success', 'Data stok berhasil disimpan');
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'barang_id'     => 'required|exists:m_barang,barang_id',
                'supplier_id'   => 'required|exists:m_supplier,supplier_id',
                'user_id'       => 'required|exists:m_user,user_id',
                'stok_tanggal'  => 'required|date',
                'stok_jumlah'   => 'required|integer|min:1',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            StokModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data stok berhasil disimpan'
            ]);
        }

        return redirect('/');
    }

    public function edit($id)
    {
        $stok = StokModel::find($id);
        $barang = BarangModel::all();
        $user = UserModel::all();
        $supplier = SupplierModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit Stok',
            'list' => ['Home', 'Stok', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit data stok'
        ];

        $activeMenu = 'stok';

        return view('stok.edit', compact('breadcrumb', 'page', 'stok', 'barang', 'user', 'supplier', 'activeMenu'));
    }

    public function edit_ajax($id)
    {
        $stok = StokModel::find($id);
        $barang = BarangModel::all();
        $supplier = SupplierModel::all();
        $user = UserModel::all();

        return view('stok.edit_ajax', compact('stok', 'barang', 'supplier', 'user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'barang_id' => 'required|integer',
            'user_id' => 'required|integer',
            'supplier_id' => 'required|integer',
            'stok_tanggal' => 'required|date',
            'stok_jumlah' => 'required|integer|min:1'
        ]);

        StokModel::find($id)->update($request->all());

        return redirect('/stok')->with('success', 'Data stok berhasil diubah');
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'barang_id'     => 'required|exists:m_barang,barang_id',
                'supplier_id'   => 'required|exists:m_supplier,supplier_id',
                'user_id'       => 'required|exists:m_user,user_id',
                'stok_tanggal'  => 'required|date',
                'stok_jumlah'   => 'required|integer|min:1',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $stok = StokModel::find($id);
            if ($stok) {
                $stok->update($request->all());

                return response()->json([
                    'status' => true,
                    'message' => 'Data stok berhasil diupdate'
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

    public function confirm_ajax($id)
    {
        $stok = StokModel::find($id);

        return view('stok.confirm_ajax', ['stok' => $stok]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $stok = StokModel::find($id);
            if ($stok) {
                $stok->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data stok berhasil dihapus'
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
        return view('stok.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_stok' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_stok');

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
                            'barang_id'     => $value['A'],
                            'supplier_id'   => $value['B'],
                            'user_id'       => $value['C'],
                            'stok_tanggal'  => $value['D'],
                            'stok_jumlah'   => $value['E'],
                            'created_at'    => now(),
                        ];
                    }
                }

                if (count($insert) > 0) {
                    StokModel::insertOrIgnore($insert);
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

}


// class StokControllerr extends Controller
// {
    /**
     * Jobsheet 5
     */
    // public function index()
    // {
    //     $breadcrumb = (object) [
    //         'title' => 'Data Stok',
    //         'list' => ['Home', 'Stok']
    //     ];

    //     $page = (object) [
    //         'title' => 'Daftar data stok barang'
    //     ];

    //     $activeMenu = 'stok';

    //     $barang = BarangModel::all(); // untuk filter barang

    //     return view('stok.index', compact('breadcrumb', 'page', 'activeMenu', 'barang'));
    // }

    // // public function list(Request $request)
    // // {
    // //     $stok = StokModel::with(['barang', 'user', 'supplier']);

    // //     if ($request->barang_id) {
    // //         $stok->where('barang_id', $request->barang_id);
    // //     }

    // //     return DataTables::of($stok)
    // //         ->addIndexColumn()
    // //         ->addColumn('aksi', function ($stok) {
    // //             $btn  = '<a href="' . url('/stok/' . $stok->stok_id) . '" class="btn btn-info btn-sm">Detail</a> ';
    // //             $btn .= '<a href="' . url('/stok/' . $stok->stok_id . '/edit') . '" class="btn btn-warning btn-sm me-1">Edit</a> ';
    // //             $btn .= '<form class="d-inline-block" method="POST" action="' . url('/stok/' . $stok->stok_id) . '">' .
    // //                     csrf_field() . method_field('DELETE') . 
    // //                     '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Yakin ingin menghapus data ini?\');">Hapus</button>' .
    // //                     '</form> ';
    // //             return $btn;
    // //         })            
    // //         ->rawColumns(['aksi'])
    // //         ->make(true);
    // // }

    // public function create()
    // {
    //     $breadcrumb = (object) [
    //         'title' => 'Tambah Stok',
    //         'list' => ['Home', 'Stok', 'Tambah']
    //     ];

    //     $page = (object) [
    //         'title' => 'Tambah data stok baru'
    //     ];

    //     $barang = BarangModel::all();
    //     $user = UserModel::all();
    //     $supplier = SupplierModel::all();
    //     $activeMenu = 'stok';

    //     return view('stok.create', compact('breadcrumb', 'page', 'barang', 'user', 'supplier', 'activeMenu'));
    // }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'barang_id' => 'required|integer',
    //         'user_id' => 'required|integer',
    //         'supplier_id' => 'required|integer',
    //         'stok_tanggal' => 'required|date',
    //         'stok_jumlah' => 'required|integer|min:1'
    //     ]);

    //     StokModel::create($request->all());

    //     return redirect('/stok')->with('success', 'Data stok berhasil disimpan');
    // }

    // public function show($id)
    // {
    //     $stok = StokModel::with(['barang', 'user', 'supplier'])->find($id);

    //     $breadcrumb = (object) [
    //         'title' => 'Detail Stok',
    //         'list' => ['Home', 'Stok', 'Detail']
    //     ];

    //     $page = (object) [
    //         'title' => 'Detail data stok'
    //     ];

    //     $activeMenu = 'stok';

    //     return view('stok.show', compact('breadcrumb', 'page', 'stok', 'activeMenu'));
    // }

    // public function edit($id)
    // {
    //     $stok = StokModel::find($id);
    //     $barang = BarangModel::all();
    //     $user = UserModel::all();
    //     $supplier = SupplierModel::all();

    //     $breadcrumb = (object) [
    //         'title' => 'Edit Stok',
    //         'list' => ['Home', 'Stok', 'Edit']
    //     ];

    //     $page = (object) [
    //         'title' => 'Edit data stok'
    //     ];

    //     $activeMenu = 'stok';

    //     return view('stok.edit', compact('breadcrumb', 'page', 'stok', 'barang', 'user', 'supplier', 'activeMenu'));
    // }

    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'barang_id' => 'required|integer',
    //         'user_id' => 'required|integer',
    //         'supplier_id' => 'required|integer',
    //         'stok_tanggal' => 'required|date',
    //         'stok_jumlah' => 'required|integer|min:1'
    //     ]);

    //     StokModel::find($id)->update($request->all());

    //     return redirect('/stok')->with('success', 'Data stok berhasil diubah');
    // }

    // public function destroy($id)
    // {
    //     $check = StokModel::find($id);

    //     if (!$check) {
    //         return redirect('/stok')->with('error', 'Data stok tidak ditemukan');
    //     }

    //     try {
    //         StokModel::destroy($id);
    //         return redirect('/stok')->with('success', 'Data stok berhasil dihapus');
    //     } catch (\Illuminate\Database\QueryException $e) {
    //         return redirect('/stok')->with('error', 'Gagal menghapus data stok karena data masih terhubung dengan tabel lain');
    //     }
    // }


    /**
     * Jobsheet 6
     */
//     public function create_ajax()
//     {
//         $barang = BarangModel::all();
//         $supplier = SupplierModel::all();
//         $user = UserModel::all();

//         return view('stok.create_ajax', compact('barang', 'supplier', 'user'));
//     }

//     public function store_ajax(Request $request)
//     {
//         if ($request->ajax() || $request->wantsJson()) {
//             $rules = [
//                 'barang_id'     => 'required|exists:m_barang,barang_id',
//                 'supplier_id'   => 'required|exists:m_supplier,supplier_id',
//                 'user_id'       => 'required|exists:m_user,user_id',
//                 'stok_tanggal'  => 'required|date',
//                 'stok_jumlah'   => 'required|integer|min:1',
//             ];

//             $validator = Validator::make($request->all(), $rules);

//             if ($validator->fails()) {
//                 return response()->json([
//                     'status' => false,
//                     'message' => 'Validasi gagal',
//                     'msgField' => $validator->errors()
//                 ]);
//             }

//             StokModel::create($request->all());

//             return response()->json([
//                 'status' => true,
//                 'message' => 'Data stok berhasil disimpan'
//             ]);
//         }

//         return redirect('/');
//     }

//     // Ambil data stok dalam bentuk json untuk datatables
//     public function list(Request $request)
//     {
//         $stok = StokModel::with(['barang', 'supplier', 'user'])
//             ->select('stok_id', 'barang_id', 'supplier_id', 'user_id', 'stok_tanggal', 'stok_jumlah');

//         return DataTables::of($stok)
//             ->addIndexColumn() // kolom index otomatis (DT_RowIndex)
//             ->addColumn('barang_nama', function ($s) {
//                 return $s->barang->barang_nama ?? '-';
//             })
//             ->addColumn('supplier_nama', function ($s) {
//                 return $s->supplier->supplier_nama ?? '-';
//             })
//             ->addColumn('user_nama', function ($s) {
//                 return $s->user->nama ?? '-';
//             })
//             ->addColumn('aksi', function ($s) {
//                 $btn = '<button onclick="modalAction(\'' . url('/stok/' . $s->stok_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
//                 $btn .= '<button onclick="modalAction(\'' . url('/stok/' . $s->stok_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
//                 $btn .= '<button onclick="modalAction(\'' . url('/stok/' . $s->stok_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
//                 return $btn;
//             })
//             ->rawColumns(['aksi']) // agar html di kolom aksi dirender
//             ->make(true);
//     }

//     public function edit_ajax($id)
//     {
//         $stok = StokModel::find($id);
//         $barang = BarangModel::all();
//         $supplier = SupplierModel::all();
//         $user = UserModel::all();

//         return view('stok.edit_ajax', compact('stok', 'barang', 'supplier', 'user'));
//     }

//     public function update_ajax(Request $request, $id)
//     {
//         if ($request->ajax() || $request->wantsJson()) {
//             $rules = [
//                 'barang_id'     => 'required|exists:m_barang,barang_id',
//                 'supplier_id'   => 'required|exists:m_supplier,supplier_id',
//                 'user_id'       => 'required|exists:m_user,user_id',
//                 'stok_tanggal'  => 'required|date',
//                 'stok_jumlah'   => 'required|integer|min:1',
//             ];

//             $validator = Validator::make($request->all(), $rules);

//             if ($validator->fails()) {
//                 return response()->json([
//                     'status' => false,
//                     'message' => 'Validasi gagal',
//                     'msgField' => $validator->errors()
//                 ]);
//             }

//             $stok = StokModel::find($id);
//             if ($stok) {
//                 $stok->update($request->all());

//                 return response()->json([
//                     'status' => true,
//                     'message' => 'Data stok berhasil diupdate'
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

//     public function confirm_ajax($id)
//     {
//         $stok = StokModel::find($id);

//         return view('stok.confirm_ajax', ['stok' => $stok]);
//     }

//     public function delete_ajax(Request $request, $id)
//     {
//         if ($request->ajax() || $request->wantsJson()) {
//             $stok = StokModel::find($id);
//             if ($stok) {
//                 $stok->delete();
//                 return response()->json([
//                     'status' => true,
//                     'message' => 'Data stok berhasil dihapus'
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