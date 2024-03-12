<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
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
        $portableApps = PortableApp::orderBy('name')
            ->doesntHave('categories')
            ->get();

        return response()->json($portableApps);
    }

    /**
     * Get all portable apps in a category
     * URL: /api/v2/portable-apps/category/{id} or /api/v2/portable-apps/category/{slug}
     * Method: GET
     */
    public function getCategory(mixed $category)
    {
        $category = is_int($category)
            ? Category::findOrFail($category)
            : Category::where('slug', $category)->firstOrFail();
        $apps = $category->portableApps;

        return response()->json($apps);
    }

    /**
     * Get a portable app
     * URL: /api/v2/portable-apps/{id}
     * Method: GET
     */
    public function get(int $id)
    {
        $portableApp = PortableApp::findOrFail($id);
        return response()->json($portableApp);
    }
}
