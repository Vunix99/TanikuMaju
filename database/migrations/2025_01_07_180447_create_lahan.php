<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration untuk tabel Lahan
return new class extends Migration
{
    public function up()
    {
        Schema::create('lahan', function (Blueprint $table) {
            $table->id('id_lahan');
            $table->unsignedBigInteger('id_petani');
            $table->float('luas_lahan');
            $table->string('jenis_tanah');
            $table->float('kadar_air_tanah');
            $table->float('ph_tanah');
            $table->timestamps();

            $table->foreign('id_petani')->references('id_petani')->on('petani')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('lahan');
    }
};
