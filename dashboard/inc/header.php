<?php
session_start();
if (!isset($_SESSION["user"]) && basename($_SERVER['SCRIPT_NAME']) !== "login.php") {
    header("Location: login.php");
    exit();
}

include_once(__DIR__ . "\..\..\Config.php");
$dir = "/" . Config::SERVER_SUBDIR;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - sUpdater Server</title>
    <link rel="stylesheet" type="text/css" href="<?= "$dir/style.css" ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>