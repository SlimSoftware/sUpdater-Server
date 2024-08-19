<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PortableApp;

class PortableAppAPIController extends Controller
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
}
