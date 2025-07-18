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
            ...$request->all(),
            'download_link' => $request->input('download_link_raw'),
        ]);
        
        $installer->app()->associate($app);
        $installer->detectinfo()->associate($detectInfo);
        $installer->save();

        return response()->json([
            'id' => $installer->id,
        ]);
    }

    public function update(Request $request, int $id)
    {
        $installer = Installer::findOrFail($id);
        $installer->update([
            ...$request->all(),
            'download_link' => $request->input('download_link_raw'),
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
