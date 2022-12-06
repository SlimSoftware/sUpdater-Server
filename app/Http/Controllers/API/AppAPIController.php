<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use SimpleXMLElement;

use App\Models\App;
use App\Models\PortableApp;

class AppAPIController extends Controller
{
    /**
     * Legacy API endpoint to get all apps
     * URL: /api/v1/apps
     * Method: GET
     */
    public function apps_v1()
    {
        $xml = new SimpleXMLElement('<defenitions version="1.0"></defenitions>');
        $archs = ["*", "x86", "x64"];
        $apps = App::orderBy('name')->get();

        foreach ($apps as $app) {
            $detectInfo = $app->detectInfo;
            $installer = $app->installer;

            $appElement = $xml->addChild('app');
            $appElement->addAttribute("name", $app->name);
            $appElement->addChild("id", $app->id);
            $appElement->addChild("arch", $archs[$detectInfo->arch]);
        
            $dl = $installer->download_link;
        
            if (strpos($dl, "%ver%") !== false) {
                $dl = str_replace("%ver%", $app->version, $dl);
            }
            if (strpos($dl, "%verMajorMinor%") !== false) {
                $dl = str_replace("%verMajorMinor%", self::convertToMajorMinorVersion($app->version), $dl);
            }
            if (strpos($dl, "%verDotless%") !== false) {
                $dl = str_replace("%verDotless%", self::convertToDotlessVersion($app->version), $dl);
            }
        
            $appElement->addChild("dl", $dl);
            
            if ($detectInfo->exe_path) {
                $appElement->addChild("exePath", $detectInfo->exe_path);
            }
        
            $appElement->addChild("hasChangelog", isset($app->release_notes_url) ? 1 : 0);
            $appElement->addChild("hasWebsite", isset($app->website_url) ? 1 : 0);
        
            if ($detectInfo->reg_key) {
                $appElement->addChild("regkey", $detectInfo->reg_key);
                $appElement->addChild("regvalue", $detectInfo->reg_value);
            }
        
            $appElement->addChild("switch", $installer->launch_args);
            $noUpdate = $app->noupdate === 1 ? "noupdate" : "setup";
            $appElement->addChild("type", $noUpdate);
            $appElement->addChild("version", $app->version);
        }
        
        $portableApps = PortableApp::orderBy('name')->get();
        $extractModes = ["folder", "single"];
        
        foreach ($portableApps as $portableApp) {
            $archive = $portableApp->archive;

            $appElement = $xml->addChild('portable');
            $appElement->addAttribute("name", $portableApp->name);
            $appElement->addChild("id", $portableApp->id);
            $appElement->addChild("arch", $archs[$portableApp->arch]);
        
            $dl = $archive->dl;
        
            if (strpos($dl, "%ver%") !== false) {
                $dl = str_replace("%ver%", $portableApp->version, $dl);
            }
            if (strpos($dl, "%verMajorMinor%") !== false) {
                $dl = str_replace("%verMajorMinor%", self::convertToMajorMinorVersion($portableApp->version), $dl);
            }
            if (strpos($dl, "%verDotless%") !== false) {
                $dl = str_replace("%verDotless%", self::convertToDotlessVersion($portableApp->version), $dl);
            }
        
            $appElement->addChild("dl", $dl);
        
            $appElement->addChild("hasChangelog", isset($portableApp->release_notes_url) ? 1 : 0);
            $appElement->addChild("hasDescription", isset($portableApp->website_url) ? 1 : 0);
            
            $appElement->addChild("extractmode", $extractModes[$archive->extract_mode]);
            $appElement->addChild("launch", $portableApp->launch_file);
            $appElement->addChild("version", $portableApp->version);
        }
        
        return response($xml->asXML(), 200)->header('Content-Type', 'application/xml');
    }

    private static function convertToDotlessVersion(string $version)
    {
        return str_replace(".", "", $version);
    }

    private static function convertToMajorMinorVersion(string $version)
    {
        $numbers = explode(".", $version, 3);
        $major = $numbers[0];
        $minor = $numbers[1];
        return "$major.$minor";
    }
}
