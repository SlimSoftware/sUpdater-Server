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

        $detectInfo = new DetectInfo($request->all());
        $detectInfo->app()->associate($app);
        $detectInfo->save();

        return response()->noContent();
    }

    public function update(Request $request, int $id)
    {
        $detectInfo = DetectInfo::findOrFail($id);
        $detectInfo->update($request->all());

        return response()->noContent();
    }

    public function delete(int $id)
    {
        $detectInfo = DetectInfo::findOrFail($id);
        $detectInfo->delete();
        return response()->noContent();
    }
}
