<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use App\Models\PortableApp;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    public function create(Request $request)
    {
        $app = PortableApp::findOrFail($request->portable_app_id);

        $archive = new Archive($request->all());
        $archive->portableApp()->associate($app);
        $archive->save();

        return response()->json([
            'id' => $archive->id,
        ]);
    }

    public function update(Archive $archive, Request $request)
    {
        $archive->update($request->all());

        return response()->noContent();
    }

    public function delete(Archive $archive)
    {
        $archive->delete();
        return response()->noContent();
    }
}
