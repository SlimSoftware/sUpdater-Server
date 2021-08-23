<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - sUpdater Server</title>
</head>
<body>
    <h1>Dashboard</h1>
    <p>Logged in as: <b><?= $_SESSION["user"] ?></b> <a href="logout.php">Log out</a></p>
    <a href="apps.php">Manage apps</a>
</body>
</html>