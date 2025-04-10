<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    public function Index()
    {

        $data = DB::select('select * from m_supplier');
        return view('supplier', ['data' => $data]);

    }
}