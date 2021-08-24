<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
}

require __DIR__ . "/../Database.php";
$db = Database::getInstance();
$stmt = $db->prepare("SELECT id, name, version FROM apps");
$stmt->execute();
$apps = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apps - sUpdater Server</title>
    <style>
        table {
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #eee;
        }
    </style>
</head>
<body>
    <h1>Apps</h1>
    <p>Logged in as: <b><?= $_SESSION["user"] ?></b> <a href="logout.php">Log out</a></p>
    <a href="index.php">Dashboard Home</a>

    <div style="margin-top: 10px;">
        <?php
        if (count($apps) === 0):
            echo "<p><b>No apps available</b></p>";
        else:
        ?>
        <table>
            <tr>
                <th>Name</th>
                <th>Version</th>
                <th>Edit</th>
            </tr>
            <?php
            foreach ($apps as $app): ?>
                <tr>
                    <td><?= $app["name"] ?></td>
                    <td><?= $app["version"] ?></td>
                    <td><a href="editapp?id=<?= $app["id"] ?>">Edit</a></td>
                </tr>
                <?php 
            endforeach; endif;?>
        </table>
        <p><a href="addapp.php">Add new app</a></p>
    </div>
</body>
</html>