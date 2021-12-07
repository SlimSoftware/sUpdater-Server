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
            exit();
        }
    }
}

$title = "Log In";
include("inc/header.php");
include("inc/nav.php");
?>

<div class="container">
    <h1>Log In</h1>
    <?= isset($_POST["user"]) && isset($_POST["pass"]) ? '<b class="text-danger">Username or password incorrect!</b>' : "" ?>
    <form method="POST">
        <div class="form-group col-md-4">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="user" />
        </div>
        <div class="form-group col-md-4">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="pass" />
        </div>
        <input class="btn btn-primary" type="submit" value="Log In" />  
    </form>
</div>

<?php
include("inc/scripts.php");
?>
</body>
</html>