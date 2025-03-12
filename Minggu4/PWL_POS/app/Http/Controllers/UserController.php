<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {

        /**
         * Jobsheet 4, praktikum 1
         */

        //Untuk menambahkan data baru
        $data = [
            'level_id' => 2,
            'username' => 'manager_tiga', 
            //'username' => 'manager_dua', 
            'nama' => 'Manager 3',
            //'nama' => 'Manager 2',
            'password' => Hash::make('12345')
        ];
        
        UserModel::create($data);

        //mencoba mengakses UserModel
        $user = UserModel::all(); //ambil semua data dari tabel m_user
        return view('user', ['data' => $user]);
        
        /**
         * Jobsheet 2
         */
        
        //tambah data dengan Eloquent Model
        //$data = [
        //    'nama' => 'Pelanggan Pertama',
        //];
        //UserModel::where('username', 'customer-1')->update($data); //update data user

    }
}

