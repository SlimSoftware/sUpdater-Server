<?php
require __DIR__ . "/controllers/AppController.php";
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (isset($_GET["id"])) {
        $result = AppController::getAppsWithIds($_GET["id"]); 
    } else if (isset($_GET["ids"])) {
        $result = AppController::getAppsWithIds($_GET["ids"]); 
    } else if (isset($_GET["nids"])) {
        $result = AppController::getAppsWithoutIds($_GET["nids"]); 
    } else {
        $result = AppController::getApps();
    }  

    if ($result !== null) {
        echo json_encode($result);
        http_response_code(200);
    } else {
        http_response_code(404);
    }
} else {
    http_response_code(404);
}