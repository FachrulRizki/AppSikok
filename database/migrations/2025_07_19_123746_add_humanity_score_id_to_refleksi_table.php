<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHumanityScoreIdToRefleksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('refleksi', function (Blueprint $table) {
            $table->foreignId('humanity_score_id')
                ->nullable()
                ->after('nilai')
                ->constrained('humanity_scores')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('refleksi', function (Blueprint $table) {
            $table->dropForeign(['humanity_score_id']);
            $table->dropColumn('humanity_score_id');
        });
    }
}
