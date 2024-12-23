<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EntriPelangganApp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entri_pelanggan_app', function (Blueprint $table) {
            $table->id();
            $table->string('tanggal_pasang')->nullable();
            $table->string('id_pelanggan')->nullable();
            $table->string('nama_pelanggan')->nullable();
            $table->string('tarif')->nullable();
            $table->string('daya')->nullable();
            $table->string('alamat')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('jenis_meter')->nullable();
            $table->string('nomor_meter')->nullable();
            $table->string('merk_meter')->nullable();
            $table->string('tahun_meter')->nullable();
            $table->string('merk_mcb')->nullable();
            $table->string('ukuran_mcb')->nullable();
            $table->string('no_segel')->nullable();
            $table->string('no_gardu')->nullable();
            $table->string('sr_deret')->nullable();
            $table->string('nama_petugas')->nullable();
            $table->string('catatan');
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
        Schema::dropIfExists('entri_pelanggan_app');
    }
}
