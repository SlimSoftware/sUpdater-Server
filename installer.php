<?php
require __DIR__ . "/controllers/InstallerController.php";
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (isset($_GET["ids"])) {
        $result = InstallerController::getInstallersWithIds($_GET["ids"]); 
    } else if (isset($_GET["nids"])) {
        $result = InstallerController::getInstallersWithoutIds($_GET["nids"]); 
    } else if (isset($_GET["id"])) {
        $result = InstallerController::getInstaller($_GET["id"]); 
    }

    if ($result !== null) {
        echo json_encode($apps);
        http_response_code(200);
    } else {
        http_response_code(404);
    }
} else {
    http_response_code(404);
}