<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\App;
use App\Models\DetectInfo;
use App\Models\Installer;

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

    public function create(Request $request)
    {
        $app = App::create([
            'name' => $request->input('name'),
            'version' => $request->input('version'),
            'noupdate' => $request->boolean('noupdate')
        ]);

        $detectInfo = new DetectInfo([
            'arch' => $request->input('arch'),
            'reg_key' => $request->input('regKey'),
            'reg_value' => $request->input('regValue'),
            'exe_path' => $request->input('exePath'),
            'download_link' => $request->input('downloadLink')
        ]);
        $detectInfo->app()->associate($app);
        $detectInfo->save();

        $installer = new Installer([
            'download_link' => $request->input('downloadLink'),
            'launch_args' => $request->input('launchArgs')
        ]);
        $installer->app()->associate($app);
        $installer->save();

        return redirect()->route('apps');
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

    /**
     * Store the edited app
     *
     * @return \Illuminate\View\View
     */
    public function update(Request $request, int $id)
    {
        $app = App::find($id);
        $app->update([
            'name' => $request->input('name'),
            'version' => $request->input('version'),
            'noupdate' => $request->boolean('noupdate')
        ]);

        $app->detectInfo->update([
            'arch' => $request->input('arch'),
            'reg_key' => $request->input('regKey'),
            'reg_value' => $request->input('regValue'),
            'exe_path' => $request->input('exePath'),
            'download_link' => $request->input('downloadLink')
        ]);

        $app->installer->update([
            'download_link' => $request->input('downloadLink'),
            'launch_args' => $request->input('launchArgs')
        ]);

        return redirect()->route('apps');
    }

    /**
     * Delete an existing app
     *
     * @return \Illuminate\View\View
     */
    public function delete(int $id)
    {
        $app = App::find($id);
        $app->detectInfo()->delete();
        $app->installer()->delete();
        $app->delete();

        return redirect()->route('apps');
    }
}
