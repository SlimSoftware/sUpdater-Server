<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
}

if (isset($_POST["name"]) && 
    isset($_POST["version"]))
{   
    require __DIR__ . "/../Database.php";
    $db = Database::getInstance();
    $stmt = $db->prepare("INSERT INTO apps (name, version, noupdate) VALUES (?, ?, ?)");
    $added = $stmt->execute([$_POST["name"], $_POST["version"], isset($_POST["noupdate"]) ? $_POST["noupdate"] : 0]);

    if ($added !== false) {
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

    <form method="POST">
        <p><b>General info</b></p>
        <p>Name: <input type="text" name="name" required /></p>
        <p>Version: <input type="text" name="version" required /></p>
        <p>Use this app's own updater to check for updates: <input type="checkbox" name="noupdate" /></p>
        <input type="submit" value="Add app" />
    </form>
</body>
</html>