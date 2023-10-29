<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    /**
     * Upload a new file
     *
     * @return \Illuminate\View\View
     */
    public function new(Request $request)
    {
        $file = $request->file('file');
        if ($file) {
            $fileName = $file->getClientOriginalName();
            $stored = $file->storePubliclyAs('uploads', $fileName);

            if ($stored !== false) {
                return response()->json(['path' => $stored]);
            } else {
                return response(null, 500);
            }
        } else {
            return response(null, 400);
        }
    }
}
