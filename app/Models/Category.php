<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'app_id', 'portable_app_id', 'created_at', 'updated_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];

    public function apps()
    {
        return $this->belongsToMany(App::class);
    }

    public function portableApps()
    {
        return $this->belongsToMany(PortableApp::class, 'portable_app_category');
    }
}
