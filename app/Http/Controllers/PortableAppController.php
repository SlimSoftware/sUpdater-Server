<?php

namespace App\Http\Controllers;

use App\Models\PortableApp;

class PortableAppController extends Controller
{
    /**
     * Shows all available Portable Apps
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $portableApps = PortableApp::orderBy('name')->get();
        return view('portable-apps.index', ['portableApps' => $portableApps]);
    }

    /**
     * Add a new Portable App
     *
     * @return \Illuminate\View\View
     */
    public function new()
    {
        return view('portable-apps.new');
    }

    /**
     * Edit an existing Portable App
     *
     * @return \Illuminate\View\View
     */
    public function edit(int $id)
    {
        $portableApp = PortableApp::find($id);
        return view('portable-apps.edit', ['portableApp' => $portableApp]);
    }
}
