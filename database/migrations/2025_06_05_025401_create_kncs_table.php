<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKncsTable extends Migration
{
    public function up(): void
    {
        Schema::create('kncs', function (Blueprint $table) {
            $table->id();
            $table->string('no_rm', 100);
            $table->string('nama_pasien', 255);
            $table->string('umur', 50);
            $table->enum('jk', ['Laki-Laki', 'Perempuan']);
            $table->dateTime('waktu_mskrs')->nullable();
            $table->dateTime('waktu_insiden')->nullable();
            $table->text('temuan');
            $table->text('kronologis');
            $table->string('unit_terkait', 255);
            $table->string('sumber');
            $table->string('rawat');
            $table->string('poli');
            $table->string('pelaksana');
            $table->string('nama_inisial');
            $table->string('ruangan_pelapor');
            $table->json('foto')->nullable(); // menyimpan array path foto
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kncs');
    }
}
