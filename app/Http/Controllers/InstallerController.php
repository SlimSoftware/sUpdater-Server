<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\App;
use App\Models\Installer;

class InstallerController extends Controller
{
    public function create(Request $request)
    {
        $app = App::findOrFail($request->app_id);

        $installer = new Installer([
            'arch' => $request->input('arch'),
            'reg_key' => $request->input('reg_key'),
            'reg_value' => $request->input('reg_value'),
            'exe_path' => $request->input('exe_path'),
            'download_link' => $request->input('download_link')
        ]);
        $installer->app()->associate($app);
        $installer->save();

        return response()->noContent();
    }

    public function update(Request $request, int $id)
    {
        $installer = Installer::findOrFail($id);

        $installer->update([
            'arch' => $request->input('arch'),
            'reg_key' => $request->input('reg_key'),
            'reg_value' => $request->input('reg_value'),
            'exe_path' => $request->input('exe_path'),
            'download_link' => $request->input('download_link')
        ]);

        return response()->noContent();
    }

    public function delete(int $id) {
        $installer = Installer::findOrFail($id);
        $installer->delete();
        return response()->noContent();
    }
}
