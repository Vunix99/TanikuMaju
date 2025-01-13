<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diskusi extends Model
{
    use HasFactory;
    protected $table = 'diskusi'; // Nama tabel yang sesuai
    protected $fillable = ['topik']; // Atribut yang bisa diisi

    public function chats()
    {
        return $this->hasMany(Chat::class,'id_diskusi');
    }
}
