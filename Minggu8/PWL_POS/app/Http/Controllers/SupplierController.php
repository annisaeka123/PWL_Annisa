<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupplierModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;

class SupplierController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Supplier',
            'list' => ['Home', 'Supplier']
        ];

        $page = (object) [
            'title' => 'Daftar Supplier untuk Barang'
        ];

        $activeMenu = 'supplier';

        $supplier = SupplierModel::all();

        return view('supplier.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'supplier' => $supplier,
            'activeMenu' => $activeMenu
        ]);
    }

    // Ambil data supplier dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $suppliers = SupplierModel::select('supplier_id', 'supplier_kode', 'supplier_nama', 'supplier_alamat');

        return DataTables::of($suppliers)
            ->addIndexColumn()  // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($supplier) {  // menambahkan kolom aksi
                 $btn = '<button onclick="modalAction(\'' . url('/supplier/' . $supplier->supplier_id) . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/supplier/' . $supplier->supplier_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/supplier/' . $supplier->supplier_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';

                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Supplier',
            'list' => ['Home', 'Supplier', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah supplier baru'
        ];

        $supplier = SupplierModel::all();
        $activeMenu = 'supplier';

        return view('supplier.create', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'supplier' => $supplier,
            'activeMenu' => $activeMenu
        ]);
    }

    public function create_ajax()
    {
        return view('supplier.create_ajax');
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_kode' => 'required|string|max:10|unique:m_supplier,supplier_kode',
            'supplier_nama' => 'required|string|max:100',
            'supplier_alamat' => 'required|string|max:255'
        ]);

        SupplierModel::create([
            'supplier_kode' => $request->supplier_kode,
            'supplier_nama' => $request->supplier_nama,
            'supplier_alamat' => $request->supplier_alamat
        ]);

        return redirect('/supplier')->with('success', 'Supplier baru berhasil disimpan');
    }

    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'supplier_kode' => 'required|string|min:3|unique:m_supplier,supplier_kode',
                'supplier_nama' => 'required|string|max:100',
                'supplier_alamat' => 'required|string|max:100'
            ];


            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // response status, false: error/gagal, true: berhasil
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors() // pesan error validasi
                ]);
            }

            SupplierModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data supplier berhasil disimpan'
            ]);
        }
        redirect('/');
    }

    public function show($id)
    {
        $supplier = SupplierModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Supplier',
            'list' => ['Home', 'Supplier', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail supplier'
        ];

        $activeMenu = 'supplier';

        return view('supplier.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'supplier' => $supplier,
            'activeMenu' => $activeMenu
        ]);
    }

    public function edit($id)
    {
        $supplier = SupplierModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Supplier',
            'list' => ['Home', 'Supplier', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Supplier'
        ];

        $activeMenu = 'supplier';

        return view('supplier.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'supplier' => $supplier,
            'activeMenu' => $activeMenu
        ]);
    }

    // Menampilkan halaman form edit supplier ajax
    public function edit_ajax(string $id)
    {
        $supplier = SupplierModel::find($id);

        return view('supplier.edit_ajax', ['supplier' => $supplier]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'supplier_kode' => 'required|string|max:10',
            'supplier_nama' => 'required|string|max:100',
            'supplier_alamat' => 'required|string|max:255'
        ]);

        SupplierModel::find($id)->update([
            'supplier_kode' => $request->supplier_kode,
            'supplier_nama' => $request->supplier_nama,
            'supplier_alamat' => $request->supplier_alamat
        ]);

        return redirect('/supplier')->with('success', 'Supplier berhasil diubah');
    }

    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'supplier_kode' => 'required|max:20|unique:m_supplier,supplier_kode,' . $id . ',supplier_id',
                'supplier_nama' => 'required|max:100',
                'supplier_alamat' => 'required|max:100'
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

            $check = SupplierModel::find($id);
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
        $supplier = SupplierModel::find($id);

        return view('supplier.confirm_ajax', ['supplier' => $supplier]);
    }

    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $supplier = SupplierModel::find($id);
            if ($supplier) {
                $supplier->delete();
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
        return view('supplier.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_supplier' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_supplier');

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
                            'supplier_kode'   => $value['A'],
                            'supplier_nama'   => $value['B'],
                            'supplier_alamat' => $value['C'],
                            'created_at'      => now(),
                        ];
                    }
                }

                if (count($insert) > 0) {
                    SupplierModel::insertOrIgnore($insert);
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
        // Ambil data supplier
        $suppliers = SupplierModel::select('supplier_kode', 'supplier_nama', 'supplier_alamat')
                        ->orderBy('supplier_nama')
                        ->get();
    
        // Buat spreadsheet baru
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
    
        // Header kolom
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Supplier');
        $sheet->setCellValue('C1', 'Nama Supplier');
        $sheet->setCellValue('D1', 'Alamat');
    
        $sheet->getStyle('A1:D1')->getFont()->setBold(true); // Tebal header
    
        // Isi data
        $no = 1;
        $baris = 2;
    
        foreach ($suppliers as $supplier) {
            $sheet->setCellValue('A' . $baris, $no++);
            $sheet->setCellValue('B' . $baris, $supplier->supplier_kode);
            $sheet->setCellValue('C' . $baris, $supplier->supplier_nama);
            $sheet->setCellValue('D' . $baris, $supplier->supplier_alamat);
            $baris++;
        }
    
        // Auto-size kolom
        foreach (range('A', 'D') as $kolom) {
            $sheet->getColumnDimension($kolom)->setAutoSize(true);
        }
    
        // Judul Sheet
        $sheet->setTitle('Data Supplier');
    
        // Set nama file
        $filename = 'Data Supplier ' . date('Y-m-d H:i:s') . '.xlsx';
    
        // Header HTTP untuk download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');
    
        // Simpan dan kirim ke output
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }
    

}


// class SupplierControllerr extends Controller
// {
    /**
     * Jobsheet 5
     */
    // public function index()
    // {
    //     $breadcrumb = (object) [
    //         'title' => 'Daftar Supplier',
    //         'list' => ['Home', 'Supplier']
    //     ];

    //     $page = (object) [
    //         'title' => 'Daftar Supplier untuk Barang'
    //     ];

    //     $activeMenu = 'supplier';

    //     $supplier = SupplierModel::all();

    //     return view('supplier.index', [
    //         'breadcrumb' => $breadcrumb,
    //         'page' => $page,
    //         'supplier' => $supplier,
    //         'activeMenu' => $activeMenu
    //     ]);
    // }

    // // public function list(Request $request)
    // // {
    // //     $suppliers = SupplierModel::select('supplier_id', 'supplier_kode', 'supplier_nama', 'supplier_alamat');

    // //     if ($request->supplier_id) {
    // //         $suppliers->where('supplier_id', $request->supplier_id);
    // //     }

    // //     return DataTables::of($suppliers)
    // //         ->addIndexColumn()
    // //         ->addColumn('aksi', function ($supplier) {
    // //             $btn = '<a href="' . url('/supplier/' . $supplier->supplier_id) . '" class="btn btn-info btn-sm">Detail</a> ';
    // //             $btn .= '<a href="' . url('/supplier/' . $supplier->supplier_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
    // //             $btn .= '<form class="d-inline-block" method="POST" action="' . url('/supplier/' . $supplier->supplier_id) . '">'
    // //                 . csrf_field() . method_field('DELETE') .
    // //                 '<button type="submit" class="btn btn-danger btn-sm" 
    // //                 onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\')">Hapus</button></form>';
    // //             return $btn;
    // //         })
    // //         ->rawColumns(['aksi'])
    // //         ->make(true);
    // // }

    // public function create()
    // {
    //     $breadcrumb = (object) [
    //         'title' => 'Tambah Supplier',
    //         'list' => ['Home', 'Supplier', 'Tambah']
    //     ];

    //     $page = (object) [
    //         'title' => 'Tambah supplier baru'
    //     ];

    //     $supplier = SupplierModel::all();
    //     $activeMenu = 'supplier';

    //     return view('supplier.create', [
    //         'breadcrumb' => $breadcrumb,
    //         'page' => $page,
    //         'supplier' => $supplier,
    //         'activeMenu' => $activeMenu
    //     ]);
    // }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'supplier_kode' => 'required|string|max:10|unique:m_supplier,supplier_kode',
    //         'supplier_nama' => 'required|string|max:100',
    //         'supplier_alamat' => 'required|string|max:255'
    //     ]);

    //     SupplierModel::create([
    //         'supplier_kode' => $request->supplier_kode,
    //         'supplier_nama' => $request->supplier_nama,
    //         'supplier_alamat' => $request->supplier_alamat
    //     ]);

    //     return redirect('/supplier')->with('success', 'Supplier baru berhasil disimpan');
    // }

    // public function show($id)
    // {
    //     $supplier = SupplierModel::find($id);

    //     $breadcrumb = (object) [
    //         'title' => 'Detail Supplier',
    //         'list' => ['Home', 'Supplier', 'Detail']
    //     ];

    //     $page = (object) [
    //         'title' => 'Detail supplier'
    //     ];

    //     $activeMenu = 'supplier';

    //     return view('supplier.show', [
    //         'breadcrumb' => $breadcrumb,
    //         'page' => $page,
    //         'supplier' => $supplier,
    //         'activeMenu' => $activeMenu
    //     ]);
    // }

    // public function edit($id)
    // {
    //     $supplier = SupplierModel::find($id);

    //     $breadcrumb = (object) [
    //         'title' => 'Edit Supplier',
    //         'list' => ['Home', 'Supplier', 'Edit']
    //     ];

    //     $page = (object) [
    //         'title' => 'Edit Supplier'
    //     ];

    //     $activeMenu = 'supplier';

    //     return view('supplier.edit', [
    //         'breadcrumb' => $breadcrumb,
    //         'page' => $page,
    //         'supplier' => $supplier,
    //         'activeMenu' => $activeMenu
    //     ]);
    // }

    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'supplier_kode' => 'required|string|max:10',
    //         'supplier_nama' => 'required|string|max:100',
    //         'supplier_alamat' => 'required|string|max:255'
    //     ]);

    //     SupplierModel::find($id)->update([
    //         'supplier_kode' => $request->supplier_kode,
    //         'supplier_nama' => $request->supplier_nama,
    //         'supplier_alamat' => $request->supplier_alamat
    //     ]);

    //     return redirect('/supplier')->with('success', 'Supplier berhasil diubah');
    // }

    // public function destroy($id)
    // {
    //     $check = SupplierModel::find($id);

    //     if (!$check) {
    //         return redirect('/supplier')->with('error', 'Supplier tidak ditemukan');
    //     }

    //     try {
    //         SupplierModel::destroy($id);
    //         return redirect('/supplier')->with('success', 'Data supplier berhasil dihapus');
    //     } catch (\Illuminate\Database\QueryException $e) {
    //         return redirect('/supplier')->with('error', 'Data gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
    //     }
    // }



    /**
     * Jobsheet 6
     */

//     public function create_ajax()
//     {
//         return view('supplier.create_ajax');
//     }

//     public function store_ajax(Request $request)
//     {
//         // cek apakah request berupa ajax
//         if ($request->ajax() || $request->wantsJson()) {
//             $rules = [
//                 'supplier_kode' => 'required|string|min:3|unique:m_supplier,supplier_kode',
//                 'supplier_nama' => 'required|string|max:100',
//                 'supplier_alamat' => 'required|string|max:100'
//             ];


//             $validator = Validator::make($request->all(), $rules);

//             if ($validator->fails()) {
//                 return response()->json([
//                     'status' => false, // response status, false: error/gagal, true: berhasil
//                     'message' => 'Validasi Gagal',
//                     'msgField' => $validator->errors() // pesan error validasi
//                 ]);
//             }

//             SupplierModel::create($request->all());

//             return response()->json([
//                 'status' => true,
//                 'message' => 'Data supplier berhasil disimpan'
//             ]);
//         }
//         redirect('/');
//     }

//     // Ambil data supplier dalam bentuk json untuk datatables
//     public function list(Request $request)
//     {
//         $suppliers = SupplierModel::select('supplier_id', 'supplier_kode', 'supplier_nama', 'supplier_alamat');

//         return DataTables::of($suppliers)
//             ->addIndexColumn()  // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
//             ->addColumn('aksi', function ($supplier) {  // menambahkan kolom aksi
//                  $btn = '<button onclick="modalAction(\'' . url('/supplier/' . $supplier->supplier_id) . '\')" class="btn btn-info btn-sm">Detail</button> ';
//                 $btn .= '<button onclick="modalAction(\'' . url('/supplier/' . $supplier->supplier_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
//                 $btn .= '<button onclick="modalAction(\'' . url('/supplier/' . $supplier->supplier_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';

//                 return $btn;
//             })
//             ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
//             ->make(true);
//     }

//     // Menampilkan halaman form edit supplier ajax
//     public function edit_ajax(string $id)
//     {
//         $supplier = SupplierModel::find($id);

//         return view('supplier.edit_ajax', ['supplier' => $supplier]);
//     }

//     public function update_ajax(Request $request, $id)
//     {
//         // cek apakah request dari ajax
//         if ($request->ajax() || $request->wantsJson()) {
//             $rules = [
//                 'supplier_kode' => 'required|max:20|unique:m_supplier,supplier_kode,' . $id . ',supplier_id',
//                 'supplier_nama' => 'required|max:100',
//                 'supplier_alamat' => 'required|max:100'
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

//             $check = SupplierModel::find($id);
//             if ($check) {

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
//         $supplier = SupplierModel::find($id);

//         return view('supplier.confirm_ajax', ['supplier' => $supplier]);
//     }

//     public function delete_ajax(Request $request, $id)
//     {
//         // cek apakah request dari ajax
//         if ($request->ajax() || $request->wantsJson()) {
//             $supplier = SupplierModel::find($id);
//             if ($supplier) {
//                 $supplier->delete();
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
