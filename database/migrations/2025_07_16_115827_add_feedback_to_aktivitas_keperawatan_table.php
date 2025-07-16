<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFeedbackToAktivitasKeperawatanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('aktivitas_keperawatan', function (Blueprint $table) {
            $table->text('feedback')->nullable()->after('approvement');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('aktivitas_keperawatan', function (Blueprint $table) {
            $table->dropColumn('feedback');
        });
    }
}
