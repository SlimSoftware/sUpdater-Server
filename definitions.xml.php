<?php
require __DIR__ . "/Database.php";
header("Content-Type: application/xml; charset=UTF-8");

$xml = new SimpleXMLElement('<defenitions version="1.0"></defenitions>');
$db = Database::getInstance();
$stmt = $db->prepare("SELECT a.name, a.version, a.noupdate, c.text AS changelog_text, d.text AS description_text, di.arch, di.regkey, di.regvalue, di.exepath, i.dl, i.launch_args FROM apps a LEFT JOIN changelogs c ON a.changelog_id = c.id LEFT JOIN descriptions d ON a.description_id = d.id JOIN detectinfo di ON a.id = di.app_id JOIN installers i ON a.id = i.app_id");   
$stmt->execute();
$apps = $stmt->fetchAll();
$archs = ["*", "x86", "x64"];

foreach ($apps as $app) {
    $appElement = $xml->addChild('app');
    $appElement->addAttribute("name", $app["name"]);
    $appElement->addChild("arch", $archs[$app["arch"]]);
    if (isset($app["changelog_text"])) {
        $appElement->addChild("changelog", $app["changelog_text"]);
    }
    if (isset($app["description_text"])) {
        $appElement->addChild("description", $app["description_text"]);
    }
    $appElement->addChild("dl", $app["dl"]);
    $appElement->addChild("exepath", $app["exepath"]);
    $appElement->addChild("regkey", $app["regkey"]);
    $appElement->addChild("regvalue", $app["regvalue"]);
    $appElement->addChild("switch", $app["launch_args"]);
    $noUpdate = $app["noupdate"] === "1" ? "noupdate" : "setup";
    $appElement->addChild("type", $noUpdate);
    $appElement->addChild("version", $app["version"]);
}

$stmt = $db->prepare("SELECT p.name, p.version, p.arch, c.text AS changelog_text, d.text AS description_text, a.dl, a.extractmode, a.launchfile FROM portableapps p LEFT JOIN changelogs c ON p.changelog_id = c.id LEFT JOIN descriptions d ON p.description_id = d.id JOIN archives a ON a.papp_id = p.id");
$stmt->execute();
$portableApps = $stmt->fetchAll();
$extractModes = ["folder", "single"];

foreach ($portableApps as $app) {
    $appElement = $xml->addChild('portable');
    $appElement->addAttribute("name", $app["name"]);
    $appElement->addChild("arch", $archs[$app["arch"]]);
    if (isset($app["changelog_text"])) {
        $appElement->addChild("changelog", $app["changelog_text"]);
    }
    if (isset($app["description_text"])) {
        $appElement->addChild("description", $app["description_text"]);
    }
    $appElement->addChild("dl", $app["dl"]);
    $appElement->addChild("extractmode", $extractModes[$app["extractmode"]]);
    $appElement->addChild("launch", $app["launchfile"]);
    $appElement->addChild("version", $app["version"]);
}

echo $xml->asXML();