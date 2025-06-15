<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKpcsTable extends Migration
{
    public function up()
    {
        Schema::create('kpcs', function (Blueprint $table) {
            $table->id();
            $table->dateTime('waktu');
            $table->text('temuan');
            $table->text('kronologis');
            $table->string('sumber');
            $table->string('unit_terkait');
            $table->string('ruangan');
            $table->text('tindakan');
            $table->string('pelaksana');
            $table->string('nama_inisial');
            $table->text('foto')->nullable(); // menyimpan array path foto
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kpcs');
    }
}
