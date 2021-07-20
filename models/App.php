<?php
class App 
{
    public $Id;
    public $App;
    public $LatestVersion;
    public $HasChangelog;
    public $HasDescription;
    public $Arch;
    public $NoUpdate;

    public function __construct($data)
    {
        $this->Id = isset($data["id"]) ? $data["id"] : null;
        $this->Name = isset($data["name"]) ? $data["name"] : null;
        $this->LatestVersion = isset($data["version"]) ? $data["version"] : null;
        $this->HasChangelog = isset($data["changelog_id"]);
        $this->HasDescription = isset($data["description_id"]);
        $this->Arch = isset($data["arch"]) ? $data["arch"] : 0;
        $this->NoUpdate = isset($data["noupdate"]) ? $data["noupdate"] === true : 0;
    }
}