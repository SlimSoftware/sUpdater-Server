<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Models\Installer;

class InstallerAPIController extends Controller
{
    /**
     * Get an installer for an app
     * URL: /api/v2/installers/{id}
     * Method: GET
     */
    public function get(int $id) 
    {
        $installer = Installer::with('app')->where('app_id', $id)->first();
        return response()->json($installer);
    }
}
