<?php
require __DIR__ . "/Database.php";

$db = Database::getInstance();

if (!isset($_POST["user"]) && !isset($_POST["pass"])) {
    $result = $db->query("SELECT count(*) FROM users");
    $userAmount = $result !== false ? $result->fetch(PDO::FETCH_COLUMN) : 0;

    if ($userAmount > 0) {
        header("Location: dashboard/login.php");
        exit();
    } else if ($result === false) {
        // Apps table does not exist, so create all required tables
        $createStatments = [
            "apps" => "CREATE TABLE `apps` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(200) NOT NULL,
                `version` varchar(50) NOT NULL,
                `noupdate` tinyint(1) NOT NULL DEFAULT '0',
                PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
            "changelogs" => "CREATE TABLE `changelogs` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `app_id` int(11) DEFAULT NULL,
                `papp_id` int(11) DEFAULT NULL,
                `url` varchar(5000) NOT NULL,
                PRIMARY KEY (`id`),
                KEY `FK_changelogs_apps` (`app_id`),
                KEY `FK_changelogs_portableapps` (`papp_id`),
                CONSTRAINT `FK_changelogs_apps` FOREIGN KEY (`app_id`) REFERENCES `apps` (`id`),
                CONSTRAINT `FK_changelogs_portableapps` FOREIGN KEY (`papp_id`) REFERENCES `portableapps` (`id`)
                ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4",
            "descriptions" => "CREATE TABLE `descriptions` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `app_id` int(11) DEFAULT NULL,
                `papp_id` int(11) DEFAULT NULL,
                `url` varchar(5000) NOT NULL,
                PRIMARY KEY (`id`),
                KEY `FK_descriptions_apps` (`app_id`),
                KEY `FK_descriptions_portableapps` (`papp_id`),
                CONSTRAINT `FK_descriptions_apps` FOREIGN KEY (`app_id`) REFERENCES `apps` (`id`),
                CONSTRAINT `FK_descriptions_portableapps` FOREIGN KEY (`papp_id`) REFERENCES `portableapps` (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
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
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
            "portableapps" => "CREATE TABLE `portableapps` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(200) NOT NULL,
                `version` varchar(50) NOT NULL,
                `arch` tinyint(4) NOT NULL,
                `changelog_id` int(11) DEFAULT NULL,
                `description_id` int(11) DEFAULT NULL,
                PRIMARY KEY (`id`),
                KEY `FK_portableapps_changelogs` (`changelog_id`),
                KEY `FK_portableapps_descriptions` (`description_id`),
                CONSTRAINT `FK_portableapps_changelogs` FOREIGN KEY (`changelog_id`) REFERENCES `changelogs` (`id`),
                CONSTRAINT `FK_portableapps_descriptions` FOREIGN KEY (`description_id`) REFERENCES `descriptions` (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
            "archives" => "CREATE TABLE `archives` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `papp_id` int(11) NOT NULL,
                `dl` varchar(5000) NOT NULL,
                `extractmode` tinyint(2) NOT NULL,
                `launchfile` VARCHAR(100) NOT NULL,
                PRIMARY KEY (`id`),
                KEY `FK_archives_portableapps` (`papp_id`),
                CONSTRAINT `FK_archives_portableapps` FOREIGN KEY (`papp_id`) REFERENCES `portableapps` (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
        ];

        foreach ($createStatments as $tableName => $stmt) {
            $result = $db->exec($stmt);
            if ($result === false) {
                exit("Error creating database table $tableName");
            }
        }
    }
} else {
    $hashedPassword = password_hash($_POST["pass"], PASSWORD_BCRYPT);
    $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $result = $stmt->execute([$_POST["user"], $hashedPassword]);
    if ($result) {
        header("Location: dashboard/login.php");
        exit();
    } else {
        exit("Error creating user");
    }
}

$title = "Installation";
include("dashboard/inc/header.php");
include("dashboard/inc/nav.php");
?>

<div class="container">
    <h1>sUpdater Server Installation</h1>
    <p>The database has been succesfully set up. Now you need to setup a login user for the dashboard.</p>
    <form method="POST">
        <div class="form-group col-md-4">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="user" />
        </div>
        <div class="form-group col-md-4">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="pass" />
        </div>
        <input class="btn btn-primary" type="submit" value="Save & Login" />
    </form>
</div>

<?php
include("dashboard/inc/scripts.php");
?>
</body>
</html>