<?php
require __DIR__ . "/../Database.php";
require __DIR__ . "/../models/Installer.php";

class InstallerController 
{
    public static function getInstaller(int $appId) 
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM installers WHERE app_id = ?");
        $stmt->execute([$appId]);
        $result = $stmt->fetch();

        if ($result != null) {
            $info = new Installer($result);
            return $info;
        }
        return null;
    }

    public static function getInstallersWithIds(string $appIds) 
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM installers WHERE app_id IN (?)");
        $stmt->execute([$appIds]);
        $result = $stmt->fetchAll();
        $installers = InstallerController::dbResultToModel($result);
        return $installers;
    }

    public static function getInstallersWithoutIds(string $ids) 
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM installers WHERE app_id NOT IN (?)");
        $stmt->execute([$ids]);
        $result = $stmt->fetchAll();
        $installers = InstallerController::dbResultToModel($result);
        return $installers;
    }

    private static function dbResultToModel($result) 
    {
        if ($result != null) {
            $installers = [];
            foreach ($result as $a) {
                $installer = new Installer($a);
                $installers[] = $installer;
            }          
            return $installer;
        }
        return null;
    }
}