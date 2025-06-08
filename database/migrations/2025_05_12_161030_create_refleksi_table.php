<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefleksiTable extends Migration
{
    public function up()
    {
        Schema::create('refleksi', function (Blueprint $table) {
            $table->id();
            $table->dateTime('waktu');
            $table->string('jdl_kegiatan');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('poin_materi')->nullable();
            $table->text('pribadi')->nullable();
            $table->text('tindakan')->nullable();
            $table->enum('approvement', ['waiting', 'approved', 'rejected'])->default('waiting');
            $table->integer('nilai')->default(0);
            $table->text('feedback')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('refleksi');
    }
}
