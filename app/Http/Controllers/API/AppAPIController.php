<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Models\App;

class AppAPIController extends Controller
{
    /**
     * Get a specific app
     * URL: /api/v2/apps/{id}
     * Method: GET
     */
    public function app(int $id) 
    {
        $app = App::with(['detectInfo', 'installer'])->findOrFail($id);
        return response()->json($app);
    }
}
