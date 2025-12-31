<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekamMedisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekam_medis', function (Blueprint $table) {
            $table->id('id_rekam_medis');
            $table->foreignId('user_id');
            $table->string('nama_penyakit');
            $table->string('nama_pasien');
            $table->string('kadar_gula_darah')->default('-');
            $table->string('kadar_kolesterol')->default('-');
            $table->string('kadar_asam_urat')->default('-');
            $table->string('tekanan_darah')->default('-');
            $table->string('alergi_makanan')->default('-');
            $table->date('tgl_periksa');
            $table->integer('usia');
            $table->longText('keterangan');
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
        Schema::dropIfExists('rekam_medis');
    }
}
