<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortableApp extends Model
{
    use HasFactory;

    public function archive()
    {
        return $this->hasOne(Archive::class);
    }
}
