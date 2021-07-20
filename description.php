<?php
require __DIR__ . "/controllers/DescriptionController.php";
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (isset($_GET["id"])) {
        $description = DescriptionController::getDescription($_GET["id"]);      
        if ($description !== null) {
            echo json_encode($description);
            http_response_code(200);
        }
    } else {
        http_response_code(404);
    }
} else {
    http_response_code(404);
}