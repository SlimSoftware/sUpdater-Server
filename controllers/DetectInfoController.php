<?php
require __DIR__ . "/../Database.php";
require __DIR__ . "/../models/DetectInfo.php";

class DetectInfoController 
{
    public static function getDetectInfo() 
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM detectinfo");
        $stmt->execute();
        $result = $stmt->fetchAll();

        if ($result != null) {
            $info = DetectInfoController::dbResultToModel($result);
            return $info;
        }
        return null;
    }
    
    private static function dbResultToModel($result) 
    {
        if ($result != null) {
            $infos = [];
            foreach ($result as $i) {
                $info = new DetectInfo($i);
                $infos[] = $info;
            }          
            return $infos;
        }
        return null;
    }
}