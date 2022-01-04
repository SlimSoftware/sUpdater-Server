<?php
$title = "Apps";
include("inc/header.php");
include("inc/nav.php");

require __DIR__ . "/../Database.php";
$db = Database::getInstance();
$stmt = $db->prepare("SELECT id, name, version FROM apps ORDER BY name");
$stmt->execute();
$apps = $stmt->fetchAll();
?>

<div class="container">
    <h1>Apps</h1><a class="btn btn-primary" href="addapp.php">Add new</a>
    <div class="mt-2">
        <?php
        if (count($apps) === 0):
            echo "<p><b>No apps available</b></p>";
        else:
        ?>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Version</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($apps as $app): ?>
                    <tr>
                        <td class="align-middle"><?= $app["name"] ?></td>
                        <td class="align-middle"><?= $app["version"] ?></td>
                        <td><a class="btn btn-primary" href="editapp.php?id=<?= $app["id"] ?>">Edit</a></td>
                    </tr>
                    <?php 
                endforeach; endif;
                ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>