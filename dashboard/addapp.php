<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
}

if (isset($_POST["name"]) && 
    isset($_POST["version"]) &&
    isset($_POST["arch"]) &&
    (isset($_POST["regkey"]) &&
    isset($_POST["regvalue"]) ||
    isset($_POST["exepath"])) &&
    isset($_POST["dl"]) &&
    isset($_POST["launchargs"]))
{   
    require __DIR__ . "/../Database.php";
    $db = Database::getInstance();
    $stmt = $db->prepare("INSERT INTO apps (name, version, noupdate) VALUES (?, ?, ?)");
    // If checkbox is not checked it will be null, we want it to be 1 in the db so manually set it
    $noUpdate = isset($_POST["noupdate"]) ? 1 : 0;
    $appAdded = $stmt->execute([$_POST["name"], $_POST["version"], $noUpdate]);
    $appId = $db->lastInsertId();

    $stmt = $db->prepare("INSERT INTO detectinfo (app_id, arch, regkey, regvalue, exepath) VALUES (?, ?, ?, ?, ?)");
    // Left blank form fields will be set to empty string, so we'll have to convert to null as we want null stored in the db
    $regkey = $_POST["regkey"] !== "" ? $_POST["regkey"] : null;
    $regvalue = $_POST["regvalue"] !== "" ? $_POST["regvalue"] : null;
    $exepath = $_POST["exepath"] !== "" ? $_POST["exepath"] : null;
    $detectInfoAdded = $stmt->execute([$appId, $_POST["arch"], $regkey, $regvalue, $exepath]);

    $stmt = $db->prepare("INSERT INTO installers (app_id, dl, launch_args) VALUES (?, ?, ?)");
    $installerAdded = $stmt->execute([$appId, $_POST["dl"], $_POST["launchargs"]]);

    if ($appAdded !== false && $detectInfoAdded !== false && $installerAdded !== false) {
        header("Location: apps.php");
    } else {
        echo "<b>Could not add app!</b>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add App - sUpdater Server</title>
</head>
<body>
    <h1>Add App</h1>
    <p>Logged in as: <b><?= $_SESSION["user"] ?></b> <a href="logout.php">Log out</a></p>
    <a href="index.php">Dashboard Home</a>

    <?php
    include("inc/forms/appform.php");
    ?>
</body>
</html>