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
        Schema::create('websites', function (Blueprint $table) {
            $table->id();

            $table->foreignId('app_id')->nullable();
            $table->foreign('app_id')->references('id')->on('apps');

            $table->foreignId('portable_app_id')->nullable();
            $table->foreign('portable_app_id')->references('id')->on('portable_apps');
            
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
        Schema::dropIfExists('websites');
    }
};
