<?php
require __DIR__ . "/../Database.php";
require __DIR__ . "/../models/Description.php";

class DescriptionController 
{
    public static function getDescription(int $appId) 
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM descriptions WHERE app_id = ?");
        $stmt->execute([$appId]);
        $result = $stmt->fetch();

        if ($result != null) {
            $description = new Description($result);
            return $description;
        }
        return null;
    }
}