<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class PrediksiPanen extends Model
{
    use HasFactory;

    protected $table = 'prediksi_panen';
    protected $primaryKey = 'id_prediksi';

    protected $fillable = [
        'id_tanaman',
        'prediksi_hasil_panen',
        'tanggal_prediksi',
    ];

    public function tanaman(): BelongsTo
    {
        return $this->belongsTo(Tanaman::class, 'id_tanaman', 'id_tanaman');
    }
}
