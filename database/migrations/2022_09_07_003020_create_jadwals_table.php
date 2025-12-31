<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwals', function (Blueprint $table) {
            $table->id('id_jadwal');
            $table->date('tgl_jadwal');
            $table->time('jam_masuk');
            $table->time("jam_pulang");
            $table->boolean('status_masuk')->default('0');
            $table->integer('jumlah_maxpasien')->default('30');
            $table->integer('jumlah_pasien_hari_ini')->default('0');
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
        Schema::dropIfExists('jadwals');
    }
}
