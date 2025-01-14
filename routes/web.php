<?php

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
if (! function_exists('utama'))
{
    function utama($view) {
        return view("utama.$view");
    }
}

Route::get('/', function () {
    return utama('index');
});

Route::get('/login', function () {
    return redirect('/');
});

Route::get('/registrasi', function () {
    return utama('register');
});

Route::get('/beranda', function () {
    // Mengambil API Key dari .env
    $apiKey = env('API_KEY_OPENWEATHER');
    
    // Mengecek apakah API Key ada
    if (!$apiKey) {
        abort(500, 'API Key tidak ditemukan');
    }

    // Mengirim API Key ke view 'homepage'
    return view('utama.homepage', compact('apiKey'));
});

Route::get('/chatai', function () {
    return utama('chatai');
});


Route::get('/artikel', function () {
    return utama('artikel.index');
});

Route::get('/artikel/detail', function () {
    return utama('artikel.show');
});

Route::get('/diskusi', function () {
    return utama('diskusi.index');
});

Route::get('/diskusi/chat/{id}', function () {
    return utama('diskusi.show');
});

Route::get('/profil', function () {
    return utama('profil');
});

Route::get('/kalkulasi', function () {
    return view('utama.kalkulasi');
})->name('kalkulasi');




