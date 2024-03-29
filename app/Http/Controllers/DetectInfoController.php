<?php

namespace App\Http\Controllers;

use App\Models\App;
use App\Models\DetectInfo;
use Illuminate\Http\Request;

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
            'download_link' => $request->input('download_link'),
        ]);
        $detectInfo->app()->associate($app);
        $detectInfo->save();

        return response()->noContent();
    }

    public function update(Request $request, int $id)
    {
        $detectInfo = DetectInfo::findOrFail($id);

        $detectInfo->update([
            'arch' => $request->input('arch'),
            'reg_key' => $request->input('reg_key'),
            'reg_value' => $request->input('reg_value'),
            'exe_path' => $request->input('exe_path'),
            'download_link' => $request->input('download_link'),
        ]);

        return response()->noContent();
    }

    public function delete(int $id)
    {
        $detectInfo = DetectInfo::findOrFail($id);
        $detectInfo->delete();
        return response()->noContent();
    }
}
