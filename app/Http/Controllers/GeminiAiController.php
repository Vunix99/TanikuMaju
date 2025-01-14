<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GeminiAiController extends Controller
{
    public function generateContent(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'text' => 'required|string',
        ]);

        // Ambil konfigurasi
        $apiUrl = config('services.gemini.url');
        $apiKey = config('services.gemini.key');

        // Tambahkan API key ke URL
        $apiUrlWithKey = "{$apiUrl}?key={$apiKey}";

        // Kirim permintaan ke API Gemini
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($apiUrlWithKey, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $validatedData['text']]
                        ]
                    ]
                ]
            ]);

            // Pastikan respons sukses
            if ($response->successful()) {
                return response()->json([
                    'status' => 'success',
                    'data' => $response->json(),
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to connect to Gemini AI',
                    'details' => $response->json(),
                ], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while communicating with Gemini AI.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }
}
