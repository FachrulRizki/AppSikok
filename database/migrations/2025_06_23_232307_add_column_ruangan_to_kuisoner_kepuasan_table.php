<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnRuanganToKuisonerKepuasanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kuisoner_kepuasan', function (Blueprint $table) {
            $table->string('ruangan')->nullable()->after('saran');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kuisoner_kepuasan', function (Blueprint $table) {
            $table->dropColumn('ruangan');
        });
    }
}
