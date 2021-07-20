<?php
require __DIR__ . "/../Database.php";
require __DIR__ . "/../models/App.php";

class AppController 
{
    public static function getApp(int $id) 
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT a.*, c.id AS changelog_id, d.id as description_id FROM apps a LEFT JOIN changelogs c ON c.app_id = a.id LEFT JOIN descriptions d ON d.app_id = a.id WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch();

        if ($result != null) {
            $app = new App($result);
            return $app;
        }
        return null;
    }

    public static function getAppsWithIds(string $ids) 
    {
        $idArray = explode(",", $ids);
        $in = str_repeat('?,', count($idArray) - 1) . '?';
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT a.*, c.id AS changelog_id, d.id as description_id FROM apps a LEFT JOIN changelogs c ON c.app_id = a.id LEFT JOIN descriptions d ON d.app_id = a.id WHERE id IN ($in)");
        $stmt->execute($idArray);
        $result = $stmt->fetchAll();
        $apps = AppController::dbResultToModel($result);
        return $apps;
    }

    public static function getAppsWithoutIds(string $ids) 
    {
        $idArray = explode(",", $ids);
        $in = str_repeat('?,', count($idArray) - 1) . '?';
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT a.*, c.id AS changelog_id, d.id as description_id FROM apps a LEFT JOIN changelogs c ON c.app_id = a.id LEFT JOIN descriptions d ON d.app_id = a.id WHERE id NOT IN ($in)");
        $stmt->execute($idArray);
        $result = $stmt->fetchAll();
        $apps = AppController::dbResultToModel($result);
        return $apps;
    }

    public static function getAppVersions(string $ids) 
    {
        $idArray = explode(",", $ids);
        $in = str_repeat('?,', count($idArray) - 1) . '?';
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT id, version, noupdate FROM apps WHERE id IN ($in)");
        $stmt->execute($idArray);
        $result = $stmt->fetchAll();
        $apps = AppController::dbResultToModel($result);
        return $apps;
    }

    public static function getApps() 
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT a.*, c.id AS changelog_id, d.id as description_id FROM apps a LEFT JOIN changelogs c ON c.app_id = a.id LEFT JOIN descriptions d ON d.app_id = a.id");
        $stmt->execute();
        $result = $stmt->fetchAll();
        $apps = AppController::dbResultToModel($result);
        return $apps;
    }

    private static function dbResultToModel($result) 
    {
        if ($result != null) {
            $apps = [];
            foreach ($result as $a) {
                $app = new App($a);
                $apps[] = $app;
            }          
            return $apps;
        }
        return null;
    }
}