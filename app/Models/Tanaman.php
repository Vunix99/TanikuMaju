<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Tanaman extends Model
{
    use HasFactory;

    protected $table = 'tanaman';
    protected $primaryKey = 'id_tanaman';

    protected $fillable = [
        'id_lahan',
        'jenis_tanaman',
        'tanggal_tanam',
    ];

    public function lahan(): BelongsTo
    {
        return $this->belongsTo(Lahan::class, 'id_lahan', 'id_lahan');
    }

    public function prediksiPanens(): HasMany
    {
        return $this->hasMany(PrediksiPanen::class, 'id_tanaman', 'id_tanaman');
    }
}
