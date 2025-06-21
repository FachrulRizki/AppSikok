<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDataTypeTextToLongTextInRefleksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('refleksi', function (Blueprint $table) {
            $table->longText('poin_materi')->nullable()->change();
            $table->longText('pribadi')->nullable()->change();
            $table->longText('tindakan')->nullable()->change();
            $table->longText('feedback')->nullable()->change();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('refleksi', function (Blueprint $table) {
            $table->text('poin_materi')->nullable()->change();
            $table->text('pribadi')->nullable()->change();
            $table->text('tindakan')->nullable()->change();
            $table->text('feedback')->nullable()->change();
        });
        Schema::enableForeignKeyConstraints();
    }
}
