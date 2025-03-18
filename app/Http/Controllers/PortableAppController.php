<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PortableApp;
use Illuminate\Http\Request;

class PortableAppController extends Controller
{
    public function getAll()
    {
        $portableApps = PortableApp::with(['archives'])->orderBy('name')->get();
        return response()->json($portableApps);
    }

    public function get(int $id)
    {
        $portableApp = PortableApp::with(['archives'])->findOrFail($id);
        return response()->json($portableApp);
    }

    public function create(Request $request)
    {
        $app = PortableApp::create($request->all());

        return response()->json([
            'id' => $app->id,
        ]);
    }

    public function update(Request $request, int $id)
    {
        $app = PortableApp::findOrFail($id);
        $app->update($request->all());

        return response()->noContent();
    }

    public function delete(int $id)
    {
        $app = PortableApp::findOrFail($id);
        $app->archives()->delete();
        $app->delete();

        return response()->noContent();
    }
}
