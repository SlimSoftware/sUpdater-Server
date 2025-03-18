<?php

namespace App\Http\Controllers;

use App\Models\App;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function getAll()
    {
        $apps = App::with(['detectinfo', 'installers'])->orderBy('name')->get();
        return response()->json($apps);
    }

    public function get(int $id)
    {
        $app = App::with(['detectinfo', 'installers'])->findOrFail($id);
        return response()->json($app);
    }

    public function create(Request $request)
    {
        $app = App::create($request->all());

        return response()->json([
            'id' => $app->id,
        ]);
    }

    public function update(Request $request, int $id)
    {
        $app = App::findOrFail($id);
        $app->update($request->all());

        return response()->noContent();
    }

    public function delete(int $id)
    {
        $app = App::findOrFail($id);
        $app->installers()->delete();
        $app->detectInfo()->delete();
        $app->delete();

        return response()->noContent();
    }
}
