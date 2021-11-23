<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
}

require __DIR__ . "/../Database.php";
$db = Database::getInstance();

if (isset($_POST["id"]) &&
    isset($_POST["name"]) && 
    isset($_POST["version"]) &&
    isset($_POST["arch"]) &&
    (isset($_POST["regkey"]) &&
    isset($_POST["regvalue"]) ||
    isset($_POST["exepath"])) &&
    isset($_POST["dl"]) &&
    isset($_POST["launchargs"]))
{   
    $stmt = $db->prepare("UPDATE apps SET name = ?, version = ?, noupdate = ? WHERE id = ?");
    // If checkbox is not checked it will be null, we want it to be 1 in the db so manually set it
    $noUpdate = isset($_POST["noupdate"]) ? 1 : 0;
    $appEdited = $stmt->execute([$_POST["name"], $_POST["version"], $noUpdate, $_POST["id"]]);

    $stmt = $db->prepare("UPDATE detectinfo SET arch = ?, regkey = ?, regvalue = ?, exepath = ? WHERE app_id = ?");
    // Left blank form fields will be set to empty string, so we'll have to convert to null as we want null stored in the db
    $regkey = $_POST["regkey"] !== "" ? $_POST["regkey"] : null;
    $regvalue = $_POST["regvalue"] !== "" ? $_POST["regvalue"] : null;
    $exepath = $_POST["exepath"] !== "" ? $_POST["exepath"] : null;
    $detectInfoEdited = $stmt->execute([$_POST["arch"], $regkey, $regvalue, $exepath, $_POST["id"]]);

    $stmt = $db->prepare("UPDATE installers SET dl = ?, launch_args = ? WHERE app_id = ?");
    $installerEdited = $stmt->execute([$_POST["dl"], $_POST["launchargs"], $_POST["id"]]);

    if ($appEdited !== false && $detectInfoEdited !== false && $installerEdited !== false) {
        header("Location: apps.php"); 
        exit();
    } else {
        echo "<b>Could not edit app!</b>";
    }
}

$stmt = $db->prepare("SELECT name, version, noupdate FROM apps WHERE id = ?");
$stmt->execute([$_GET["id"]]);
$app = $stmt->fetch();

$stmt = $db->prepare("SELECT arch, regkey, regvalue, exepath FROM detectinfo WHERE app_id = ?");
$stmt->execute([$_GET["id"]]);
$detectInfo = $stmt->fetch();

$stmt = $db->prepare("SELECT dl, launch_args FROM installers WHERE app_id = ?");
$stmt->execute([$_GET["id"]]);
$installer = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit App - sUpdater Server</title>
</head>
<body>
    <h1>Edit App</h1>
    <p>Logged in as: <b><?= $_SESSION["user"] ?></b> <a href="logout.php">Log out</a></p>
    <a href="index.php">Dashboard Home</a>

    <?php
    include("inc/forms/appform.php");
    ?>
</body>
</html>