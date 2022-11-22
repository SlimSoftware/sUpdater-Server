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

    /**
     * Add a new app
     *
     * @return \Illuminate\View\View
     */
    public function new(Request $request)
    {
        return view('apps.new');
    }

    /**
     * Edit an existing app
     *
     * @return \Illuminate\View\View
     */
    public function edit(Request $request, int $id)
    {
        $app = App::find($id);
        return view('apps.edit', ['app' => $app]);
    }
}
