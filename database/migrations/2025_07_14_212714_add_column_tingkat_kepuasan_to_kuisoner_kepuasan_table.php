<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTingkatKepuasanToKuisonerKepuasanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kuisoner_kepuasan', function (Blueprint $table) {
            $table->string('tingkat_kepuasan')->nullable()->after('saran');
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
            $table->dropColumn('tingkat_kepuasan');
        });
    }
}
