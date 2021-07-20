<?php
require __DIR__ . "/../Database.php";
require __DIR__ . "/../models/Changelog.php";

class ChangelogController 
{
    public static function getChangelog(int $appId) 
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM changelogs WHERE app_id = ?");
        $stmt->execute([$appId]);
        $result = $stmt->fetch();

        if ($result != null) {
            $changelog = new Changelog($result);
            return $changelog;
        }
        return null;
    }
}