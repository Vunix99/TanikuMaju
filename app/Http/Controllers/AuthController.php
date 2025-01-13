<?php

namespace App\Http\Controllers;

use App\Models\Petani;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Laravel\Sanctum\PersonalAccessToken;


class AuthController extends Controller
{

    // Fungsi Registrasi
    public function register(Request $request): JsonResponse
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_petani' => 'required|string|max:255|unique:petani,nama_petani',
            'nomor_wa' => 'required|string|max:15|unique:petani,nomor_wa',
            'username' => 'required|string|max:255|unique:petani,username', // Menambahkan validasi untuk username
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Menetapkan foto profil default
        $fotoProfilDefault = 'images/profile.png'; // Lokasi foto profil default

        // Buat data petani baru dengan username
        $petani = Petani::create([
            'nama_petani' => $request->nama_petani,
            'nomor_wa' => $request->nomor_wa,
            'username' => $request->username, // Menyimpan username
            'password' => Hash::make($request->password), // Hash password untuk keamanan
            'foto_profil' => $fotoProfilDefault, // Menyimpan foto profil default
        ]);

        // Kirim respons sukses
        return response()->json([
            'message' => 'Registrasi berhasil',
            'data' => $petani,
        ], 201);
    }




// Fungsi Login
public function login(Request $request): JsonResponse
{
    // Validasi input
    $validator = Validator::make($request->all(), [
        'username' => 'required|string|max:255',
        'password' => 'required|string|min:8',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Validasi gagal',
            'errors' => $validator->errors(),
        ], 422);
    }

    // Cek kredensial petani menggunakan username dan password
    $petani = Petani::where('username', $request->username)->first();

    if (!$petani || !Hash::check($request->password, $petani->password)) {
        return response()->json([
            'message' => 'Gagal log in'
        ], 401);
    }

    // Membuat token otentikasi
    $token = $petani->createToken('auth_token', ['*'])->plainTextToken;

    // Menetapkan waktu kedaluwarsa token dalam 1 menit dengan zona waktu Asia/Jakarta
    $expiresAt = Carbon::now('Asia/Jakarta')->addDay(3); // Menggunakan zona waktu Asia/Jakarta

    // Simpan waktu kedaluwarsa secara manual pada tabel token
    $petani->tokens->last()->update([
        'expires_at' => $expiresAt // Menyimpan waktu kedaluwarsa token
    ]);

    // Enkripsi ID petani
    $encryptedPetaniId = Crypt::encryptString($petani->id_petani);

    // Kirimkan token dan ID terenkripsi dalam respons
    return response()->json([
        'message' => 'Login success',
        'access_token' => $token,
        'token_type' => 'Bearer',
        'expires_at' => $expiresAt->toIso8601String(),  // Waktu kedaluwarsa token dalam format ISO 8601
        'petani_id' => $encryptedPetaniId
    ]);
}

    


public function logout(Request $request): JsonResponse
{
    // Hapus semua token milik user
    $request->user()->tokens()->delete();

    // Kembalikan respon dengan key loggedOut: true
    return response()->json([
        'message' => 'Berhasil log out',
        'loggedOut' => true
    ]);
}


    public function checkTokenExpired(Request $request): JsonResponse
    {
        $authHeader = $request->header('Authorization');
    
        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return response()->json([
                'message' => 'Token tidak ditemukan atau tidak valid'
            ], 401);
        }
    
        $tokenString = substr($authHeader, 7);
    
        $token = PersonalAccessToken::findToken($tokenString);
    
        if (!$token) {
            return response()->json([
                'message' => 'Token tidak valid'
            ], 401);
        }
    
        if ($token->isExpired()) {
            $token->delete();
            return response()->json([
                'message' => 'Token telah kadaluwarsa dan berhasil dihapus',
                'valid' => false,
            ], 200);
        }
    
        return response()->json([
            'message' => 'Token masih valid',
            'valid' => true,
        ], 200);
    }
    
        
    
}
