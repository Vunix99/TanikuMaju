<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCropsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crops', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_petani'); // Tambahkan kolom id_petani
            $table->string('field_name');
            $table->string('crop_type');
            $table->date('plant_date');
            $table->float('field_mass');
            $table->string('soil_moisture');
            $table->string('soil_condition');
            $table->string('rainfall_intensity');
            $table->date('harvest_date');
            $table->text('suggestion');
            $table->timestamps();

            // Tambahkan foreign key constraint
            $table->foreign('id_petani')->references('id_petani')->on('petani')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crops');
    }
}
