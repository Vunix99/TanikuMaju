<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel;

class HomeController extends Controller
{
    public function index()
    {
        // Mengambil 5 artikel terbaru untuk ditampilkan di halaman beranda
        $artikels = Artikel::latest()->limit(7)->get();
        return view('utama.homepage', compact('artikels'));
    }

    public function detail($id)
    {
        // Mengambil detail artikel berdasarkan ID
        $artikel = Artikel::findOrFail($id);
        return view('utama.artikel.show', compact('artikel'));
    }
}