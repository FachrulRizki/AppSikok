<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpvKepruTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spv_kepru', function (Blueprint $table) {
            $table->id();
            $table->dateTime('waktu');
            $table->string('nm_kepru');
            $table->string('shift');
            $table->text('aktivitas')->nullable();
            $table->text('observasi')->nullable();
            $table->text('perbaikan')->nullable();
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
        Schema::dropIfExists('spv_kepru');
    }
}
