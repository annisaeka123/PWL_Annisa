<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    public function Index()
    {

        $data = DB::select('select * from m_kategori');
        return view('kategori', ['data' => $data]);

    }
}