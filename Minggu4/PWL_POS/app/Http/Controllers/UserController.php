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


        //PRAKTIKUM 2.5 - LANGKAH 3
        $user = UserModel::create([
            'username' => 'manager11',
            'nama' => 'Manager11',
            'password' => Hash::make('12345'),
            'level_id' => 2,
        ]);
        
        $user->username = 'manager12';
        
        $user->save();
        
        $user->wasChanged(); // true
        $user->wasChanged('username'); // true
        $user->wasChanged(['username', 'level_id']); // true
        $user->wasChanged('nama'); // false
        
        dd($user->wasChanged(['nama', 'username'])); // true

        //PRAKTIKUM 2.5 - LANGKAH 1
        // $user = UserModel::create([
        //      'username' => 'manager55',
        //      'nama' => 'Manager55',
        //      'password' => Hash::make('12345'),
        //      'level_id' => 2,
        //  ]);
         
        //  $user->username = 'manager56';
         
        //  $user->isDirty(); // true
        //  $user->isDirty('username'); // true
        //  $user->isDirty('nama'); // false
        //  $user->isDirty(['nama', 'username']); // true
         
        //  $user->isClean(); // false
        //  $user->isClean('username'); // false
        //  $user->isClean('nama'); // true
        //  $user->isClean(['nama', 'username']); // false
         
        //  $user->save();
         
        //  $user->isDirty(); // false
        //  $user->isClean(); // true
        //  dd($user->isDirty());

        //*************************************************************** */
        //PRAKTIKUM 2.4- LANGKAH 10
        // $user = UserModel::firstOrNew(
        //     [
        //         'username' => 'manager33',
        //         'nama' => 'Manager Tiga Tiga',
        //         'password' => Hash::make('12345'),
        //         'level_id' => 2
        //     ]
        // );
        
        // $user->save();
        
        // return view('user', ['data' => $user]);

        //PRAKTIKUM 2.4 - LANGKAH 8
        // $user = UserModel::firstOrNew(
        //     [
        //         'username' => 'manager33',
        //         'nama' => 'Manager Tiga Tiga',
        //         'password' => Hash::make('12345'),
        //         'level_id' => 2
        //     ]
        // );
        
        // return view('user', ['data' => $user]);

        //PRAKTIKUM 2.4 - LANGKAH 6
        // $user = UserModel::firstOrNew(
        //     [
        //         'username' => 'manager',
        //         'nama' => 'Manager',
        //     ]
        // );
        
        //return view('user', ['data' => $user]);

        //PRAKTIKUM 2.4 - LANGKAH 4
        // $user = UserModel::firstOrCreate(
        //     [
        //         'username' => 'manager22',
        //         'nama' => 'Manager Dua Dua',
        //         'password' => Hash::make('12345'),
        //         'level_id' => 2
        //     ]
        // );
        
        // return view('user', ['data' => $user]);

        //PRAKTIKUM 2.4 - LANGKAH 1
        // $user = UserModel::firstOrCreate(
        //     [
        //         'username' => 'manager',
        //         'nama' => 'Manager',
        //     ]
        // );
        
        // return view('user', ['data' => $user]);
        
        //*************************************************************** */
        //PRAKTIKUM 2.3 - LANGKAH 3
        //$user = UserModel::where('level_id', 2)->count();
        //return view('user', ['data' => $user]);

        //PRAKTIKUM 2.3 - LANGKAH 1
        // $user = UserModel::where('level_id', 2)->count();
        // dd($user);
        // return view('user', ['data' => $user]);

        //**************************************************************** */
        //PRAKTIKUM 2.2 - LANGKAH 1
        // $user = UserModel::findOrFail(1);
        // return view('user', ['data' => $user]);

        //PRAKTIKUM 2.2 - LANGKAH 3
        //$user = UserModel::where('username', 'manager9')->firstOrFail();
        //return view('user', ['data' => $user]);

        //***************************************************************** */
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

