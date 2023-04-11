<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Models\App;

class AppAPIController extends Controller
{
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
