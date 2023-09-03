<?php

namespace App\Http\Controllers;

use App\Models\App;
use App\Models\DetectInfo;
use App\Models\Installer;
use Illuminate\Http\Request;

class InstallerController extends Controller
{
    public function create(Request $request)
    {
        $app = App::findOrFail($request->app_id);
        $detectInfo = DetectInfo::findOrFail($request->detectinfo_id);

        $installer = new Installer([
            'arch' => $request->input('arch'),
            'download_link' => $request->input('download_link'),
            'launch_args' => $request->input('launch_args'),
        ]);
        $installer->app()->associate($app);
        $installer->detectinfo()->associate($detectInfo);
        $installer->save();

        return response()->noContent();
    }

    public function update(Request $request, int $id)
    {
        $installer = Installer::findOrFail($id);

        $installer->update([
            'arch' => $request->input('arch'),
            'download_link' => $request->input('download_link'),
            'launch_args' => $request->input('launch_args'),
        ]);

        return response()->noContent();
    }

    public function delete(int $id)
    {
        $installer = Installer::findOrFail($id);
        $installer->delete();
        return response()->noContent();
    }
}
