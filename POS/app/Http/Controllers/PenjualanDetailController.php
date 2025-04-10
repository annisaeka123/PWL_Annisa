<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanDetailController extends Controller
{
    public function Index()
    {

        $data = DB::select('select * from t_penjualan_detail');
        return view('penjualan_detail', ['data' => $data]);

    }
}