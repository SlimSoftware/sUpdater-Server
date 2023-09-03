<?php

namespace App\Http\Controllers;

use App\Models\App;
use Illuminate\Http\Request;

class AppController extends Controller
{
    /**
     * Shows all available apps
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $apps = App::orderBy('name')->get();
        return view('apps.index', ['apps' => $apps]);
    }

    /**
     * View for adding a new app
     *
     * @return \Illuminate\View\View
     */
    public function new()
    {
        return view('apps.new');
    }

    /**
     * Edit an existing app
     *
     * @return \Illuminate\View\View
     */
    public function edit(int $id)
    {
        return view('apps.edit', ['id' => $id]);
    }

    public function create(Request $request)
    {
        $app = App::create([
            'name' => $request->string('name'),
            'version' => $request->string('version'),
            'noupdate' => $request->boolean('noupdate'),
            'release_notes_url' => $request->string('release_notes_url'),
            'website_url' => $request->string('website_url'),
        ]);

        return response()->json([
            'id' => $app->id,
        ]);
    }

    /**
     * Store the edited app
     *
     * @return \Illuminate\View\View
     */
    public function update(Request $request, int $id)
    {
        $app = App::findOrFail($id);
        $app->update([
            'name' => $request->string('name'),
            'version' => $request->string('version'),
            'noupdate' => $request->boolean('noupdate'),
            'release_notes_url' => $request->string('release_notes_url'),
            'website_url' => $request->string('website_url'),
        ]);

        return response()->noContent();
    }

    /**
     * Delete an existing app
     *
     * @return \Illuminate\View\View
     */
    public function delete(int $id)
    {
        $app = App::findOrFail($id);
        $app->detectInfo()->delete();
        $app->installers()->delete();
        $app->delete();

        return redirect()->route('apps');
    }
}
