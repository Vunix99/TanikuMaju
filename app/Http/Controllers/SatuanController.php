<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SatuanController extends Controller
{
    public function all() : JsonResponse
    {
        $satuans = DB::table('satuan')
            ->select('id', 'nama')
            ->get();
        return response()->json($satuans);
    }

    public function index() : JsonResponse
    {
        $satuans = Satuan::all();
        return response()->json($satuans);
    }

    public function show(Satuan $satuan) : JsonResponse
    {
        return response()->json($satuan);
    }
    
    public function getById(int $id) : JsonResponse
{
    // Find the Satuan by ID
    $satuan = Satuan::find($id);

    // Check if Satuan was found
    if (!$satuan) {
        return response()->json([
            'message' => "Satuan with ID $id not found.",
        ], 404); // HTTP 404 Not Found
    }

    // Return the found Satuan
    return response()->json($satuan);
}


    public function store(Request $request) : JsonResponse
    {
        // Validasi data masuk
        $request->validate([
            'items' => 'required|array', // Pastikan 'items' adalah array (baik itu berisi satu atau lebih item)
            'items.*.nama' => 'required|string', // Validasi untuk setiap item dalam 'items' agar memiliki nama
        ]);
        
        // Ubah data tunggal menjadi array jika hanya satu objek dikirim
        $items = is_array($request->input('items')) ? $request->input('items') : [$request->input('items')];
        
        // Menampung data yang akan disimpan dan nama item yang duplikat
        $dataToSave = [];
        $duplicates = [];
        $singleItemExists = false;
    
        // Periksa setiap item
        foreach ($items as $item) {
            // Cek apakah nama sudah ada (case-insensitive)
            $existingItem = Satuan::whereRaw('LOWER(nama) = ?', [strtolower($item['nama'])])->first();
    
            if ($existingItem) {
                // Jika data sudah ada, tambahkan ke array duplikat
                $duplicates[] = $item['nama'];
                if (count($items) === 1) {
                    $singleItemExists = true; // Tandai jika input hanya satu item yang sudah ada
                }
            } else {
                // Jika tidak ada, siapkan data untuk disimpan
                $dataToSave[] = ['nama' => $item['nama']];
            }
        }
    
        // Simpan data baru yang belum ada di database
        if (count($dataToSave) > 0) {
            Satuan::insert($dataToSave); // Menggunakan insert untuk batch insert
        }
    
        // Mengembalikan respons yang berbeda berdasarkan kondisi
        if ($singleItemExists) {
            return response()->json([
                'message' => 'Item sudah ada dan tidak disimpan.',
                'duplicate_items' => $duplicates,
            ], 409); // HTTP 409 Conflict
        } elseif (count($dataToSave) > 0 && count($duplicates) > 0) {
            return response()->json([
                'message' => 'Beberapa item berhasil disimpan, tetapi beberapa item sudah ada.',
                'saved_items' => array_column($dataToSave, 'nama'),
                'duplicate_items' => $duplicates,
            ], 207); // HTTP 207 Multi-Status
        } elseif (count($dataToSave) > 0) {
            return response()->json([
                'message' => 'Semua item berhasil disimpan.',
                'saved_items' => array_column($dataToSave, 'nama'),
            ]);
        } else {
            return response()->json([
                'message' => 'Semua item sudah ada di database.',
                'duplicate_items' => $duplicates,
            ], 409); // HTTP 409 Conflict
        }
    }
    
    

    public function update(Request $request, Satuan $satuan) : JsonResponse
    {
        $old = $satuan->nama;

        $satuan->nama = $request->nama;

        if (! $satuan->save()) {
            return response()->json([
                'message' => "Gagal mengubah $old",
            ], 500);
        }

        return response()->json([
            'message' => "Berhasil mengubah '$old' menjadi '$satuan->nama'",
        ]);
    }

    public function destroy(Satuan $satuan) : JsonResponse
    {
        if (! $satuan->delete()) {
            return response()->json([
                'message' => "Gagal menghapus $satuan->nama",
            ], 500);
        }

        return response()->json([
            'message' => "Berhasil menghapus $satuan->nama",
        ]);
    }
}
