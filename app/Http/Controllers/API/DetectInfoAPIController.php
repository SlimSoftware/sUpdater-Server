<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Models\DetectInfo;

class DetectInfoAPIController extends Controller
{
    /**
     * Get detection info for an app
     * URL: /api/v2/detectinfo/{id}
     * Method: GET
     */
    public function get(int $id) 
    {
        $detectInfo = DetectInfo::where('app_id', $id)->get();
        return response()->json($detectInfo);
    }
}
