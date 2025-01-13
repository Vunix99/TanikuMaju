<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    private function asset_storage(string $path) : string
    {
        return asset(Storage::url($path));
    }

    public function all() : JsonResponse
    {
        $partners = DB::table('partners')
            ->select('nama', 'logo')
            ->get()
            ->map(function ($partner) {
                $partner->logo = $this->asset_storage($partner->logo);
                return $partner;
            });

        return response()->json($partners);
    }

    public function index() : JsonResponse
    {
        $partners = Partner::all()
            ->map(function (Partner $partner) {
                $partner->logo = $this->asset_storage($partner->logo);
            });

        return response()->json($partners);
    }

    public function show(Partner $partner) : JsonResponse
    {
        $partner->logo = $this->asset_storage($partner->logo);
        return response()->json($partner);
    }

    public function store(Request $request) : JsonResponse
    {
        $validated = $request->validate([
            'logo' => [
                'required',
                'mimes:jpg,jpeg,png',
                'extensions:jpg,jpeg,png'
            ],
            'nama' => ['required'],
        ]);

        $nama = $validated['nama'];

        // Ganti spasi dengan garis bawah pada nama partner
        $nama = str_replace(' ', '_', $nama);

        $file = $request->file('logo');

        if (! $file->isValid()) {
            return response()->json([
                'message' => 'File gagal terupload.'
            ], 400);
        }

        $ext = $file->extension();
        $path = $file->storeAs('partners', "$nama.$ext", 'public');

        $partner = new Partner();
        $partner->nama = $nama;
        $partner->logo = $path;

        if (! $partner->save()) {
            return response()->json([
                'message' => "Partner $nama gagal tersimpan.",
            ], 500);
        }

        return response()->json([
            'message' => "Partner $nama tersimpan.",
        ]);
    }

    public function update(Request $request, Partner $partner) : JsonResponse
    {
        $valid = $request->validate([
            'logo' => [
                'nullable',
                'mimes:jpg,jpeg,png',
                'extensions:jpg,jpeg,png'
            ],
            'nama' => [
                'nullable',
            ],
        ]);

        $nama = $partner->nama;

        if (! empty($valid['nama'])) {
            $nama = $valid['nama'];

            // Ganti spasi dengan garis bawah pada nama partner
            $nama = str_replace(' ', '_', $nama);

            $partner->nama = $nama;
        }

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');

            if (! $file->isValid()) {
                return response()->json([
                    'message' => 'File gagal terupload.'
                ], 400);
            }

            $ext = $file->extension();
            $path = $file->storeAs('partners', "$nama.$ext", 'public');

            $partner->logo = $path;
        }

        $partner->save();

        return response()->json([
            'message' => "Partner $partner->nama berhasil diubah",
        ]);
    }

    public function destroy(Partner $partner) : JsonResponse
    {
        $nama = $partner->nama;

        if (! $partner->delete()) {
            return response()->json([
                'message' => "Partner $nama gagal terhapus.",
            ]);
        }

        return response()->json([
            'message' => "Partner $nama berhasil terhapus.",
        ]);
    }
}
