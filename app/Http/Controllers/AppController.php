<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\App;

class AppController extends Controller
{
    /**
     * Shows all available apps
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $apps = App::orderBy('name')->get();
        return view('apps.index', ['apps' => $apps]);
    }
}
