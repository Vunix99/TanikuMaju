<?php

namespace App\Http\Controllers;

use App\Models\Crop;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception;
use PhpParser\Node\Stmt\TryCatch;

class KalkulasiController extends Controller
{
    public function index()
    {
        $crops = Crop::where('user_id', auth()->id())->get();
        // dd($crops);
        return view('utama.kalkulasi', ['crops' => $crops]);
    }

    public function riwayat()
    {
        $crops = Crop::where('id_petani', auth()->id())->get();

        return response()->json([
            'message' => 'Petani ditemukan',
            'data' => $crops,
            'id' => auth()->id(),
        ], 200);
    }

    public function delete($id)
    {
        Crop::findOrFail($id)->delete();
        return response()->json([
            'messages'=>'data berhasil dihapus'
        ], 200);
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'fieldName' => 'required|string',
            'cropType' => 'required|string',
            'plantDate' => 'required|date',
            'fieldMass' => 'required|numeric',
            'soilMoisture' => 'required|string',
            'soilCondition' => 'required|string',
            'rainfallIntensity' => 'required|string',
        ]);

        // Logika untuk menentukan saran
        $harvestCondition = "Kondisi panen optimal.";

        if ($validatedData['soilCondition'] === "Tidak Subur" && $validatedData['soilMoisture'] === "Kering" && $validatedData['rainfallIntensity'] === "Rendah") {
            $harvestCondition = "Kondisi panen kurang baik. Disarankan perbaikan irigasi, penggunaan pupuk organik, dan penerapan metode konservasi air.";
        } elseif ($validatedData['soilCondition'] === "Tidak Subur" && $validatedData['soilMoisture'] === "Kering" && $validatedData['rainfallIntensity'] === "Sedang") {
            $harvestCondition = "Tanah tidak subur dan kelembapan rendah meskipun curah hujan sedang. Perlu dilakukan pengolahan tanah dan pemberian pupuk.";
        } elseif ($validatedData['soilCondition'] === "Tidak Subur" && $validatedData['rainfallIntensity'] === "Tinggi") {
            $harvestCondition = "Tanah tidak subur dengan curah hujan tinggi dapat menyebabkan erosi dan hasil panen berkurang. Tingkatkan pemupukan dan gunakan penahan erosi.";
        } elseif ($validatedData['soilCondition'] === "Tidak Subur" && $validatedData['soilMoisture'] === "Normal" && $validatedData['rainfallIntensity'] === "Rendah") {
            $harvestCondition = "Tanah tidak subur dengan kelembapan normal tetapi curah hujan rendah. Disarankan penggunaan pupuk organik untuk meningkatkan kesuburan tanah, serta irigasi tambahan untuk memastikan tanaman mendapatkan cukup air.";
        } elseif ($validatedData['soilCondition'] === "Subur" && $validatedData['soilMoisture'] === "Kering" && $validatedData['rainfallIntensity'] === "Rendah") {
            $harvestCondition = "Tanah subur tetapi kekeringan dapat mengurangi hasil panen. Tambahkan irigasi untuk meningkatkan produktivitas.";
        } elseif ($validatedData['soilCondition'] === "Subur" && $validatedData['soilMoisture'] === "Normal" && $validatedData['rainfallIntensity'] === "Sedang") {
            $harvestCondition = "Kondisi ideal untuk pertumbuhan tanaman. Lanjutkan pemantauan rutin.";
        } elseif ($validatedData['soilCondition'] === "Subur" && $validatedData['soilMoisture'] === "Basah" && $validatedData['rainfallIntensity'] === "Tinggi") {
            $harvestCondition = "Tanah subur dengan kelembapan tinggi dan curah hujan tinggi. Waspadai risiko genangan air dan banjir.";
        } elseif ($validatedData['soilCondition'] === "Sangat Subur" && $validatedData['soilMoisture'] === "Kering" && $validatedData['rainfallIntensity'] === "Rendah") {
            $harvestCondition = "Tanah sangat subur tetapi kelembapan rendah. Tambahkan irigasi untuk memanfaatkan potensi hasil maksimal.";
        } elseif ($validatedData['soilCondition'] === "Sangat Subur" && $validatedData['soilMoisture'] === "Normal" && $validatedData['rainfallIntensity'] === "Sedang") {
            $harvestCondition = "Kondisi panen sangat baik. Potensi hasil maksimal. Pastikan pengendalian hama dilakukan.";
        } elseif ($validatedData['soilCondition'] === "Sangat Subur" && $validatedData['soilMoisture'] === "Basah" && $validatedData['rainfallIntensity'] === "Tinggi") {
            $harvestCondition = "Tanah sangat subur dengan curah hujan tinggi. Perhatikan risiko kerusakan akibat genangan air.";
        } elseif ($validatedData['soilMoisture'] === "Basah" && $validatedData['rainfallIntensity'] === "Tinggi") {
            $harvestCondition = "Kondisi lembap dan curah hujan tinggi. Perhatikan risiko banjir yang dapat merusak tanaman.";
        } elseif ($validatedData['soilMoisture'] === "Kering" && $validatedData['rainfallIntensity'] === "Rendah") {
            $harvestCondition = "Kelembapan tanah rendah dan curah hujan rendah. Tingkatkan irigasi untuk menjaga pertumbuhan tanaman.";
        } elseif ($validatedData['soilMoisture'] === "Kering" && $validatedData['rainfallIntensity'] === "Sedang") {
            $harvestCondition = "Kelembapan tanah rendah meskipun curah hujan sedang. Perlu irigasi tambahan.";
        } elseif ($validatedData['soilMoisture'] === "Normal" && $validatedData['rainfallIntensity'] === "Tinggi") {
            $harvestCondition = "Kelembapan tanah normal tetapi curah hujan tinggi. Pastikan drainase berfungsi untuk mencegah genangan.";
        } elseif ($validatedData['soilCondition'] === "Tidak Subur" && $validatedData['soilMoisture'] === "Basah") {
            $harvestCondition = "Tanah tidak subur dan kelembapan tinggi. Perlu peningkatan kualitas tanah melalui pengapuran atau pupuk.";
        } elseif ($validatedData['soilCondition'] === "Sangat Subur" && $validatedData['soilMoisture'] === "Kering") {
            $harvestCondition = "Tanah sangat subur tetapi kelembapan rendah. Irigasi diperlukan untuk mendukung pertumbuhan optimal.";
        } elseif ($validatedData['soilCondition'] === "Tidak Subur" && $validatedData['soilMoisture'] === "Normal" && $validatedData['rainfallIntensity'] === "Sedang") {
            $harvestCondition = "Tanah tidak subur dengan kelembapan normal dan curah hujan sedang. Disarankan untuk meningkatkan kesuburan tanah dengan pupuk organik atau anorganik untuk mendukung pertumbuhan tanaman yang optimal.";
        } else {
            $harvestCondition = "Kondisi pertanian tidak sesuai dengan skenario yang direncanakan. Lakukan pemeriksaan dan penyesuaian.";
        }

        // Hitung prediksi tanggal panen
        $baseDuration = $validatedData['cropType'] === 'Padi' ? 120 : 90;
        $soilFactor = $validatedData['soilMoisture'] === 'Kering' ? 1.2 : ($validatedData['soilMoisture'] === 'Basah' ? 0.8 : 1);
        $rainfallFactor = $validatedData['rainfallIntensity'] === 'Rendah' ? 1.1 : ($validatedData['rainfallIntensity'] === 'Tinggi' ? 0.9 : 1);
        $totalDuration = $baseDuration * $soilFactor * $rainfallFactor;

        $harvestDate = Carbon::parse($validatedData['plantDate'])->addDays($totalDuration);

        try {
            $crop = Crop::create([
                'id_petani' => auth()->id(),
                'field_name' => $validatedData['fieldName'],
                'crop_type' => $validatedData['cropType'],
                'plant_date' => $validatedData['plantDate'],
                'field_mass' => $validatedData['fieldMass'],
                'soil_moisture' => $validatedData['soilMoisture'],
                'soil_condition' => $validatedData['soilCondition'],
                'rainfall_intensity' => $validatedData['rainfallIntensity'],
                'harvest_date' => $harvestDate->format('Y-m-d'),
                'suggestion' => $harvestCondition,
            ]);
    
            return response()->json(['success' => true, 'message' => 'Data berhasil disimpan!', 'suggestion' => $harvestCondition]);
        } catch (Exception $error) {
            return response()->json(['success' => false, 'message' => 'Data tidak berhasil disimpan', 'suggestion' => $error, 'id_petani' => auth()->id()]);
        }

        
    }

}