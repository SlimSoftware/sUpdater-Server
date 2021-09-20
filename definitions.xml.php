<?php
require __DIR__ . "/Database.php";
$xml = new SimpleXMLElement('<defenitions version="1.0"></defenitions>');

$db = Database::getInstance();
$stmt = $db->prepare("SELECT a.*, c.text AS changelog_text, d.text AS description_text, di.*, i.* FROM apps a LEFT JOIN changelogs c ON a.changelog_id = c.id LEFT JOIN descriptions d ON a.description_id = d.id JOIN detectinfo di ON a.id = di.app_id JOIN installers i ON a.id = i.app_id");
if ($stmt !== false) {
    $stmt->execute();
    header("Content-Type: application/xml; charset=UTF-8");

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

    echo $xml->asXML();
} else {
    echo http_response_code(500);
}