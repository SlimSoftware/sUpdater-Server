<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('portable_app_category', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\PortableApp::class);
            $table->foreignIdFor(\App\Models\Category::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portable_app_category');
    }
};
