<?php
if (isset($_POST["user"]) && isset($_POST["pass"])) {
    require __DIR__ . "/../Database.php";
    $db = Database::getInstance();
    $stmt = $db->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->execute([$_POST["user"]]);
    $hashedPassword = $stmt->fetch(PDO::FETCH_COLUMN);

    if ($hashedPassword !== false) {
        if (password_verify($_POST["pass"], $hashedPassword)) {
            session_start();
            $_SESSION["user"] = filter_var($_POST["user"]);
            header("Location: index.php");
        }
    }
    
    echo "Username or password incorrect!<br/>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In - sUpdater Server</title>
</head>
<body>
    <h1>Log In</h1>
    <form method="POST">
        <p>Username: <input type="text" name="user" /><br />
        Password: <input type="password" name="pass" /></p>
        <input type="submit" value="Login" />
    </form>
</body>
</html>