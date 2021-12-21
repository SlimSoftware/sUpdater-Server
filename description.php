<?php
if (isset($_GET["id"]) || isset($_GET["pid"])) {
    require __DIR__ . "/Database.php";
    $db = Database::getInstance();
    if (isset($_GET["id"])) {
        $stmt = $db->prepare("SELECT url FROM descriptions WHERE app_id = ?");
        $stmt->execute([$_GET["id"]]);
    } else {
        $stmt = $db->prepare("SELECT url FROM descriptions WHERE papp_id = ?");
        $stmt->execute([$_GET["pid"]]);
    }
    
    $url = $stmt->fetchColumn();
    if ($url != null) {
        header("Location: $url");
        exit();
    }   
}

http_response_code(404);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirecting...</title>
</head>
<body>
    
</body>
</html>