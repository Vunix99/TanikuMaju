<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->id();  // ID untuk tabel chats
            $table->unsignedBigInteger('id_petani');
            $table->unsignedBigInteger('id_diskusi');

            // Definisikan relasi dengan kolom 'id_petani' yang mengacu pada kolom 'id_petani' di tabel 'petani'
            $table->foreign('id_petani')->references('id_petani')->on('petani')->onDelete('cascade');
            // Definisikan relasi dengan kolom 'id_diskusi' yang mengacu pada kolom 'id_diskusi' di tabel 'diskusi'
            $table->foreign('id_diskusi')->references('id_diskusi')->on('diskusi')->onDelete('cascade');
            $table->timestamp('tanggal_komentar')->useCurrent();  // Waktu komentar
            $table->text('isi_komentar')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('chats');
    }
};
