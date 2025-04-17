<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenjualanModel;
use App\Models\PenjualanDetailModel;
use Illuminate\Support\Facades\DB;
use App\Models\UserModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\BarangModel;
use App\Models\StokModel;

class PenjualanController extends Controller
{

    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Transaksi Penjualan',
            'list' => ['Home', 'Transaksi Penjualan']
        ];

        $page = (object) [
            'title' => 'Transaksi penjualan barang yang terdaftar dalam sistem'
        ];

        $activeMenu = 'penjualan';

        $user = UserModel::all();

        return view('penjualan.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'user' => $user,
            'activeMenu' => $activeMenu
        ]);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Transaksi',
            'list' => ['Home', 'Transaksi', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Transaksi Penjualan Baru'
        ];

        $user = UserModel::all();
        $activeMenu = 'penjualan';

        return view('penjualan.create', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'user' => $user,
            'activeMenu' => $activeMenu
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'penjualan_kode' => 'required|string|max:10|unique:m_penjualan,penjualan_kode',
            'pembeli' => 'required|string|max:100',
            'penjualan_tanggal' => 'required|string',
            'user_id' => 'required|exists:m_user,user_id' // validasi berdasarkan tabel user
        ]);
        
        PenjualanModel::create([
            'penjualan_kode' => $request->penjualan_kode,
            'pembeli' => $request->pembeli,
            'penjualan_tanggal' => $request->penjualan_tanggal,
            'user_id' => $request->user_id
        ]);

        return redirect('/penjualan')->with('success', 'Transaksi baru berhasil disimpan');
    }

    public function show($id)
    {
        $penjualan = PenjualanModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Transaksi',
            'list' => ['Home', 'Transaksi', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Transaksi'
        ];

        $activeMenu = 'penjualan';

        return view('penjualan.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'penjualan' => $penjualan,
            'activeMenu' => $activeMenu
        ]);
    }

    public function edit($id)
    {
        $penjualan = PenjualanModel::find($id);
        $user = UserModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit Transaksi',
            'list' => ['Home', 'Transaksi', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Transaksi'
        ];

        $activeMenu = 'penjualan';

        return view('penjualan.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'penjualan' => $penjualan,
            'user' => $user,
            'activeMenu' => $activeMenu
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'penjualan_kode' => 'required|string|max:10|unique:m_penjualan,penjualan_kode',
            'pembeli' => 'required|string|max:100',
            'penjualan_tanggal' => 'required|string',
            'user_id' => 'required|exists:m_user,user_id' // validasi berdasarkan tabel user
        ]);
        
        PenjualanModel::create([
            'penjualan_kode' => $request->penjualan_kode,
            'pembeli' => $request->pembeli,
            'penjualan_tanggal' => $request->penjualan_tanggal,
            'user_id' => $request->user_id
        ]);      

        return redirect('/penjualan')->with('success', 'Transaksi berhasil diubah');
    }

    public function destroy($id)
    {
        $check = PenjualanModel::find($id);

        if (!$check) {
            return redirect('/penjualan')->with('error', 'Transaksi penjualan tidak ditemukan');
        }

        try {
            PenjualanModel::destroy($id);
            return redirect('/penjualan')->with('success', 'Data transaksi penjualan berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/penjualan')->with('error', 'Data gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    
    public function create_ajax()
    {
        $user   = UserModel::select('user_id', 'nama')->get();
        $barang = BarangModel::select('barang_id', 'barang_nama', 'harga_jual')->get();

        return view('penjualan.create_ajax', compact('user', 'barang'));
    }

    public function store_ajax(Request $request)
    {
        if (! $request->ajax() && ! $request->wantsJson()) {
            return redirect()->back();
        }
    
        $rules = [
            'user_id'             => 'required|integer|exists:m_user,user_id',
            'pembeli'             => 'required|string|min:3',
            'penjualan_tanggal'   => 'required|date',
    
            'barang_id'           => 'required|array|min:1',
            'barang_id.*'         => 'required|integer|exists:m_barang,barang_id',
    
            'harga'               => 'required|array',
            'harga.*'             => 'required|numeric|min:1',
    
            'jumlah'              => 'required|array',
            'jumlah.*'            => 'required|integer|min:1',
    
            'penjualan_kode'      => 'required|string|unique:t_penjualan,penjualan_kode',
        ];
    
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status'   => false,
                'message'  => 'Validasi gagal.',
                'msgField' => $validator->errors(),
            ], 422);
        }
    
        // 🔎 Validasi stok cukup
        foreach ($request->barang_id as $i => $barangId) {
            $stok = StokModel::where('barang_id', $barangId)->first();
            $jumlahDiminta = $request->jumlah[$i];
    
            if (!$stok || $stok->stok_jumlah < $jumlahDiminta) {
                $barang = BarangModel::find($barangId);
                return response()->json([
                    'status'  => false,
                    'message' => 'Stok untuk "' . $barang->barang_nama . '" tidak mencukupi. Tersisa: ' . ($stok->stok_jumlah ?? 0),
                ], 422);
            }
        }
    
        // 💾 Simpan transaksi
        try {
            DB::transaction(function () use ($request) {
                $penjualan = PenjualanModel::create([
                    'user_id'           => $request->user_id,
                    'pembeli'           => $request->pembeli,
                    'penjualan_kode'    => $request->penjualan_kode,
                    'penjualan_tanggal' => $request->penjualan_tanggal,
                ]);
    
                foreach ($request->barang_id as $i => $barangId) {
                    $jumlah = $request->jumlah[$i];
                    $harga  = $request->harga[$i];
    
                    PenjualanDetailModel::create([
                        'penjualan_id' => $penjualan->penjualan_id,
                        'barang_id'    => $barangId,
                        'harga'        => $harga,
                        'jumlah'       => $jumlah,
                    ]);
    
                    StokModel::where('barang_id', $barangId)
                             ->decrement('stok_jumlah', $jumlah);
                }
            });
    
            return response()->json([
                'status'  => true,
                'message' => 'Penjualan berhasil disimpan.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Server error: ' . $e->getMessage(),
            ], 500);
        }
    }
          
     // Ambil data level dalam bentuk json untuk datatables
     public function list(Request $request)
     {
     $penjualan = PenjualanModel::with(['user']);
     return DataTables::of($penjualan)
         ->addIndexColumn()
         ->addColumn('aksi', function ($penjualan) {
            $btn = '<button onclick="modalAction(\'' . url('/penjualan/' . $penjualan->penjualan_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
            $btn .= '<a href="' . url('/penjualan/' . $penjualan->penjualan_id . '/struk_pdf') . '" target="_blank" class="btn btn-warning btn-sm">Cetak Struk</a> ';
            $btn .= '<button onclick="modalAction(\'' . url('/penjualan/' . $penjualan->penjualan_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';

            return $btn;
         })
         ->rawColumns(['aksi'])
         ->make(true);
     }
 
     // Menampilkan halaman form edit level ajax
     public function edit_ajax(string $id)
     {
         $penjualan = PenjualanModel::find($id);
         $user = UserModel::select('user_id', 'nama')->get();
 
         return view('penjualan.edit_ajax', ['penjualan' => $penjualan, 'user' => $user]);
     }

     public function update_ajax(Request $request, $id)
     {  
         // cek apakah request dari ajax
         if ($request->ajax() || $request->wantsJson()) {
             $rules = [
                'penjualan_kode' => 'required|max:20|unique:t_penjualan,penjualan_kode,' . $id . ',penjualan_id',
                'user_id' => 'required|integer',
                'pembeli' => 'required|string|max:100',
                'penjualan_tanggal' => 'required|string|date'
             ];
 
             $validator = Validator::make($request->all(), $rules);
 
             if ($validator->fails()) {
                 return response()->json([
                     'status' => false, // respon json, true: berhasil, false: gagal
                     'message' => 'Validasi gagal.',
                     'msgfield' => $validator->errors() // menunjukkan field mana yang error
                 ]);
             }
 
             $check = PenjualanModel::find($id);
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
         $penjualan = PenjualanModel::find($id);
 
         return view('penjualan.confirm_ajax', ['penjualan' => $penjualan]);
     }
 
     public function delete_ajax(Request $request, $id)
     {
         // cek apakah request dari ajax
         if ($request->ajax() || $request->wantsJson()) {
             $penjualan = PenjualanModel::find($id);
             if ($penjualan) {
                 $penjualan->delete();
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

     public function show_ajax($id)
     {
         $penjualan = PenjualanModel::with(['user', 'detail.barang'])->find($id);
     
         return view('penjualan.show_ajax', compact('penjualan'));
     }
     

    public function import()
    {
        return view('penjualan.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_penjualan' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_penjualan');
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
                            'penjualan_kode' => $value['A'],
                            'pembeli' => $value['B'],
                            'penjualan_tanggal' => $value['C'],
                            'user_id' => $value['D'],
                            'created_at' => now(),
                        ];
                    }
                }

                if (count($insert) > 0) {
                    PenjualanModel::insertOrIgnore($insert);
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Data penjualan berhasil diimport'
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
        $penjualans = PenjualanModel::with('user')
                        ->orderBy('penjualan_tanggal')
                        ->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Transaksi');
        $sheet->setCellValue('C1', 'Pembeli');
        $sheet->setCellValue('D1', 'Tanggal');
        $sheet->setCellValue('E1', 'Pegawai');

        $sheet->getStyle('A1:E1')->getFont()->setBold(true);

        // Isi data
        $baris = 2;
        $no = 1;
        foreach ($penjualans as $p) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $p->penjualan_kode);
            $sheet->setCellValue('C' . $baris, $p->pembeli);
            $sheet->setCellValue('D' . $baris, $p->penjualan_tanggal);
            $sheet->setCellValue('E' . $baris, $p->user ? $p->user->nama : '-');

            $baris++;
            $no++;
        }

        foreach (range('A', 'E') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $sheet->setTitle('Data Penjualan');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data_Penjualan_' . date('Y-m-d_H-i-s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$filename\"");
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }

    public function export_pdf()
    {
        $penjualans = PenjualanModel::with('user')
                        ->orderBy('penjualan_tanggal')
                        ->get();

        $pdf = Pdf::loadView('penjualan.export_pdf', ['penjualans' => $penjualans]);
        $pdf->setPaper('a4', 'landscape');
        $pdf->setOption("isRemoteEnabled", true);

        return $pdf->stream('Data_Penjualan_' . date('Y-m-d_H-i-s') . '.pdf');
    }

    public function cetak_struk($id)
    {
        $penjualan = PenjualanModel::with(['user', 'detail.barang'])->find($id);
    
        if (!$penjualan) {
            return redirect('/penjualan')->with('error', 'Data penjualan tidak ditemukan.');
        }
    
        $pdf = Pdf::loadView('penjualan.struk_pdf', compact('penjualan'));
        $pdf->setPaper([0, 0, 250, 600], 'portrait'); // ukuran struk (mm ke point)
        $pdf->setOption('isRemoteEnabled', true);
        $pdf->render();
  
        return $pdf->stream('Struk-' . $penjualan->penjualan_kode . '.pdf');
    }



}
