<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    use HasFactory;

    protected $table = 'artikel'; // Nama tabel di database
    protected $fillable = ['judul', 'gambar', 'tanggal', 'isi'];
}
