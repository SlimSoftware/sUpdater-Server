<?php
if (isset($_GET["id"])) {
    require __DIR__ . "/Database.php";
    $db = Database::getInstance();
    $stmt = $db->prepare("SELECT text FROM changelogs WHERE app_id = ?");
    $stmt->execute([$_GET["id"]]);
    $apps = $stmt->fetchAll();
} else {
    http_response_code(404);
}
