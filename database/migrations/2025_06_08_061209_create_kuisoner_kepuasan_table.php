<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKuisonerKepuasanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kuisoner_kepuasan', function (Blueprint $table) {
            $table->id();
            $table->date('waktu_survei');
            $table->enum('jk', ['L', 'P']);
            $table->integer('usia');
            $table->string('pendidikan');
            $table->string('pekerjaan');
            $table->string('hubungan_pasien');

            // Pertanyaan p1 s/d p9 (skala 1–4)
            $table->tinyInteger('p1');
            $table->tinyInteger('p2');
            $table->tinyInteger('p3');
            $table->tinyInteger('p4');
            $table->tinyInteger('p5');
            $table->tinyInteger('p6');
            $table->tinyInteger('p7');
            $table->tinyInteger('p8');
            $table->tinyInteger('p9');

            $table->text('saran')->nullable();
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
        Schema::dropIfExists('kuisoner_kepuasan');
    }
}
