<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    public function Index()
    {

        $data = DB::select('select * from m_barang');
        return view('barang', ['data' => $data]);

    }
}