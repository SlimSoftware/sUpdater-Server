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

    public function app()
    {
        return $this->belongsTo(App::class);
    }
}
