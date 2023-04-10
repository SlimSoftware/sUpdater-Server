<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('installers', function (Blueprint $table) {
            $table->foreignId('detectinfo_id');
            $table->foreign('detectinfo_id')->references('id')->on('detectinfo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('installers', function (Blueprint $table) {
            $table->dropForeign('detectinfo_id');
        });
    }
};
