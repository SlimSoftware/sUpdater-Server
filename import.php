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
        $changelogId = null;
        $descriptionId = null;

        if ($app->changelog) {
            if ($appId != "") {
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
            if ($appId != "") {
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

        if ($appId != "") {
            $stmt = $db->prepare("UPDATE apps SET name = ?, version = ?, noupdate = ?, changelog_id = ?, description_id = ? WHERE id = ?");   
            $updated = $stmt->execute([$appName, $app->version, $app->type === "noupdate", $changelogId, $descriptionId, $appId]);
            
            if ($updated)
                echo "App $appName updated in db<br/>";
            else 
                echo "Failed to update app $appName in db<br/>";
        } else {
            $stmt = $db->prepare("INSERT INTO apps (name, version, noupdate, changelog_id, description_id) VALUES (?, ?, ?, ?, ?)");   
            $added = $stmt->execute([$appName, $app->version, $app->type === "noupdate", null, null]);
            $appId = $db->lastInsertId();
            
            if ($added)
                echo "App $appName added to db<br/>";
            else 
                echo "Failed to add app $appName to db<br/>";
        }

        $stmt = $db->prepare("SELECT id FROM detectinfo WHERE app_id = ?");   
        $stmt->execute([$appId]);
        $detectInfoId = $stmt->fetchColumn();
        $archs = ["*", "x86", "x64"];
        
        if ($detectInfoId != "") {
            $stmt = $db->prepare("UPDATE detectinfo SET app_id = ?, arch = ?, regkey = ?, regvalue = ?, exepath = ? WHERE id = ?");   
            $updated = $stmt->execute([$appId, array_search($app->arch, $archs), $app->regkey, $app->regvalue, $app->exepath, $detectInfoId]);
            
            if ($updated)
                echo "Detectinfo for $appName updated in db<br/>";
            else 
                echo "Failed to update detectinfo for $appName in db<br/>";
        } else {
            $stmt = $db->prepare("INSERT INTO detectinfo (app_id, arch, regkey, regvalue, exepath) VALUES (?, ?, ?, ?, ?)");   
            $added = $stmt->execute([$appId, array_search($app->arch, $archs), $app->regkey, $app->regvalue, $app->exepath]);
            
            if ($added)
                echo "Detectinfo for $appName added to db<br/>";
            else 
                echo "Failed to add detectinfo for $appName to db<br/>";
        }

        $stmt = $db->prepare("SELECT id FROM installers WHERE app_id = ?");   
        $stmt->execute([$appId]);
        $installerId = $stmt->fetchColumn();
        
        if ($installerId != "") {
            $stmt = $db->prepare("UPDATE installers SET app_id = ?, dl = ?, launch_args = ? WHERE id = ?");   
            $updated = $stmt->execute([$appId, $app->dl, $app->switch, $appId]);
            
            if ($updated)
                echo "Installer for $appName updated in db<br/><br/>";
            else 
                echo "Failed to update installer for $appName in db<br/><br/>";
        } else {
            $stmt = $db->prepare("INSERT INTO installers (app_id, dl, launch_args) VALUES (?, ?, ?)");   
            $added = $stmt->execute([$appId, $app->dl, $app->switch]);
            
            if ($added)
                echo "Installer for $appName added to db<br/><br/>";
            else 
                echo "Failed to add installer for $appName to db<br/><br/>";
        }
    }

    foreach ($xml->portable as $pApp) {
        //print("<pre>".print_r($pApp,true)."</pre>");

        
    }
} else {
    die("Failed to open $xmlPath");
}