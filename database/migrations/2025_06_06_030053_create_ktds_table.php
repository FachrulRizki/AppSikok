<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKtdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ktds', function (Blueprint $table) {
            $table->id();
            $table->string('no_rm');
            $table->string('nama_pasien');
            $table->integer('umur');
            $table->enum('jk', ['Laki-Laki', 'Perempuan']);
            $table->timestamp('waktu_mskrs')->nullable();
            $table->timestamp('waktu_insiden')->nullable();
            $table->text('temuan');
            $table->text('kronologis');
            $table->string('unit_terkait');
            $table->string('sumber');
            $table->string('rawat');
            $table->string('poli')->nullable();
            $table->string('akibat')->nullable();
            $table->string('lokasi')->nullable();
            $table->text('tindakan_segera')->nullable();
            $table->string('pelaksana');
            $table->string('nama_inisial');
            $table->string('ruangan_pelapor');
            $table->text('foto')->nullable();
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
        Schema::dropIfExists('ktds');
    }
}
