<?php
require __DIR__ . "/Database.php";

$db = Database::getInstance();

if (!isset($_POST["user"]) && !isset($_POST["pass"])) {
    $result = $db->query("SELECT count(*) FROM users");
    $userAmount = $result !== false ? $result->fetch(PDO::FETCH_COLUMN) : 0;

    if ($userAmount > 0) {
        header("Location: dashboard/login.php");
    } else if ($result === false) {
        // Apps table does not exist, so create all required tables
        $createStatments = [
            "changelogs" => "CREATE TABLE `changelogs` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `text` text DEFAULT NULL,
                `url` varchar(5000) DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
            "descriptions" => "CREATE TABLE `descriptions` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `text` text NOT NULL,
                `url` varchar(5000) NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
            "apps" => "CREATE TABLE `apps` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(200) NOT NULL,
                `version` varchar(50) NOT NULL,
                `noupdate` tinyint(1) NOT NULL DEFAULT 0,
                `changelog_id` int(11) DEFAULT NULL,
                `description_id` int(11) DEFAULT NULL,
                PRIMARY KEY (`id`),
                KEY `FK_apps_changelogs` (`changelog_id`),
                KEY `FK_apps_descriptions` (`description_id`),
                CONSTRAINT `FK_apps_changelogs` FOREIGN KEY (`changelog_id`) REFERENCES `changelogs` (`id`),
                CONSTRAINT `FK_apps_descriptions` FOREIGN KEY (`description_id`) REFERENCES `descriptions` (`id`)
              ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4",
            "detectinfo" => "CREATE TABLE `detectinfo` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `app_id` int(11) NOT NULL,
                `arch` tinyint(4) NOT NULL,
                `regkey` varchar(1000) DEFAULT NULL,
                `regvalue` varchar(50) DEFAULT NULL,
                `exepath` varchar(1000) DEFAULT NULL,
                PRIMARY KEY (`id`),
                KEY `app_id` (`app_id`),
                CONSTRAINT `FK_apps_detectinfo` FOREIGN KEY (`app_id`) REFERENCES `apps` (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
            "installers" => "CREATE TABLE `installers` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `app_id` int(11) NOT NULL,
                `dl` varchar(5000) NOT NULL,
                `launch_args` varchar(1000) NOT NULL,
                PRIMARY KEY (`id`),
                KEY `app_id` (`app_id`),
                CONSTRAINT `FK_apps_installers` FOREIGN KEY (`app_id`) REFERENCES `apps` (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
            "users" => "CREATE TABLE `users` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `username` varchar(50) NOT NULL,
                `password` varchar(255) NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
        ];

        foreach ($createStatments as $tableName => $stmt) {
            $result = $db->exec($stmt);
            if ($result === false) {
                die("Error creating database table $tableName");
            }
        }
    }
} else {
    $hashedPassword = password_hash($_POST["pass"], PASSWORD_BCRYPT);
    $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $result = $stmt->execute([$_POST["user"], $hashedPassword]);
    if ($result) {
        header("Location: dashboard/login.php");
    } else {
        die("Error creating user");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sUpdater Server Installation</title>
</head>
<body>
    <h1>sUpdater Server Installation</h1>
    <p>The database has been succesfully set up. Now you need to setup a login user for the dashboard.</p>
    <form method="POST">
        <p>Username: <input type="text" name="user" /><br />
        Password: <input type="password" name="pass" /></p>
        <input type="submit" value="Save & Login" />
    </form>
</body>
</html>