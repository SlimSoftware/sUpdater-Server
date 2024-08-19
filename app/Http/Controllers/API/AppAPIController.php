<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\App;

class AppAPIController extends Controller
{
    /**
     * Get all apps
     * URL: /api/v2/apps
     * Method: GET
     */
    public function getAll()
    {
        $apps = App::with(['detectinfo', 'installers'])->orderBy('name')->get();
        return response()->json($apps);
    }

    /**
     * Get an app
     * URL: /api/v2/apps/{id}
     * Method: GET
     */
    public function get(int $id)
    {
        $app = App::with(['detectinfo', 'installers'])->findOrFail($id);
        return response()->json($app);
    }
}
