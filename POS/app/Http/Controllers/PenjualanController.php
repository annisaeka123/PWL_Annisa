<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function Index()
    {

        $data = DB::select('select * from t_penjualan');
        return view('penjualan', ['data' => $data]);

    }
}