<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = ['id_petani', 'id_diskusi', 'tanggal_komentar', 'foto', 'isi_komentar'];

    // Relasi dengan model Petani (menentukan kolom foreign key 'id_petani')
    public function petani()
    {
        return $this->belongsTo(Petani::class, 'id_petani');
    }

    // Relasi dengan model Diskusi (menentukan kolom foreign key 'id_diskusi')
    public function diskusi()
    {
        return $this->belongsTo(Diskusi::class, 'id_diskusi');
    }
}

