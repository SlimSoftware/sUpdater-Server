<?php
require __DIR__ . "/Database.php";
require_once(__DIR__ . "/Utilities.php");
header("Content-Type: application/xml; charset=UTF-8");

$xml = new SimpleXMLElement('<defenitions version="1.0"></defenitions>');
$db = Database::getInstance();
$stmt = $db->prepare("SELECT a.id, a.name, a.version, a.noupdate, c.id AS changelog_id, d.id AS description_id, di.arch, di.regkey, di.regvalue, di.exepath, i.dl, i.launch_args FROM apps a LEFT JOIN changelogs c ON c.app_id = a.id LEFT JOIN descriptions d ON d.app_id = a.id JOIN detectinfo di ON a.id = di.app_id JOIN installers i ON a.id = i.app_id ORDER BY name");   
$stmt->execute();
$apps = $stmt->fetchAll();
$archs = ["*", "x86", "x64"];

foreach ($apps as $app) {
    $appElement = $xml->addChild('app');
    $appElement->addAttribute("name", $app["name"]);
    $appElement->addChild("id", $app["id"]);
    $appElement->addChild("arch", $archs[$app["arch"]]);

    $dl = $app["dl"];

    if (strpos($dl, "%ver%") !== false) {
        $dl = str_replace("%ver%", $app["version"], $dl);
    }
    if (strpos($dl, "%verMajorMinor%") !== false) {
        $dl = str_replace("%verMajorMinor%", Utilities::convertToMajorMinorVersion($app["version"]), $dl);
    }
    if (strpos($dl, "%verDotless%") !== false) {
        $dl = str_replace("%verDotless%", Utilities::convertToDotlessVersion($app["version"]), $dl);
    }

    $appElement->addChild("dl", $dl);
    
    if ($app["exepath"]) {
        $appElement->addChild("exePath", $app["exepath"]);
    }

    $appElement->addChild("hasChangelog", isset($app["changelog_id"]) ? 1 : 0);
    $appElement->addChild("hasWebsite", isset($app["description_id"]) ? 1 : 0);

    if ($app["regkey"]) {
        $appElement->addChild("regkey", $app["regkey"]);
        $appElement->addChild("regvalue", $app["regvalue"]);
    }

    $appElement->addChild("switch", $app["launch_args"]);
    $noUpdate = $app["noupdate"] === 1 ? "noupdate" : "setup";
    $appElement->addChild("type", $noUpdate);
    $appElement->addChild("version", $app["version"]);
}

$stmt = $db->prepare("SELECT p.id, p.name, p.version, p.arch, c.id AS changelog_id, d.id AS description_id, a.dl, a.extractmode, a.launchfile FROM portableapps p LEFT JOIN changelogs c ON c.papp_id = p.id LEFT JOIN descriptions d ON d.papp_id = p.id JOIN archives a ON a.papp_id = p.id ORDER BY name");
$stmt->execute();
$portableApps = $stmt->fetchAll();
$extractModes = ["folder", "single"];

foreach ($portableApps as $app) {
    $appElement = $xml->addChild('portable');
    $appElement->addAttribute("name", $app["name"]);
    $appElement->addChild("id", $app["id"]);
    $appElement->addChild("arch", $archs[$app["arch"]]);

    $dl = $app["dl"];

    if (strpos($dl, "%ver%") !== false) {
        $dl = str_replace("%ver%", $app["version"], $dl);
    }
    if (strpos($dl, "%verMajorMinor%") !== false) {
        $dl = str_replace("%verMajorMinor%", Utilities::convertToMajorMinorVersion($app["version"]), $dl);
    }
    if (strpos($dl, "%verDotless%") !== false) {
        $dl = str_replace("%verDotless%", Utilities::convertToDotlessVersion($app["version"]), $dl);
    }

    $appElement->addChild("dl", $dl);

    $appElement->addChild("hasChangelog", isset($app["changelog_id"]) ? 1 : 0);
    $appElement->addChild("hasDescription", isset($app["description_id"]) ? 1 : 0);
    
    $appElement->addChild("extractmode", $extractModes[$app["extractmode"]]);
    $appElement->addChild("launch", $app["launchfile"]);
    $appElement->addChild("version", $app["version"]);
}

echo $xml->asXML();