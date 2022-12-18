<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortableApp extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function archive()
    {
        return $this->hasOne(Archive::class);
    }
}
