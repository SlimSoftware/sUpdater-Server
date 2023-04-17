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
        $apps = App::all();
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

    /**
     * Redirects to the release notes URL for this app
     * URL: /api/v2/release-notes/{id}
     * Method: GET
     */
    public function releaseNotes(int $id) {
        $app = App::findOrFail($id);
        return redirect($app->release_notes_url);
    }

    /**
     * Redirects to the website URL for this app
     * URL: /api/v2/website/{id}
     * Method: GET
     */
    public function website(int $id) {
        $app = App::findOrFail($id);
        return redirect($app->website_url);
    }
}
