<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    public function installer()
    {
        return $this->hasOne(Installer::class);
    }

}
