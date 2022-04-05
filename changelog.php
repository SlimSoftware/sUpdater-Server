<?php
if (isset($_GET["id"]) || isset($_GET["pid"])) {
    require __DIR__ . "/Database.php";
    $db = Database::getInstance();
    if (isset($_GET["id"])) {
        $stmt = $db->prepare("SELECT url FROM changelogs WHERE app_id = ?");
        $stmt->execute([$_GET["id"]]);
    } else {
        $stmt = $db->prepare("SELECT url FROM changelogs WHERE papp_id = ?");
        $stmt->execute([$_GET["pid"]]);
    }
    
    $url = $stmt->fetchColumn();
    if ($url != null) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <title>Redirecting...</title>
            <meta http-equiv="refresh" content="0;URL='<?= $url ?>'">
        </head>
        <body>           
        </body>
        </html>  
        <?php
        exit();
    }   
}

http_response_code(404);
?>