<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;



class Lahan extends Model
{
    use HasFactory;

    protected $table = 'lahan';
    protected $primaryKey = 'id_lahan';

    protected $fillable = [
        'id_petani',
        'luas_lahan',
        'jenis_tanah',
        'kadar_air_tanah',
        'ph_tanah',
    ];

    public function petani(): BelongsTo
    {
        return $this->belongsTo(Petani::class, 'id_petani', 'id_petani');
    }

    public function tanamans(): HasMany
    {
        return $this->hasMany(Tanaman::class, 'id_lahan', 'id_lahan');
    }
}