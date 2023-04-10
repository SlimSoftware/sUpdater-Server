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

    public function getVersionAttribute($value)
    {
        if ($value !== null) {
            return $value;
        } else {
            return '(latest)';
        }
    }

    public function detectInfo()
    {
        return $this->hasMany(DetectInfo::class);
    }

    public function installers()
    {
        return $this->hasMany(Installer::class);
    }
}
