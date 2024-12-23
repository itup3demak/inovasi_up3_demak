<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DataTrafo extends Migration
{
    public function up()
    {
        Schema::create('data_trafo2', function (Blueprint $table) {
            $table->id();
            $table->string('rayon')->nullable();
            $table->string('nomor_tiang')->nullable();
            $table->string('nomor_gardu')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('x1')->nullable();
            $table->string('x2')->nullable();
            $table->string('n')->nullable();
            $table->string('perhitungan_beban')->nullable();
            $table->string('klasifikasi_beban')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_trafo2');
    }
}
