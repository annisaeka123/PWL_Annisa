<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index() { 
        return 'Selamat Datang'; 
    }

    public function about() { 
        return 'Nama: Annisa Eka Puspita, NIM: 2341720131'; 
    }

    public function articles($id) {
        return 'Halaman Artikel dengan Id '.$id;
    }
}
