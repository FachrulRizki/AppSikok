<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAktivitasKeperawatanLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aktivitas_keperawatan_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aktivitas_keperawatan_id')->constrained('aktivitas_keperawatan')->onDelete('cascade');
            $table->foreignId('activity_id')->constrained('activities')->onDelete('cascade');
            $table->foreignId('activity_detail_id')->constrained('activity_details')->onDelete('cascade');
            $table->foreignId('activity_task_id')->constrained('activity_tasks')->onDelete('cascade');
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
        Schema::dropIfExists('aktivitas_keperawatan_logs');
    }
}
