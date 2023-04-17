<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'noupdate' => 'boolean',
    ];

    public function detectInfo()
    {
        return $this->hasMany(DetectInfo::class);
    }

    public function installers()
    {
        return $this->hasMany(Installer::class);
    }
}
