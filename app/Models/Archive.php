<?php

namespace App\Models;

use App\Helpers\VariableHelper;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'portable_app_id', 'created_at', 'updated_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];

    public function portableApp()
    {
        return $this->belongsTo(PortableApp::class);
    }

    protected function downloadLinkParsed(): Attribute
    {
        return new Attribute(
            get: fn() => VariableHelper::parseDownloadLink($this->download_link, $this->portableApp->version)
        );
    }
}
