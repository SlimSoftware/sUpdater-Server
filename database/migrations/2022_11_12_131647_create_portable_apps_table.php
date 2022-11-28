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
        Schema::create('portable_apps', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('version');
            $table->tinyInteger('arch')->unsigned();

            $table->string('website_url')->nullable();
            $table->string('release_notes_url')->nullable();

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
        Schema::dropIfExists('portable_apps');
    }
};
