<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Petani;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PetaniController extends Controller
{
    public function update(Request $request): JsonResponse
    {
        // Pastikan menggunakan model Petani untuk mendapatkan user yang sedang login
        $petani = Petani::find(auth()->id()); // Menggunakan Petani berdasarkan ID dari Auth
    
        // Jika petani tidak ditemukan, kembalikan error
        if (!$petani) {
            return response()->json([
                'message' => 'Petani tidak ditemukan',
            ], 404);
        }
    
        // Validasi data yang diterima dalam request body
        $validatedData = $request->validate([
            'nama_petani' => 'nullable|string|max:255', // Nama petani optional
            'nomor_wa' => 'nullable|string|max:15', // Nomor WA optional
            'password_lama' => 'nullable|string|min:8', // Password lama untuk validasi
            'password_baru' => 'nullable|string|min:8|confirmed', // Password baru dan konfirmasi
            'password_baru_confirmation' => 'nullable|string|min:8', // Validasi konfirmasi password baru
            'foto_profil' => 'nullable|string', // Foto profil optional
        ]);
    
        // Perbarui hanya jika atribut yang diinputkan dalam request ada
        if (isset($validatedData['nama_petani'])) {
            $petani->nama_petani = $validatedData['nama_petani'];
        }
    
        if (isset($validatedData['nomor_wa'])) {
            $petani->nomor_wa = $validatedData['nomor_wa'];
        }
    
        // Proses perubahan password
        if (isset($validatedData['password_lama']) && isset($validatedData['password_baru'])) {
            // Cek apakah password lama yang dimasukkan sesuai dengan yang ada di database
            if (!Hash::check($validatedData['password_lama'], $petani->password)) {
                return response()->json([
                    'message' => 'Password saat ini salah',
                ], 400); // Jika password lama tidak sesuai
            }
    
            // Cek apakah password baru sudah dikonfirmasi
            if (isset($validatedData['password_baru_confirmation']) && 
                $validatedData['password_baru'] !== $validatedData['password_baru_confirmation']) {
                return response()->json([
                    'message' => 'Konfirmasi password baru tidak cocok',
                ], 400); // Jika password baru dan konfirmasi tidak cocok
            }
    
            // Update password jika validasi sukses
            $petani->password = Hash::make($validatedData['password_baru']);
        }
    
        // Jika ada foto profil baru, proses dan simpan
        if (isset($validatedData['foto_profil'])) {
            // Periksa apakah petani sudah memiliki foto profil sebelumnya dan bukan foto default
            if ($petani->foto_profil && $petani->foto_profil !== 'default.png') {
                // Hapus foto profil yang lama jika ada
                Storage::disk('public')->delete($petani->foto_profil);
            }
    
            // Dekode gambar dari base64
            $imageData = base64_decode($validatedData['foto_profil']);
            // Berikan nama file unik untuk foto profil
            $nama_file = 'foto-profil-' . Str::kebab($petani->nama_petani) . '-' . uniqid();
            // Tentukan path tempat penyimpanan file
            $path = 'petani_profiles/' . "{$nama_file}.png"; // Lokasi penyimpanan file
    
            // Simpan foto ke storage public
            Storage::disk('public')->put($path, $imageData);
    
            // Update foto profil petani
            $petani->foto_profil = $path;
        }
    
        // Simpan perubahan ke database
        if ($petani->save()) {
            return response()->json([
                'message' => 'Profil petani berhasil diperbarui',
                'data' => $petani, // Menampilkan data petani yang telah diperbarui
            ]);
        }
    
        return response()->json([
            'message' => 'Gagal memperbarui profil petani',
        ], 500);
    }
    
    
    
    
    public function checkIfSenderIsCurrentUser($id_petani): JsonResponse
    {
        // Ambil petani yang sedang login menggunakan auth()
        $currentUserId = auth()->id();
    
        // Cek apakah id_petani yang diterima dari request sama dengan id petani yang sedang login
        if ($id_petani == $currentUserId) {
            return response()->json(true); // Pengirim adalah pengguna yang sedang login
        } else {
            return response()->json(false); // Pengirim bukan pengguna yang sedang login
        }
    }
    
    


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

    public function getNamaFotoById($id_petani): JsonResponse
    {
        // Cari petani berdasarkan id_petani
        $petani = Petani::find($id_petani);
    
        // Jika petani tidak ditemukan
        if (!$petani) {
            return response()->json([
                'message' => 'Petani tidak ditemukan',
            ], 404);
        }
    
        // Tentukan path foto profil
        $fotoProfil = $petani->foto_profil;
    
        // Cek jika foto_profil adalah data default
        if ($fotoProfil && $fotoProfil === 'images/profile.png') {
            $fotoProfil = '/images/profile.png'; // Ganti dengan path default
        } elseif ($fotoProfil) {
            $fotoProfil = '/storage/' . $fotoProfil; // Ganti dengan path relatif untuk gambar selain default
        } else {
            $fotoProfil = null; // Jika tidak ada foto
        }
    
        // Kirimkan nama dan foto profil petani
        return response()->json([
            'message' => 'Petani ditemukan',
            'data' => [
                'nama_petani' => $petani->nama_petani,
                'foto_profil' => $fotoProfil,
            ],
        ], 200);
    }
    
    
    
}
