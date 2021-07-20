<?php
require __DIR__ . "/controllers/ChangelogController.php";
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (isset($_GET["id"])) {
        $changelog = ChangelogController::getChangelog($_GET["id"]);      
        if ($changelog !== null) {
            echo json_encode($changelog);
            http_response_code(200);
        }
    } else {
        http_response_code(404);
    }
} else {
    http_response_code(404);
}