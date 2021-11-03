<?php
require __DIR__ . "/Database.php";
$xmlPath = "definitions.xml";

if (file_exists($xmlPath)) {
    $xml = simplexml_load_file($xmlPath);
    //print("<pre>".print_r($xml,true)."</pre>");
    $db = Database::getInstance();

    foreach ($xml->app as $app) {
        //print("<pre>".print_r($app,true)."</pre>");
        $appName = $app["name"];
        $stmt = $db->prepare("SELECT id FROM apps WHERE name = ?");   
        $stmt->execute([$appName]);
        $appId = $stmt->fetchColumn();
        $appExists = $appId !== null;

        if ($app->changelog) {
            if ($appExists) {
                $stmt = $db->prepare("SELECT changelog_id FROM apps WHERE id = ?");   
                $stmt->execute([$appId]);
                $changelogId = $stmt->fetchColumn();
                $changelogExists = $changelogId !== null;
            } else {
                $changelogExists = false;
            }
    
            if ($changelogExists) {
                $stmt = $db->prepare("UPDATE changelogs SET text = ?");   
                $appUpdated = $stmt->execute([$app->changelog, $appId]);
                
                if ($appUpdated)
                    echo "Changelog for $appName updated in db<br/>";
                else 
                    echo "Failed to update changelog for $appName in db<br/>";
            } else {
                $stmt = $db->prepare("INSERT INTO changelogs (text) VALUES (?)");   
                $appAdded = $stmt->execute([$app->changelog]);
                
                if ($appAdded)
                    echo "Changelog for $appName added to db<br/>";
                else 
                    echo "Failed to add changelog for $appName to db<br/>";
            }
        }

        if ($appExists) {
            $stmt = $db->prepare("UPDATE apps SET name = ?, version = ?, noupdate = ?, changelog_id = ?, description_id = ? WHERE id = ?");   
            $appUpdated = $stmt->execute([$appName, $app->version, $app->type === "noupdate", null, null, $appId]);
            
            if ($appUpdated)
                echo "App $appName updated in db<br/>";
            else 
                echo "Failed to update app $appName in db<br/>";
        } else {
            $stmt = $db->prepare("INSERT INTO apps (name, version, noupdate, changelog_id, description_id) VALUES (?, ?, ?, ?, ?)");   
            $appAdded = $stmt->execute([$appName, $app->version, $app->type === "noupdate", null, null]);
            
            if ($appAdded)
                echo "App $appName added to db<br/>";
            else 
                echo "Failed to add app $appName to db<br/>";
        }

    }

    foreach ($xml->portable as $pApp) {
        //print("<pre>".print_r($pApp,true)."</pre>");

        
    }
} else {
    die("Failed to open $xmlPath");
}