<?php
class DetectInfo 
{
    public $Id;
    public $AppId;
    public $Arch;
    public $RegKey;
    public $RegValue;
    public $ExePath;

    public function __construct($data)
    {
        $this->Id = isset($data["id"]) ? $data["id"] : null;
        $this->AppId = isset($data["app_id"]) ? $data["app_id"] : null;
        $this->Arch = isset($data["arch"]) ? $data["arch"] : null;
        $this->RegKey = isset($data["regkey"]) ? $data["regkey"] : null;
        $this->RegValue = isset($data["regvalue"]) ? $data["regvalue"] : null;
        $this->ExePath = isset($data["exepath"]) ? $data["exepath"] : null;
    }
}