<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration untuk tabel Prediksi Panen
return new class extends Migration
{
    public function up()
    {
        Schema::create('prediksi_panen', function (Blueprint $table) {
            $table->id('id_prediksi');
            $table->unsignedBigInteger('id_tanaman');
            $table->float('prediksi_hasil_panen');
            $table->date('tanggal_prediksi');
            $table->timestamps();

            $table->foreign('id_tanaman')->references('id_tanaman')->on('tanaman')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('prediksi_panen');
    }
};
