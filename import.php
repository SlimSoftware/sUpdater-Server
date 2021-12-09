<?php
require __DIR__ . "/Database.php";
$xmlPath = "definitions.xml";

if (file_exists($xmlPath)) {
    $xml = simplexml_load_file($xmlPath);
    $db = Database::getInstance();
    $archs = ["*", "x86", "x64"];

    foreach ($xml->app as $app) {
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
            }
    
            if ($descriptionId != "") {
                $stmt = $db->prepare("UPDATE descriptions SET text = ? WHERE id = ?");   
                $updated = $stmt->execute([$app->description, $descriptionId]);
                
                if ($updated)
                    echo "Description for $appName updated in db<br/>";
                else 
                    echo "Failed to update description for $appName in db<br/>";
            } else {
                $stmt = $db->prepare("INSERT INTO descriptions (text) VALUES (?)");   
                $added = $stmt->execute([$app->description]);
                
                if ($added) {
                    $descriptionId = $db->lastInsertId();
                    echo "Description for $appName added to db<br/>";
                }
                else {
                    echo "Failed to add description for $appName to db<br/>";
                }
            }
        }

        if ($appId != "") {
            $stmt = $db->prepare("UPDATE apps SET name = ?, version = ?, noupdate = ?, changelog_id = ?, description_id = ? WHERE id = ?");   
            $updated = $stmt->execute([$appName, $app->version, $app->type == "noupdate" ? 1 : 0, $changelogId, $descriptionId, $appId]);
            
            if ($updated)
                echo "App $appName updated in db<br/>";
            else 
                echo "Failed to update app $appName in db<br/>";
        } else {
            $stmt = $db->prepare("INSERT INTO apps (name, version, noupdate, changelog_id, description_id) VALUES (?, ?, ?, ?, ?)");   
            $added = $stmt->execute([$appName, $app->version, $app->type == "noupdate" ? 1 : 0, $changelogId, $descriptionId]);
            $appId = $db->lastInsertId();
            
            if ($added)
                echo "App $appName added to db<br/>";
            else 
                echo "Failed to add app $appName to db (desc: $descriptionId)<br/>";
        }

        $stmt = $db->prepare("SELECT id FROM detectinfo WHERE app_id = ?");   
        $stmt->execute([$appId]);
        $detectInfoId = $stmt->fetchColumn();

        $regKey = $app->regkey != "" ? $app->regkey : null;
        $regValue = $app->regvalue != "" ? $app->regvalue : null;
        $exePath = $app->exePath != "" ? $app->exePath : null;
        
        if ($detectInfoId != "") {
            $stmt = $db->prepare("UPDATE detectinfo SET app_id = ?, arch = ?, regkey = ?, regvalue = ?, exepath = ? WHERE id = ?");   
            $updated = $stmt->execute([$appId, array_search($app->arch, $archs), $regKey, $regValue, $exePath, $detectInfoId]);
            
            if ($updated)
                echo "Detectinfo for $appName updated in db<br/>";
            else 
                echo "Failed to update detectinfo for $appName in db<br/>";
        } else {
            $stmt = $db->prepare("INSERT INTO detectinfo (app_id, arch, regkey, regvalue, exepath) VALUES (?, ?, ?, ?, ?)");   
            $added = $stmt->execute([$appId, array_search($app->arch, $archs), $regKey, $regValue, $exePath]);
            
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
        $appName = $pApp["name"];
        $stmt = $db->prepare("SELECT id FROM portableapps WHERE name = ?");   
        $stmt->execute([$appName]);
        $appId = $stmt->fetchColumn();
        $changelogId = null;
        $descriptionId = null;

        if ($pApp->changelog) {
            if ($appId != "") {
                $stmt = $db->prepare("SELECT changelog_id FROM portableapps WHERE id = ?");   
                $stmt->execute([$appId]);
                $changelogId = $stmt->fetchColumn();
            }
    
            if ($changelogId != "") {
                $stmt = $db->prepare("UPDATE changelogs SET text = ? WHERE id = ?");   
                $updated = $stmt->execute([$pApp->changelog, $changelogId]);
                
                if ($updated)
                    echo "Changelog for Portable App $appName updated in db<br/>";
                else 
                    echo "Failed to update changelog for Portable App $appName in db<br/>";
            } else {
                $stmt = $db->prepare("INSERT INTO changelogs (text) VALUES (?)");   
                $added = $stmt->execute([$pApp->changelog]);
                
                if ($added) {
                    $changelogId = $db->lastInsertId();
                    echo "Changelog for Portable App $appName added to db<br/>";
                }
                else {
                    echo "Failed to add changelog for Portable App $appName to db<br/>";
                }
            }
        }

        if ($pApp->description) {
            if ($appId != "") {
                $stmt = $db->prepare("SELECT description_id FROM portableapps WHERE id = ?");   
                $stmt->execute([$appId]);
                $descriptionId = $stmt->fetchColumn();
            }
    
            if ($descriptionId != "") {
                $stmt = $db->prepare("UPDATE descriptions SET text = ? WHERE id = ?");   
                $updated = $stmt->execute([$pApp->description, $descriptionId]);
                
                if ($updated)
                    echo "Description for Portable App $appName updated in db<br/>";
                else 
                    echo "Failed to update description for Portable App $appName in db<br/>";
            } else {
                $stmt = $db->prepare("INSERT INTO descriptions (text) VALUES (?)");   
                $added = $stmt->execute([$pApp->description]);
                
                if ($added) {
                    $descriptionId = $db->lastInsertId();
                    echo "Description for Portable App $appName added to db<br/>";
                }
                else {
                    echo "Failed to add description for Portable App $appName to db<br/>";
                }
            }
        }
        
        if ($appId != "") {
            $stmt = $db->prepare("UPDATE portableapps SET name = ?, version = ?, arch = ?, changelog_id = ?, description_id = ? WHERE id = ?");   
            $updated = $stmt->execute([$appName, $pApp->version, array_search($pApp->arch, $archs), $changelogId, $descriptionId, $appId]);
            
            if ($updated)
                echo "Portable App $appName updated in db<br/>";
            else 
                echo "Failed to update Portable App $appName in db<br/>";
        } else {
            $stmt = $db->prepare("INSERT INTO portableapps (name, version, arch, changelog_id, description_id) VALUES (?, ?, ?, ?, ?)");   
            $added = $stmt->execute([$appName, $pApp->version, array_search($pApp->arch, $archs), $changelogId, $descriptionId]);
            $appId = $db->lastInsertId();
            
            if ($added)
                echo "Portable App $appName added to db<br/>";
            else 
                echo "Failed to add Portable App $appName to db<br/>";
        }

        $stmt = $db->prepare("SELECT id FROM archives WHERE papp_id = ?");   
        $stmt->execute([$appId]);
        $archiveId = $stmt->fetchColumn();
        $extractModes = ["folder", "single"];
        
        if ($archiveId != "") {
            $stmt = $db->prepare("UPDATE archives SET papp_id = ?, dl = ?, extractmode = ?, launchfile = ? WHERE id = ?");   
            $updated = $stmt->execute([$appId, $pApp->dl, array_search($pApp->extractmode, $extractModes), $pApp->launch, $appId]);
            
            if ($updated)
                echo "Archive for $appName updated in db<br/><br/>";
            else 
                echo "Failed to update archive for $appName in db<br/><br/>";
        } else {
            $stmt = $db->prepare("INSERT INTO archives (papp_id, dl, extractmode, launchfile) VALUES (?, ?, ?, ?)");   
            $added = $stmt->execute([$appId, $pApp->dl, array_search($pApp->extractmode, $extractModes), $pApp->launch]);
            
            if ($added)
                echo "Archive for $appName added to db<br/><br/>";
            else 
                echo "Failed to add archive for $appName to db<br/><br/>";
        }
    }
} else {
    exit("Failed to open $xmlPath");
}