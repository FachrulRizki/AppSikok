<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLimaRTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lima_r', function (Blueprint $table) {
            $table->id();
            $table->timestamp('waktu');
            $table->string('shift');
            $table->json('dilaksanakan');
            $table->json('catatan')->nullable();
            $table->json('foto')->nullable(); // simpan array path file gambar
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('lima_r');
    }
}
