<?php
session_start();
$pageName = basename($_SERVER['SCRIPT_NAME']);

if (!isset($_SESSION["user"]) && $pageName !== "login.php" && $pageName !== "install.php") {
    header("Location: login.php");
    exit();
}

include_once(__DIR__ . "/../../Config.php");
$dir = "/" . Config::SERVER_SUBDIR;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - sUpdater Server</title>
    <link rel="stylesheet" type="text/css" href="<?= "$dir/dashboard/style.css" ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="shortcut icon" href="<?= "$dir/dashboard/img/favicon/favicon.ico" ?>">
	<link rel="icon" sizes="16x16 32x32 64x64" href="<?= "$dir/dashboard/img/favicon/favicon.ico" ?> ">
	<link rel="icon" type="image/png" sizes="196x196" href="<?= "$dir/dashboard/img/favicon/favicon-192.png" ?>">
	<link rel="icon" type="image/png" sizes="160x160" href="<?= "$dir/dashboard/img/favicon/favicon-160.png" ?>">
	<link rel="icon" type="image/png" sizes="96x96" href="<?= "$dir ../img/favicon/favicon-96.png" ?>">
	<link rel="icon" type="image/png" sizes="64x64" href="<?= "$dir/dashboard/img/favicon/favicon-64.png" ?>">
	<link rel="icon" type="image/png" sizes="32x32" href="<?= "$dir/dashboard/img/favicon/favicon-32.png" ?>">
	<link rel="icon" type="image/png" sizes="16x16" href="<?= "$dir/dashboard/img/favicon/favicon-16.png" ?>">
	<link rel="apple-touch-icon" href="<?= "$dir/dashboard/img/favicon/favicon-57.png" ?>">
	<link rel="apple-touch-icon" sizes="114x114" href="<?= "$dir/dashboard/img/favicon/favicon-114.png" ?>">
	<link rel="apple-touch-icon" sizes="72x72" href="<?= "$dir/dashboard/img/favicon/favicon-72.png" ?>">
	<link rel="apple-touch-icon" sizes="144x144" href="<?= "$dir/dashboard/img/favicon/favicon-144.png" ?>">
	<link rel="apple-touch-icon" sizes="60x60" href="<?= "$dir/dashboard/img/favicon/favicon-60.png" ?>">
	<link rel="apple-touch-icon" sizes="120x120" href="<?= "$dir/dashboard/img/favicon/favicon-120.png" ?>">
	<link rel="apple-touch-icon" sizes="76x76" href="<?= "$dir/dashboard/img/favicon/favicon-76.png" ?>">
	<link rel="apple-touch-icon" sizes="152x152" href="<?= "$dir/dashboard/img/favicon/favicon-152.png" ?>">
	<link rel="apple-touch-icon" sizes="180x180" href="<?= "$dir/dashboard/img/favicon/favicon-180.png" ?>">
	<meta name="msapplication-TileColor" content="#FFFFFF">
	<meta name="msapplication-TileImage" content="<?= "$dir/dashboard/img/favicon/favicon-144.png" ?>">
	<meta name="msapplication-config" content="<?= "$dir/dashboard/imgbrowserconfig.xml" ?>">
</head>
<body>