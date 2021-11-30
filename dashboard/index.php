<?php
$title = "Dashboard";
include("inc/header.php");
include("inc/nav.php");
?>

<div class="container">
    <h1>Dashboard</h1>
    <p>Logged in as: <b><?= $_SESSION["user"] ?></b> <a href="logout.php">Log out</a></p>
    <a href="apps.php">Manage apps</a>
</div>
</body>
</html>