<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

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
