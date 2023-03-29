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

        return response()->noContent();
    }

    /**
     * Store the edited detectinfo
     *
     * @return \Illuminate\View\View
     */
    public function update(Request $request, int $id)
    {
        $detectInfo = DetectInfo::findOrFail($id);

        $detectInfo->update([
            'arch' => $request->input('arch'),
            'reg_key' => $request->input('reg_key'),
            'reg_value' => $request->input('reg_value'),
            'exe_path' => $request->input('exe_path'),
            'download_link' => $request->input('download_link')
        ]);

        return response()->noContent();
    }

}
