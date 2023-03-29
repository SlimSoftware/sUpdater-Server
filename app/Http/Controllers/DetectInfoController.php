<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\App;
use App\Models\DetectInfo;

class DetectInfoController extends Controller
{
    public function create(Request $request)
    {
        $app = App::findOrFail($request->app_id);

        $detectInfo = new DetectInfo([
            'arch' => $request->input('arch'),
            'reg_key' => $request->input('reg_key'),
            'reg_value' => $request->input('reg_value'),
            'exe_path' => $request->input('exe_path'),
            'download_link' => $request->input('download_link')
        ]);
        $detectInfo->app()->associate($app);
        $detectInfo->save();

        return redirect()->route('apps.edit', $request->app_id);
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

}
