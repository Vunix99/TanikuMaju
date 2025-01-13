<?php

namespace App\Http\Controllers;

use App\Enums\KategoriPaket;
use App\Models\Paket;
use App\Models\Satuan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt; // Make sure to import Crypt

class PaketController extends Controller
{
    private $customIds = []; // To store generated IDs by category

    private function asset_storage(string $path): string
    {
        return asset(Storage::url($path));
    }

    private function generateCustomId(string $kategori): void
    {
        $products = Paket::where('kategori', $kategori)->orderBy('id', 'asc')->get();
        $prefix = ucfirst(strtolower($kategori));

        foreach ($products as $index => $product) {
            $alphabetChar = chr(65 + $index);
            $customId = $prefix . $alphabetChar;
            $this->customIds[$product->id] = $customId;
        }
    }

    private function formatPaketResponse(Paket $paket): array
    {
        if (!isset($this->customIds[$paket->id])) {
            $this->generateCustomId($paket->kategori);
        }

        return [
            'id' => $this->customIds[$paket->id] ?? null,
            'id_origin' => Crypt::encrypt($paket->id),  // Encrypt the id_origin
            'nama' => $paket->nama,
            'deskripsi' => $paket->deskripsi,
            'foto' => $this->asset_storage($paket->foto),
            'harga' => $paket->harga,
            'kategori' => $paket->kategori,
            'items' => $paket->items->map(function ($item) {
                return [
                    'id_satuan' => $item->id,
                    'nama' => $item->nama,
                    'quantity' => $item->pivot->quantity,
                ];
            })
        ];
    }

    public function getById($paket): JsonResponse
    {
        try {
            // Decrypt the provided encrypted ID
            $decryptedId = Crypt::decrypt($paket);

            // Fetch the Paket by the decrypted ID
            $paket = Paket::findOrFail($decryptedId);

            // Load related items
            $paket->load('items');  // Pastikan relasi 'items' sudah ada dalam model Paket

            // Return the formatted response along with the decrypted ID
            return response()->json([
                'decrypted_id' => $decryptedId, // Add decrypted ID to the response for debugging
                'data' => $this->formatPaketResponse($paket)
            ]);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            // Handle the case when decryption fails (invalid or expired ID)
            return response()->json([
                'message' => 'ID is invalid or has expired',
                'error' => $e->getMessage()
            ], 400);
        } catch (\Exception $e) {
            // Handle the case when the Paket is not found or other exceptions
            return response()->json([
                'message' => 'Paket not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }




    public function all(): JsonResponse
    {
        $pakets = Paket::with('items')->get()->map(function (Paket $paket) {
            return $this->formatPaketResponse($paket);
        });

        return response()->json($pakets);
    }

    public function index(): JsonResponse
    {
        return $this->all();
    }

    public function show(Paket $paket): JsonResponse
    {
        $paket->load('items');
        return response()->json($this->formatPaketResponse($paket));
    }

    public function getNasiKotakLimited(): JsonResponse
    {
        // Fetch only 4 Paket items with category 'nasi_kotak'
        $pakets = Paket::where('kategori', 'nasi_kotak')
            ->limit(4)
            ->with('items') // Load related items
            ->get()
            ->map(function (Paket $paket) {
                return $this->formatPaketResponse($paket);
            });

        return response()->json([
            'message' => 'Successfully retrieved 4 nasi_kotak items',
            'data' => $pakets,
        ]);
    }

    public function getByCategory(string $kategori): JsonResponse
{
    $pakets = Paket::with('items')
        ->where('kategori', $kategori)
        ->get()
        ->map(function (Paket $paket) {
            return $this->formatPaketResponse($paket);
        });

    return response()->json($pakets);
}



    public function items(Paket $paket): JsonResponse
    {
        $items = $paket->items->map(function ($item) {
            return [
                'id_satuan' => $item->id,
                'nama' => $item->nama,
                'quantity' => $item->pivot->quantity,
            ];
        });
        return response()->json($items);
    }

    public function store(Request $request): JsonResponse
    {
        // Decode the raw JSON body from the request
        $valid = $request->json()->all();

        // Validate incoming request
        $validatedData = validator($valid, [
            'nama' => ['required'],
            'harga' => ['required', 'integer'],
            'kategori' => ['required', Rule::enum(KategoriPaket::class)],
            'deskripsi' => ['nullable', 'string'],
            'items' => ['nullable'],
            'foto' => ['required', 'string'],  // Foto should be a base64 encoded string
        ])->validate();

        $paket = new Paket($validatedData);

        // Handle base64 foto decoding
        if (isset($validatedData['foto'])) {
            $imageData = base64_decode($validatedData['foto']);
            $nama_file = Str::kebab($validatedData['nama']) . '-' . uniqid();
            $path = 'nasikotak/' . "{$nama_file}.png";

            // Save the decoded image to storage
            Storage::disk('public')->put($path, $imageData);
            $paket->foto = $path;
        } else {
            return response()->json(['message' => 'File foto tidak ditemukan dalam request'], 400);
        }

        // Save the Paket to the database
        if ($paket->save()) {
            // Handle the item associations if present
            $items = $validatedData['items'] ?? [];
            if (is_string($items)) {
                $items = explode(',', $items);
            }

            if (!empty($items)) {
                $pivotData = [];
                foreach ($items as $itemId) {
                    $pivotData[$itemId] = [
                        'nama' => 'Default Name',
                        'quantity' => 1
                    ];
                }
                $paket->items()->sync($pivotData);
            }

            // Return response
            $paket->load('items');
            return response()->json([
                'message' => "Paket {$paket->nama} berhasil disimpan",
                'data' => $this->formatPaketResponse($paket),
            ]);
        }

        return response()->json(['message' => "Paket {$validatedData['nama']} gagal tersimpan"], 500);
    }


    public function update(Request $request, $paket): JsonResponse
    {
        try {
            $decryptedId = Crypt::decrypt($paket);
            $paket = Paket::findOrFail($decryptedId);

            $validatedData = $request->validate([
                'nama' => ['nullable', 'string'],
                'harga' => ['nullable', 'integer'],
                'deskripsi' => ['nullable', 'string'],
                'items' => ['nullable', 'string'],
            ]);

            $paket->fill($validatedData);

            if ($request->has('foto') && !empty($request->input('foto'))) {
                $imageData = base64_decode($request->input('foto'));
                $nama_file = Str::kebab($paket->nama) . '-' . uniqid();
                $path = 'nasikotak/' . "{$nama_file}.png";

                Storage::disk('public')->put($path, $imageData);
                if ($paket->foto && Storage::disk('public')->exists($paket->foto)) {
                    Storage::disk('public')->delete($paket->foto);
                }
                $paket->foto = $path;
            }

            if (isset($validatedData['items'])) {
                $items = explode(',', $validatedData['items']);
                $pivotData = [];
                foreach ($items as $itemId) {
                    $pivotData[$itemId] = [
                        'quantity' => 1,
                        'nama' => 'Default Name',
                    ];
                }
                $paket->items()->sync($pivotData);
            }

            $paket->save();
            $paket->load('items');

            return response()->json([
                'message' => "Paket {$paket->nama} berhasil diubah",
                'data' => $this->formatPaketResponse($paket),
            ]);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return response()->json([
                'message' => 'ID tidak valid atau telah kedaluwarsa.',
                'error' => $e->getMessage()
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error saat memperbarui Paket',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    public function destroy($encryptedId): JsonResponse
    {
        try {
            // Dekripsi ID terenkripsi yang diterima dari URL
            $decryptedId = Crypt::decrypt($encryptedId);

            // Cari paket berdasarkan ID yang telah didekripsi
            $paket = Paket::findOrFail($decryptedId);

            // Hapus relasi dengan items terlebih dahulu (pivot table jika ada)
            $paket->items()->detach();

            // Hapus file foto dari penyimpanan
            if ($paket->foto && Storage::disk('public')->exists($paket->foto)) {
                Storage::disk('public')->delete($paket->foto);
            }

            // Hapus paket dari database
            $paket->delete();

            return response()->json([
                'message' => "Paket {$paket->nama} berhasil dihapus",
            ], 200);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return response()->json([
                'message' => 'ID tidak valid atau telah kedaluwarsa.',
                'error' => $e->getMessage()
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Paket gagal dihapus",
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
