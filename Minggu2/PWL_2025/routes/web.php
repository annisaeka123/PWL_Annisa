<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\HomeController; 
use App\Http\Controllers\AboutController; 
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\PhotoController;

/**
 * Routing
 */
//Route::get('/hello', function () {
//    return 'Hello World';
//});

//Route::get('/world', function () {
//    return 'World';
//});

//Route::get('/', function () {
//    return 'Selamat Datang';
//});

//Route::get('/about', function () {
//    return '2341720131, Annisa Eka Puspita';
//});

//Route::get('/user/{name}', function ($nama) {
//    return 'Nama saya '.$nama;
//});

//Route::get('/posts/{post}/comments/{comment}', function ($postId, $commentId) { 
//    return 'Pos ke-'.$postId.", Komentar ke-".$commentId; 
//});

//Route::get('/articles/{id}', function ($id) { 
//    return 'Halaman Artikel dengan ID '.$id;
//}); 

//Route::get('/user/{name?}', function ($name=null) { 
//    return 'Nama saya '.$name; 
//});

//Route::get('/user/{name?}', function ($name='John') { 
//    return 'Nama saya '.$name; 
//});


/**
 * Controller
 */
//Route::get('/hello', [WelcomeController::class, 'hello']);
//Route::get('/', [PageController::class, 'index']);
//Route::get('/about', [PageController::class, 'about']); 
//Route::get('/articles/{id)', [PageController::class, 'articles']);

//Route::get('/', [HomeController::class, 'index']); 
//Route::get('/about', [AboutController::class, 'about']); 
//Route::get('/articles/{id}', [ArticleController::class, 'articles']); 
//Route:: resource('photos', Photocontroller::class)->only(['index', 'show']); 
//Route::resource('photos', PhotoController::class)->except(['create', 'store', 'update', 'destroy']);

/**
 * View
 */
//Route::get('/greeting', function () { 
//    return view ('blog.hello', ['name' => 'annisa']); 
//});

Route::get('/greeting', [WelcomeController::class, 'greeting']);