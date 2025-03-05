<?php

use App\Models\Archive;
use App\Models\PortableApp;
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
        Schema::table('archives', function (Blueprint $table) {
            $table->tinyInteger('arch')->unsigned();
        });

        $portableApps = PortableApp::all();
        foreach ($portableApps as $portableApp) {
            $archive = Archive::where(['portable_app_id' => $portableApp->id])->first();
            $archive->arch = $portableApp->arch;
            $archive->save();
        }

        Schema::table('portable_apps', function (Blueprint $table) {
            $table->dropColumn('arch');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('portable_apps', function (Blueprint $table) {
            $table->tinyInteger('arch')->unsigned();
        });

        $portableApps = PortableApp::all();
        foreach ($portableApps as $portableApp) {
            $archive = Archive::where(['portable_app_id' => $portableApp->id])->first();
            $portableApp->arch = $archive->arch;
            $portableApp->save();
        }

        Schema::table('archives', function (Blueprint $table) {
            $table->dropColumn('arch');
        });
    }
};
