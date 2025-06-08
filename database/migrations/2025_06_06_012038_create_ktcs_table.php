<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKtcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ktcs', function (Blueprint $table) {
            $table->id();
            $table->string('no_rm', 100);
            $table->string('nama_pasien', 255);
            $table->string('umur', 10);
            $table->enum('jk', ['Laki-Laki', 'Perempuan']);
            $table->dateTime('waktu_mskrs')->nullable();
            $table->dateTime('waktu_insiden')->nullable();
            $table->text('temuan');
            $table->text('kronologis');
            $table->string('unit_terkait');
            $table->string('sumber');
            $table->string('rawat');
            $table->string('poli');
            $table->string('lokasi');
            $table->string('unit');
            $table->text('tindakan_segera');
            $table->string('pelaksana');
            $table->string('nama_inisial');
            $table->string('ruangan_pelapor');
            $table->json('foto')->nullable();
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
        Schema::dropIfExists('ktcs');
    }
}
