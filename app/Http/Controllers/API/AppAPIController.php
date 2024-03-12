<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\App;
use App\Models\Category;

class AppAPIController extends Controller
{
    /**
     * Get all apps without a category
     * URL: /api/v2/apps
     * Method: GET
     */
    public function getAll()
    {
        $apps = App::orderBy('name')
            ->doesntHave('categories')
            ->get();

        return response()->json($apps);
    }

    /**
     * Get all apps in a category
     * URL: /api/v2/apps/category/{id} or /api/v2/apps/category/{slug}
     * Method: GET
     */
    public function getCategory(mixed $category)
    {
        $category = is_int($category)
            ? Category::findOrFail($category)
            : Category::where('slug', $category)->firstOrFail();
        $apps = $category->apps;

        return response()->json($apps);
    }

    /**
     * Get an app
     * URL: /api/v2/apps/{id}
     * Method: GET
     */
    public function get(int $id)
    {
        $app = App::findOrFail($id);
        return response()->json($app);
    }
}
