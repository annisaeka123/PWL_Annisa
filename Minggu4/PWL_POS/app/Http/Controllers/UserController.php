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
         * Jobsheet 4
         */
        //PRAKTIKUM 2.1 - LANGKAH 1
        //$user = UserModel::find(1);
        //return view('user', ['data' => $user]);

        //PRAKTIKUM 2.1 - LANGKAH 4
        //$user = UserModel::firstWhere('level_id', 1)->first();
        //return view('user', ['data' => $user]);

        //PRAKTIKUM 2.1 - LANGKAH 6
        // $user = UserModel::firstWhere('level_id', 1);
        // return view('user', ['data' => $user]);       
        
        //PRAKTIKUM 2.1 - LANGKAH 8
        // $user = UserModel::findOr(1, ['username', 'nama'], function () {
            // abort(404);
        // });
        //return view('user', ['data' => $user]);

        //PARKTIKUM 2.1 - LANGKAH 10
        $user = UserModel::findOr(20, ['username', 'nama'], function () {
            abort(404);
        });
        
        return view('user', ['data' => $user]);

        //***************************************************************************************** */
        //PRAKTIKUM 1
        //$data = [  //Untuk menambahkan data baru
        //    'level_id' => 2,
        //    'username' => 'manager_tiga', 
            //'username' => 'manager_dua', 
        //    'nama' => 'Manager 3',
            //'nama' => 'Manager 2',
        //    'password' => Hash::make('12345')
        //];
        
        //UserModel::create($data);

        //mencoba mengakses UserModel
        //$user = UserModel::all(); //ambil semua data dari tabel m_user
        //return view('user', ['data' => $user]);
        
        //=======================================================================================
        /**
         * Jobsheet 3
         */
        
        //tambah data dengan Eloquent Model
        //$data = [
        //    'nama' => 'Pelanggan Pertama',
        //];
        //UserModel::where('username', 'customer-1')->update($data); //update data user

    }
}

