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
        Schema::create('detectinfo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('app_id');
            $table->foreign('app_id')->references('id')->on('apps');
            $table->tinyInteger('arch')->unsigned();
            $table->string('reg_key');
            $table->string('reg_value');
            $table->string('exe_path');

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
        Schema::dropIfExists('detectinfo');
    }
};
