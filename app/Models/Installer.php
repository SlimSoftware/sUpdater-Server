<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Installer extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'app_id', 'created_at', 'updated_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];

    public function detectinfo() {
        return $this->belongsTo(DetectInfo::class);
    }

    public function app()
    {
        return $this->belongsTo(App::class);
    }
}
