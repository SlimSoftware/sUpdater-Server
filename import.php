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
        $appExists = $stmt->rowCount() > 0;
        $changelogId = null;
        $descriptionId = null;

        if ($app->changelog) {
            if ($appExists) {
                $stmt = $db->prepare("SELECT changelog_id FROM apps WHERE id = ?");   
                $stmt->execute([$appId]);
                $changelogId = $stmt->fetchColumn();
            } else {
                $changelogExists = false;
            }
    
            if ($changelogId != "") {
                $stmt = $db->prepare("UPDATE changelogs SET text = ? WHERE id = ?");   
                $updated = $stmt->execute([$app->changelog, $changelogId]);
                
                if ($updated)
                    echo "Changelog for $appName updated in db<br/>";
                else 
                    echo "Failed to update changelog for $appName in db<br/>";
            } else {
                $stmt = $db->prepare("INSERT INTO changelogs (text) VALUES (?)");   
                $added = $stmt->execute([$app->changelog]);
                
                if ($added) {
                    $changelogId = $db->lastInsertId();
                    echo "Changelog for $appName added to db<br/>";
                }
                else {
                    echo "Failed to add changelog for $appName to db<br/>";
                }
            }
        }

        if ($app->description) {
            if ($appExists) {
                $stmt = $db->prepare("SELECT description_id FROM apps WHERE id = ?");   
                $stmt->execute([$appId]);
                $descriptionId = $stmt->fetchColumn();
                $descriptionExists = $stmt->rowCount() > 0;
            } else {
                $descriptionExists = false;
            }
    
            if ($descriptionExists) {
                $stmt = $db->prepare("UPDATE descriptions SET text = ? WHERE id = ?");   
                $updated = $stmt->execute([$app->changelog, $changelogId]);
                
                if ($updated)
                    echo "Description for $appName updated in db<br/>";
                else 
                    echo "Failed to update description for $appName in db<br/>";
            } else {
                $stmt = $db->prepare("INSERT INTO descriptions (text) VALUES (?)");   
                $added = $stmt->execute([$app->changelog]);
                
                if ($added) {
                    $changelogId = $db->lastInsertId();
                    echo "Description for $appName added to db<br/>";
                }
                else {
                    echo "Failed to add description for $appName to db<br/>";
                }
            }
        }

        if ($appExists) {
            $stmt = $db->prepare("UPDATE apps SET name = ?, version = ?, noupdate = ?, changelog_id = ?, description_id = ? WHERE id = ?");   
            $updated = $stmt->execute([$appName, $app->version, $app->type === "noupdate", $changelogId, $descriptionId, $appId]);
            
            if ($updated)
                echo "App $appName updated in db<br/>";
            else 
                echo "Failed to update app $appName in db<br/>";
        } else {
            $stmt = $db->prepare("INSERT INTO apps (name, version, noupdate, changelog_id, description_id) VALUES (?, ?, ?, ?, ?)");   
            $added = $stmt->execute([$appName, $app->version, $app->type === "noupdate", null, null]);
            
            if ($added)
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