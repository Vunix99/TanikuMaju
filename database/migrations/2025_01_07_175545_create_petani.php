<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('petani', function (Blueprint $table) {
            $table->id('id_petani');
            $table->string('username');
            $table->string('nama_petani');
            $table->string('nomor_wa');
            $table->string('password');
            $table->string('foto_profil')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('petani');
    }
};
