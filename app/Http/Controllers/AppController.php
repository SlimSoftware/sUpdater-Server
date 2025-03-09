<?php

namespace App\Http\Controllers;

use App\Models\App;
use Illuminate\Http\Request;

class AppController extends Controller
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

    public function create(Request $request)
    {
        $app = App::create([
            'name' => $request->string('name'),
            'version' => $request->string('version'),
            'noupdate' => $request->boolean('noupdate'),
            'release_notes_url' => $request->string('release_notes_url'),
            'website_url' => $request->string('website_url'),
        ]);

        return response()->json([
            'id' => $app->id,
        ]);
    }

    /**
     * Store the edited app
     *
     * @return \Illuminate\View\View
     */
    public function update(Request $request, int $id)
    {
        $app = App::findOrFail($id);
        $app->update([
            'name' => $request->string('name'),
            'version' => $request->string('version'),
            'noupdate' => $request->boolean('noupdate'),
            'release_notes_url' => $request->string('release_notes_url'),
            'website_url' => $request->string('website_url'),
        ]);

        return response()->noContent();
    }

    /**
     * Delete an existing app
     *
     * @return \Illuminate\View\View
     */
    public function delete(int $id)
    {
        $app = App::findOrFail($id);
        $app->installers()->delete();
        $app->detectInfo()->delete();
        $app->delete();

        return response()->noContent();
    }
}
