<?php

namespace App\Models;

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
        return new Attribute(get: fn() => $this->parseDownloadLink($this->download_link));
    }

    private function parseDownloadLink()
    {
        $dl = $this->download_link;
        $version = $this->portableApp->version;

        $dl = str_replace('%ver.0%', str_replace('.', '', $version), $dl);
        $dl = str_replace('%ver.1%', $this->splitVersion($version, 2), $dl);
        $dl = str_replace('%ver.2%', $this->splitVersion($version, 3), $dl);
        $dl = str_replace('%ver.3%', $this->splitVersion($version, 4), $dl);

        return $dl;
    }
}
