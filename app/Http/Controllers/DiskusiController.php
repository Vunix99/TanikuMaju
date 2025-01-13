<?php

namespace App\Http\Controllers;

use App\Models\Diskusi;
use Illuminate\Http\Request;

class DiskusiController extends Controller
{
    // Menampilkan semua diskusi
    public function index()
    {
        $diskusi = Diskusi::all();

        if ($diskusi->isEmpty()) {
            return response()->json(['message' => 'Data masih kosong'], 200);
        }

        return response()->json($diskusi);
    }


    
    // Menyimpan data diskusi baru
    public function store(Request $request)
    {
        $data = $request->all();
    
        // Jika data berupa array (batch insert)
        if (isset($data[0]) && is_array($data[0])) {
            $diskusiData = [];
            foreach ($data as $item) {
                if (!isset($item['topik']) || empty($item['topik'])) {
                    return response()->json(['message' => 'Topik harus diisi'], 400);
                }
                $diskusiData[] = Diskusi::create(['topik' => $item['topik']]);
            }
            return response()->json(['message' => 'Diskusi berhasil disimpan', 'data' => $diskusiData], 201);
        }
    
        // Jika data single
        $request->validate([
            'topik' => 'required|string|max:255',
        ]);
    
        $diskusi = Diskusi::create([
            'topik' => $request->topik,
        ]);
    
        return response()->json($diskusi, 201);
    }
    
    

    // Menampilkan data diskusi tertentu
    public function show($id)
    {
        $diskusi = Diskusi::find($id);

        if (!$diskusi) {
            return response()->json(['message' => 'Diskusi tidak ditemukan'], 404);
        }

        return response()->json($diskusi);
    }

    // Memperbarui data diskusi
    public function update(Request $request, $id)
    {
        $request->validate([
            'topik' => 'required|string|max:255',
        ]);

        $diskusi = Diskusi::find($id);

        if (!$diskusi) {
            return response()->json(['message' => 'Diskusi tidak ditemukan'], 404);
        }

        $diskusi->topik = $request->topik;
        $diskusi->save();

        return response()->json($diskusi);
    }

    // Menghapus diskusi
    public function destroy($id)
    {
        $diskusi = Diskusi::find($id);

        if (!$diskusi) {
            return response()->json(['message' => 'Diskusi tidak ditemukan'], 404);
        }

        $diskusi->delete();

        return response()->json(['message' => 'Diskusi berhasil dihapus']);
    }
}
