<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    public function detectInfo()
    {
        return $this->hasOne(DetectInfo::class);
    }

    public function installer()
    {
        return $this->hasOne(Installer::class);
    }
    
    public function changelog()
    {
        return $this->hasOne(Changelog::class);
    }
    
    public function website()
    {
        return $this->hasOne(Website::class);
    }
}
