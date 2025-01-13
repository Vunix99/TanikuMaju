<?php
namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    public function semua()
    {
        $artikels = Artikel::all(); // Ambil semua artikel dari database
        return view('utama.artikel.index', compact('artikels')); // Kirim data ke view utama.homepage
    }

    // Fungsi untuk menampilkan detail artikel berdasarkan ID
    public function detail($id)
    {
        $artikel = Artikel::findOrFail($id);
        
        // Ambil artikel terkait, misalnya dengan mengabaikan artikel yang sedang dibuka
        $relatedArticles = Artikel::where('id', '!=', $id)->limit(3)->get();

        return view('utama.artikel.show', compact('artikel', 'relatedArticles'));
    }



    public function index(Request $request)
    {
        // Cek apakah limit dan exclude dikirim melalui JSON (POST body) atau query parameter
        $limit = null;
        $exclude = null;
        
        // Cek jika request menggunakan JSON body (POST)
        if ($request->isJson()) {
            $jsonData = $request->all();
            $limit = $jsonData['limit'] ?? null;
            $exclude = $jsonData['exclude'] ?? null;
        }
        // Cek jika request menggunakan query parameter (GET)
        if ($request->has('limit')) {
            $limit = $request->query('limit');
        }
        if ($request->has('exclude')) {
            $exclude = $request->query('exclude');
        }
        
        // Validasi bahwa limit adalah angka positif
        if ($limit && (!is_numeric($limit) || $limit <= 0)) {
            return response()->json(['message' => 'Limit harus berupa angka positif'], 422);
        }
    
        // Validasi bahwa exclude berisi ID yang valid (array atau string ID)
        if ($exclude && !is_array($exclude) && !is_numeric($exclude)) {
            return response()->json(['message' => 'Exclude harus berupa array atau ID artikel yang valid'], 422);
        }
    
        // Ambil data artikel berdasarkan limit, urutkan berdasarkan tanggal terbaru
        $artikels = Artikel::orderBy('tanggal', 'desc');
        
        // Cek jika ada parameter exclude, dan lakukan pengecualian ID artikel
        if ($exclude) {
            if (is_array($exclude)) {
                $artikels = $artikels->whereNotIn('id', $exclude);
            } else {
                $artikels = $artikels->where('id', '!=', $exclude);
            }
        }
    
        // Jika limit ada, ambil sesuai dengan limit yang diberikan
        if ($limit) {
            $artikels = $artikels->take($limit);
        }
    
        // Ambil data artikel
        $artikels = $artikels->get();
    
        // Menambahkan prefix '/images/artikel/' ke gambar setiap artikel
        foreach ($artikels as $artikel) {
            // Pastikan gambar tidak kosong atau null
            if ($artikel->gambar) {
                $artikel->gambar = '/images/artikel/' . $artikel->gambar;
            }
        }
    
        // Mengembalikan response dengan data artikel
        return response()->json($artikels);
    }
    
    
    

    
    
    


    public function store(Request $request)
    {
        // Ambil input data JSON
        $inputData = $request->input('data', []);
        
        // Pastikan input berupa array
        if (!is_array($inputData) || empty($inputData)) {
            return response()->json([
                'message' => 'Input data tidak valid atau kosong.',
            ], 422);
        }
    
        $response = [];
    
        foreach ($inputData as $key => $data) {
            try {
                // Validasi setiap item dalam array
                $validatedItem = validator($data, [
                    'judul' => 'required|string|max:255',
                    'gambar' => 'required|string',
                    'tanggal' => 'required|date',
                    'isi' => 'required|string',
                ])->validate();
    
                // Cek apakah judul sudah ada di database (tidak case-sensitive)
                $existingArtikel = Artikel::whereRaw('LOWER(judul) = ?', [strtolower($validatedItem['judul'])])->first();
                if ($existingArtikel) {
                    $response[] = [
                        'message' => "Artikel ke-$key gagal dibuat. Judul sudah ada.",
                        'data' => $validatedItem,
                    ];
                    continue; // Lewati proses pembuatan untuk item ini
                }
    
                // Simpan artikel
                $artikel = Artikel::create($validatedItem);
                $response[] = [
                    'message' => "Artikel ke-$key berhasil dibuat",
                    'data' => $artikel,
                ];
            } catch (\Exception $e) {
                // Tangani validasi yang gagal
                $response[] = [
                    'message' => "Artikel ke-$key gagal dibuat",
                    'error' => $e->getMessage(),
                    'data' => $data, // Data input yang menyebabkan error
                ];
            }
        }
    
        return response()->json($response, 201);
    }
    
    
    
    



    public function show($id)
    {
        $artikel = Artikel::find($id);
        if (!$artikel) {
            return response()->json(['message' => 'Artikel tidak ditemukan'], 404);
        }
    
        // Tambahkan prefix pada gambar
        $artikel->gambar = '/images/artikel/' . $artikel->gambar;
    
        return response()->json($artikel);
    }
    

    public function update(Request $request, $id)
    {
        $artikel = Artikel::find($id);
        if (!$artikel) {
            return response()->json(['message' => 'Artikel tidak ditemukan'], 404);
        }

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'gambar' => 'required|string',
            'tanggal' => 'required|date',
            'isi' => 'required|string',
        ]);

        $artikel->update($validated);
        return response()->json(['message' => 'Artikel berhasil diperbarui', 'data' => $artikel]);
    }

    public function destroy($id)
    {
        $artikel = Artikel::find($id);
        if (!$artikel) {
            return response()->json(['message' => 'Artikel tidak ditemukan'], 404);
        }

        $artikel->delete();
        return response()->json(['message' => 'Artikel berhasil dihapus']);
    }
}