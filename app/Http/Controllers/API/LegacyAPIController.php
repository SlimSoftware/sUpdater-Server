<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\App;
use App\Models\Category;
use App\Models\PortableApp;
use Illuminate\Http\Request;
use SimpleXMLElement;

class LegacyAPIController extends Controller
{
    /**
     * Legacy API endpoint to get all apps or all apps in a category
     * URL: /api/v1/apps or /api/v1/category/{id} or /api/v1/category/{slug}
     * Method: GET
     */
    public function apps_v1(mixed $category = null)
    {
        $xml = new SimpleXMLElement('<defenitions version="1.0"></defenitions>');
        $archs = ['*', 'x86', 'x64'];

        if ($category === null) {
            $apps = App::orderBy('name')
                ->doesntHave('categories')
                ->get();
        } else {
            $category = is_int($category)
                ? Category::findOrFail($category)
                : Category::where('slug', $category)->firstOrFail();
            $apps = $category->apps;
        }

        foreach ($apps as $app) {
            $detectInfo = $app->detectInfo[0];
            $installer = $app->installers[0];

            $appElement = $xml->addChild('app');
            $appElement->addAttribute('name', $app->name);
            $appElement->addChild('id', $app->id);
            $appElement->addChild('arch', $archs[$detectInfo->arch]);

            $dl = $installer->downloadLinkParsed;
            $appElement->addChild('dl', $dl);

            if ($detectInfo->exe_path) {
                $appElement->addChild('exePath', $detectInfo->exe_path);
            }

            $appElement->addChild('hasChangelog', isset($app->release_notes_url) ? 1 : 0);
            $appElement->addChild('hasWebsite', isset($app->website_url) ? 1 : 0);

            if ($detectInfo->reg_key) {
                $appElement->addChild('regkey', $detectInfo->reg_key);
                $appElement->addChild('regvalue', $detectInfo->reg_value);
            }

            $appElement->addChild('switch', $installer->launch_args);
            $noUpdate = $app->noupdate === true ? 'noupdate' : 'setup';
            $appElement->addChild('type', $noUpdate);
            $appElement->addChild('version', $app->version);
        }

        if ($category === null) {
            $portableApps = PortableApp::orderBy('name')
                ->doesntHave('categories')
                ->get();
        } else {
            $portableApps = $category->portableApps;
        }

        $extractModes = ['folder', 'single'];

        foreach ($portableApps as $portableApp) {
            $archive = $portableApp->archives[0];

            $appElement = $xml->addChild('portable');
            $appElement->addAttribute('name', $portableApp->name);
            $appElement->addChild('id', $portableApp->id);
            $appElement->addChild('arch', $archs[$portableApp->arch]);

            $dl = $archive->downloadLinkParsed;
            $appElement->addChild('dl', $dl);

            $appElement->addChild('hasChangelog', isset($portableApp->release_notes_url) ? 1 : 0);
            $appElement->addChild('hasDescription', isset($portableApp->website_url) ? 1 : 0);

            $appElement->addChild('extractmode', $extractModes[$archive->extract_mode]);
            $appElement->addChild('launch', $portableApp->launch_file);
            $appElement->addChild('version', $portableApp->version);
        }

        return response($xml->asXML(), 200)->header('Content-Type', 'application/xml');
    }

    /**
     * Redirects to the release notes URL for this app
     * URL: /api/v1/changelog
     * Method: GET
     */
    public function changelog(Request $request)
    {
        if ($request->query('id')) {
            $model = App::findOrFail($request->query('id'));
        } elseif ($request->query('pid')) {
            $model = PortableApp::findOrFail($request->query('pid'));
        } else {
            return response(null, 400);
        }

        if ($model->release_notes_url) {
            return redirect($model->release_notes_url);
        } else {
            return response(null, 404);
        }
    }

    /**
     * Redirects to the website URL for this app
     * URL: /api/v1/website
     * Method: GET
     */
    public function website(Request $request)
    {
        if ($request->query('id')) {
            $model = App::findOrFail($request->query('id'));
        } elseif ($request->query('pid')) {
            $model = PortableApp::findOrFail($request->query('pid'));
        } else {
            return response(null, 400);
        }

        if ($model->website_url) {
            return redirect($model->website_url);
        } else {
            return response(null, 404);
        }
    }
}
