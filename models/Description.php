<?php
class Description 
{
    public $Id;
    public $AppId;
    public $Text;
    public $URL;

    public function __construct($data)
    {
        $this->Id = isset($data["id"]) ? $data["id"] : null;
        $this->AppId = isset($data["app_id"]) ? $data["app_id"] : null;
        $this->Text = isset($data["text"]) ? $data["text"] : null;
        $this->Url = isset($data["url"]) ? $data["url"] : null;
    }
}