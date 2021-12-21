<?php
$title = "Import";
include("inc/header.php");
include("inc/nav.php");
?>

<div class="container">
    <h1>Import</h1>
    <p>
        <?php
        if (isset($_FILES["file"])) {
            require __DIR__ . "\..\Database.php";
            $xmlPath = $_FILES["file"]["tmp_name"];
        
            if (file_exists($xmlPath)) {
                $xml = simplexml_load_file($xmlPath);
                $db = Database::getInstance();
                $archs = ["*", "x86", "x64"];
        
                foreach ($xml->app as $app) {
                    $appName = $app["name"];
                    $stmt = $db->prepare("SELECT id FROM apps WHERE name = ?");   
                    $stmt->execute([$appName]);
                    $appId = $stmt->fetchColumn();
        
                    if ($appId != "") {
                        $stmt = $db->prepare("UPDATE apps SET name = ?, version = ?, noupdate = ? WHERE id = ?");   
                        $updated = $stmt->execute([$appName, $app->version, $app->type == "noupdate" ? 1 : 0, $appId]);
                        
                        if ($updated)
                            echo "App $appName updated in db<br/>";
                        else 
                            echo "Failed to update app $appName in db<br/>";
                    } else {
                        $stmt = $db->prepare("INSERT INTO apps (name, version, noupdate) VALUES (?, ?, ?)");   
                        $added = $stmt->execute([$appName, $app->version, $app->type == "noupdate" ? 1 : 0]);
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
                    
                    if ($appId != "") {
                        $stmt = $db->prepare("UPDATE portableapps SET name = ?, version = ?, arch = ? WHERE id = ?");   
                        $updated = $stmt->execute([$appName, $pApp->version, array_search($pApp->arch, $archs), $appId]);
                        
                        if ($updated)
                            echo "Portable App $appName updated in db<br/>";
                        else 
                            echo "Failed to update Portable App $appName in db<br/>";
                    } else {
                        $stmt = $db->prepare("INSERT INTO portableapps (name, version, arch) VALUES (?, ?, ?)");   
                        $added = $stmt->execute([$appName, $pApp->version, array_search($pApp->arch, $archs)]);
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
                exit("Failed to open file");
            }
        }
        ?>
    </p>
    <?php
    if (!isset($_FILES["file"])):
    ?>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group col-md-4">
            <label for="fileUpload">Select XML file to import</label>
            <input class="form-control" type="file" name="file" id="fileUpload">
        </div>
        <input class="btn btn-primary" type="submit" value="Import" name="submit">
    </form>
    <?php
    endif;
    ?>
</div>

<?php
include("inc/scripts.php");
?>
</body>
</html>