<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens; // Ensure this trait is included for API tokens

class Crop extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'id_petani',
        'field_name',
        'crop_type',
        'plant_date',
        'field_mass',
        'soil_moisture',
        'soil_condition',
        'rainfall_intensity',
        'harvest_date',
        'suggestion',
    ];
    public function petani()
    {
        return $this->belongsTo(Petani::class, 'id_petani', 'id_petani');
    }



}