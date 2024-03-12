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
     * URL: /api/v2/portable-apps/category/{id}
     * Method: GET
     */
    public function getCategoryById(int $id)
    {
        $category = Category::findOrFail($id);
        $apps = $category->portableApps;

        return response()->json($apps);
    }

    /**
     * Get all portable apps in a category
     * URL: /api/v2/portable-apps/category/{slug}
     * Method: GET
     */
    public function getCategoryBySlug(string $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
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
