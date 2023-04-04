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
        $detectInfo = DetectInfo::findOrFail($id);
        return response()->json($detectInfo);
    }

    public function delete(int $id) {
        $detectInfo = DetectInfo::findOrFail($id);
        $detectInfo->delete();
        return response()->noContent();
    }
}
