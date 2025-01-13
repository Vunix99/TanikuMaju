<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens; // Ensure this trait is included for API tokens
use Illuminate\Foundation\Auth\User as Authenticatable; // Add the Authenticatable class

class Petani extends Authenticatable // Make sure it extends Authenticatable
{
    use HasFactory, HasApiTokens; // Use both the HasFactory and HasApiTokens traits

    protected $table = 'petani'; // The table name
    protected $primaryKey = 'id_petani'; // Primary key for the Petani table

    protected $fillable = [
        'username',
        'nama_petani',
        'nomor_wa',
        'password',
        'foto_profil',
    ];

    public function lahans(): HasMany
    {
        return $this->hasMany(Lahan::class, 'id_petani', 'id_petani');
    }

    // Menambahkan relasi dengan Chat
    public function chats()
    {
        return $this->hasMany(Chat::class,'id_petani');
    }

    // Add any other necessary methods, such as for authentication (optional)
}
