<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\Petani;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    /**
     * Mendapatkan data petani berdasarkan ID.
     */
    public function getPetaniById(Request $request): JsonResponse
    {
        // Ambil petani yang sedang login menggunakan auth()
        $petani = Petani::find(auth()->id());

        // Jika petani tidak ditemukan
        if (!$petani) {
            return response()->json([
                'message' => 'Petani tidak ditemukan'
            ], 404);
        }

        // Sembunyikan kolom password
        $petani->makeHidden(['password']);

        // Kirimkan data petani tanpa password
        return response()->json([
            'message' => 'Petani ditemukan',
            'data' => $petani
        ], 200);
    }

    /**
     * Menambahkan chat baru.
     */


    public function store(Request $request): JsonResponse
    {
        // Pastikan pengguna sudah terautentikasi
        if (!auth()->check()) {
            return response()->json([
                'message' => 'User not authenticated.',
            ], 401); // Mengembalikan 401 Unauthorized jika pengguna belum login
        }

        // Validasi input dari pengguna
        $request->validate([
            'id_diskusi' => 'required|integer', // Validasi id_diskusi untuk memastikan ada di tabel diskusi
            'foto' => 'nullable|string', // Foto adalah opsional, harus berupa string base64
            'isi_komentar' => 'nullable|string|max:1000', // Isi komentar adalah opsional, max 1000 karakter
        ]);

        // Custom validation to ensure either 'foto' or 'isi_komentar' is provided, but not both
        if (!$request->has('foto') && !$request->has('isi_komentar')) {
            return response()->json([
                'message' => 'Salah satu dari foto atau isi komentar harus ada.',
            ], 400); // Return error if neither foto nor isi_komentar is provided
        }

        if ($request->has('foto') && $request->has('isi_komentar')) {
            return response()->json([
                'message' => 'Hanya satu dari foto atau isi komentar yang diperbolehkan.',
            ], 400); // Return error if both foto and isi_komentar are provided
        }

        // Mendapatkan data petani terlebih dahulu sebelum menyimpan chat
        $petaniResponse = $this->getPetaniById($request);

        // Jika petani tidak ditemukan, kembalikan response error
        if ($petaniResponse->getStatusCode() !== 200) {
            return $petaniResponse; // Mengembalikan response error dari getPetaniById
        }

        // Mengambil petani dari response dan memastikan data tersedia
        $petani = $petaniResponse->getData()->data ?? null;

        // Jika petani tidak ditemukan dalam response
        if (!$petani) {
            return response()->json([
                'message' => 'Petani tidak ditemukan',
            ], 404);
        }

        // Mendapatkan id_petani dari data petani
        $idPetani = $petani->id_petani ?? null; // Menggunakan id_petani sesuai format response

        // Periksa apakah id_petani sudah benar dan tidak null
        if (!$idPetani) {
            return response()->json([
                'message' => 'ID Petani tidak valid.',
            ], 400); // Mengembalikan 400 Bad Request jika id_petani tidak ada
        }

        // Menyusun data komentar
        $validatedData = $request->only(['id_diskusi']);
        $validatedData['tanggal_komentar'] = now();
        $validatedData['id_petani'] = $idPetani; // Gunakan id_petani yang valid

        // Proses foto jika ada
        if ($request->has('foto')) {
            try {
                $imageData = base64_decode($request->foto);
                $nama_file = uniqid('komentar_') . '.png'; // Menghasilkan nama file unik
                $path = 'komentar/' . $nama_file;

                // Simpan gambar ke storage
                Storage::disk('public')->put($path, $imageData);
                $validatedData['foto'] = $path; // Simpan path foto ke validatedData
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Gagal memproses foto.',
                    'error' => $e->getMessage(),
                ], 400);
            }
        }

        // Proses komentar teks jika ada
        if ($request->has('isi_komentar') && $request->isi_komentar) {
            $validatedData['isi_komentar'] = $request->isi_komentar;
        }

        // Simpan data ke tabel chats
        try {
            $chat = Chat::create($validatedData);

            return response()->json([
                'message' => 'Komentar berhasil ditambahkan',
                'data' => $chat,
            ], 201); // Mengembalikan response dengan status 201 Created
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menyimpan komentar',
                'error' => $e->getMessage(),
                'id_petani' => $idPetani, // Menambahkan id_petani yang digunakan dalam response error
            ], 500); // Mengembalikan error 500 jika terjadi kesalahan
        }
    }




    public function checkIfSenderIsCurrentUser($id_petani): bool
    {
        // Ambil petani yang sedang login menggunakan auth()
        $currentUserId = auth()->id();

        // Cek apakah id_petani yang diterima dari request sama dengan id petani yang sedang login
        return $id_petani == $currentUserId;
    }


    /**
     * Mengambil chat berdasarkan id_diskusi.
     */
    public function getByDiskusi($id_diskusi, Request $request): JsonResponse
    {
        // Ambil parameter 'limit' dan 'page' dari body JSON, atau gunakan nilai default jika tidak ada
        $limit = $request->input('limit', null); // Default null jika tidak ada
        $page = $request->input('page', 1);      // Default page is 1

        // Jika limit tidak ada, tampilkan semua chat
        if (is_null($limit)) {
            $chats = Chat::where('id_diskusi', $id_diskusi)
                ->orderBy('tanggal_komentar', 'asc') // Urutkan berdasarkan tanggal komentar terbaru
                ->get(); // Ambil semua chat
        } else {
            // Jika limit ada, terapkan pagination
            $chats = Chat::where('id_diskusi', $id_diskusi)
                ->orderBy('tanggal_komentar', 'asc') // Urutkan berdasarkan tanggal komentar terbaru
                ->paginate($limit, ['*'], 'page', $page); // Paginate with custom page number
        }

        // Jika tidak ada chat ditemukan
        if ($chats->isEmpty()) {
            return response()->json([
                'message' => 'Tidak ada komentar ditemukan untuk diskusi ini',
                'kosong' => true, // Tambahkan key 'kosong' dengan nilai true
            ], 200);
        }

        // Ambil foto profil, nama petani, dan tambahkan isMe pada setiap chat
        $chats = $chats->map(function ($chat) {
            // Ambil data petani berdasarkan id_petani
            $petani = Petani::find($chat->id_petani);

            // Periksa apakah pengirim adalah pengguna yang sedang login
            $chat->isMe = $this->checkIfSenderIsCurrentUser($chat->id_petani);

            // Tambahkan foto_profil
            if ($petani && $petani->foto_profil) {
                $fotoProfil = $petani->foto_profil;

                // Cek jika foto_profil adalah data default
                if ($fotoProfil === 'images/profile.png') {
                    $fotoProfil = '/images/profile.png'; // Ganti dengan path default
                } elseif ($fotoProfil) {
                    $fotoProfil = '/storage/' . $fotoProfil; // Ganti dengan path relatif untuk gambar selain default
                }
                $chat->foto_profil = $fotoProfil;
            } else {
                $chat->foto_profil = null; // Jika tidak ada foto_profil
            }

            // Tambahkan nama_petani
            $chat->nama_petani = $petani ? $petani->nama_petani : null;

            // Menyimpan data tambahan yang dibutuhkan
            return [
                'id' => $chat->id,
                'id_petani' => $chat->id_petani,
                'id_diskusi' => $chat->id_diskusi,
                'tanggal_komentar' => $chat->tanggal_komentar,
                'isi_komentar' => $chat->isi_komentar,  // Ambil isi_komentar dari tabel Chat
                'foto' => $chat->foto, // Menambahkan foto dari tabel Chat
                'isMe' => $chat->isMe,  // Menyimpan hanya nilai boolean isMe
                'foto_profil' => $chat->foto_profil, // Menyimpan foto profil dari Petani
                'nama_petani' => $chat->nama_petani, // Menambahkan nama_petani dari Petani
                'created_at' => $chat->created_at,  // Menambahkan created_at
                'updated_at' => $chat->updated_at,  // Menambahkan updated_at
            ];
        });

        return response()->json([
            'message' => 'Komentar ditemukan',
            'data' => $chats instanceof \Illuminate\Pagination\LengthAwarePaginator ? $chats->items() : $chats, // Jika pakai pagination, ambil data chat saja
            'kosong' => false, // Tambahkan key 'kosong' dengan nilai false
        ], 200);
    }
}
