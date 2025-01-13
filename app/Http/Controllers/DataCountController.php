<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paket;
use App\Models\Satuan;
use App\Models\Review;
use App\Models\User;

class DataCountController extends Controller
{
    /**
     * Menghitung total data di tabel paket berdasarkan kategori, serta total di tabel satuan, reviews, dan users.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function countData()
    {
        // Hitung jumlah data di tabel paket berdasarkan kategori
        $totalPaketNasiKotak = Paket::where('kategori', 'nasi_kotak')->count();
        $totalPaketPrasmanan = Paket::where('kategori', 'prasmanan')->count();

        // Hitung jumlah data di tabel satuan, reviews, dan users
        $totalSatuan = Satuan::count();
        $totalReviews = Review::count();
        $totalUsers = User::count();

        // Gabungkan hasilnya dalam array dan kembalikan sebagai JSON
        return response()->json([
            'total_paket_nasi_kotak' => $totalPaketNasiKotak,
            'total_paket_prasmanan' => $totalPaketPrasmanan,
            'total_satuan' => $totalSatuan,
            'total_reviews' => $totalReviews,
            'total_users' => $totalUsers,
        ]);
    }
}
