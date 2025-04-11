<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenjualanModel;
use App\Models\UserModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

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
        $user = UserModel::select('user_id', 'nama')->get();

         return view('penjualan.create_ajax', ['user' => $user]);
     }

     public function store_ajax(Request $request)
     {
         // cek apakah request berupa ajax
         if ($request->ajax() || $request->wantsJson()) {
             $rules = [
                 'penjualan_kode' => 'required|string|min:3|unique:m_penjualan,penjualan_kode',
                 'user_id' => 'required|integer',
                 'pembeli' => 'required|string|max:100',
                 'penjualan_tanggal' => 'required|date'
             ];
 
 
             $validator = Validator::make($request->all(), $rules);
 
             if ($validator->fails()) {
                 return response()->json([
                     'status' => false, // response status, false: error/gagal, true: berhasil
                     'message' => 'Validasi Gagal',
                     'msgField' => $validator->errors() // pesan error validasi
                 ]);
             }
 
             PenjualanModel::create($request->all());
 
             return response()->json([
                 'status' => true,
                 'message' => 'Data Transaksi Penjualan berhasil disimpan'
             ]);
         }
 
         redirect('/');
     }
 
     // Ambil data level dalam bentuk json untuk datatables
     public function list(Request $request)
     {
         $penjualans = PenjualanModel::select('penjualan_id', 'penjualan_kode', 'pembeli', 'penjualan_tanggal', 'user_id')
                        -> with('user');
 
         return DataTables::of($penjualans)
             ->addIndexColumn()  // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
             ->addColumn('aksi', function ($penjualan) {  // menambahkan kolom aksi
                 $btn = '<button onclick="modalAction(\'' . url('/penjualanDetail/' . $penjualan->penjualan_id) . '\')" class="btn btn-info btn-sm">Detail</button> ';
                 $btn .= '<button onclick="modalAction(\'' . url('/penjualan/' . $penjualan->penjualan_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                 $btn .= '<button onclick="modalAction(\'' . url('/penjualan/' . $penjualan->penjualan_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
 
                 return $btn;
             })
             ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
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

}
