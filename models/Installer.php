<?php
class Installer 
{
    public $Id;
    public $AppId;
    public $DL;
    public $LaunchArgs;

    public function __construct($data)
    {
        $this->Id = isset($data["id"]) ? $data["id"] : null;
        $this->AppId = isset($data["app_id"]) ? $data["app_id"] : null;
        $this->DL = isset($data["dl"]) ? $data["dl"] : null;
        $this->LaunchArgs = isset($data["launch_args"]) ? $data["launch_args"] : null;
    }
}