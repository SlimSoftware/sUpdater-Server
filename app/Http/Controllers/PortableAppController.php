<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PortableApp;
use Illuminate\Http\Request;

class PortableAppController extends Controller
{
    /**
     * Get all portable apps
     * URL: /api/v2/portable-apps
     * Method: GET
     */
    public function getAll()
    {
        $portableApps = PortableApp::with(['archives'])->orderBy('name')->get();
        return response()->json($portableApps);
    }

    /**
     * Get a portable app
     * URL: /api/v2/portable-apps/{id}
     * Method: GET
     */
    public function get(int $id)
    {
        $portableApp = PortableApp::with(['archives'])->findOrFail($id);
        return response()->json($portableApp);
    }

    public function create(Request $request)
    {
        $app = PortableApp::create([
            'name' => $request->string('name'),
            'version' => $request->string('version'),
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
        $app = PortableApp::findOrFail($id);
        $app->update([
            'name' => $request->string('name'),
            'version' => $request->string('version'),
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
        $app = PortableApp::findOrFail($id);
        $app->archives()->delete();
        $app->delete();

        return response()->noContent();
    }
}
