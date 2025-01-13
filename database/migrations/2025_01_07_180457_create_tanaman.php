<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration untuk tabel Tanaman
return new class extends Migration
{
    public function up()
    {
        Schema::create('tanaman', function (Blueprint $table) {
            $table->id('id_tanaman');
            $table->unsignedBigInteger('id_lahan');
            $table->string('jenis_tanaman');
            $table->date('tanggal_tanam');
            $table->timestamps();

            $table->foreign('id_lahan')->references('id_lahan')->on('lahan')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tanaman');
    }
};
