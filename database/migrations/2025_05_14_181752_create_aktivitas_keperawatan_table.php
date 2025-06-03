<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAktivitasKeperawatanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aktivitas_keperawatan', function (Blueprint $table) {
            $table->id()->unique();
            $table->dateTime('waktu');
            $table->enum('shift', ['Pagi', 'Sore', 'Malam']);
            $table->string('nama_perawat');
            $table->string('unit_kerja');
            $table->text('aktivitas');
            $table->text('catatan')->nullable();
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
        Schema::dropIfExists('aktivitas_keperawatan');
    }
}
