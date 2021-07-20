<?php
require __DIR__ . "/controllers/DetectInfoController.php";
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $info = DetectInfoController::getDetectInfo();      
    if ($info !== null) {
        echo json_encode($info);
        http_response_code(200);
    }
} else {
    http_response_code(404);
}