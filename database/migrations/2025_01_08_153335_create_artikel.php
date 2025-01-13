<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {   
        Schema::create('artikel', function (Blueprint $table) {
            $table->id(); // Kolom ID (primary key) otomatis
            $table->string('judul'); // Kolom untuk judul (string)
            $table->string('gambar'); // Kolom untuk menyimpan path gambar (string)
            $table->date('tanggal'); // Kolom untuk tanggal
            $table->text('isi'); // Kolom untuk isi artikel (teks panjang)
            $table->timestamps(); // Kolom created_at dan updated_at
        });

        Artisan::call('post:artikel');
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artikel');

    }
};