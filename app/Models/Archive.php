<?php

namespace App\Models;

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

    public function parsedDownloadLink()
    {
        $dl = $this->download_link;
        $version = $this->portableApp->version;

        if (strpos($dl, '%ver%') !== false) {
            $dl = str_replace('%ver%', $version, $dl);
        }
        if (strpos($dl, '%verMajorMinor%') !== false) {
            $dl = str_replace('%verMajorMinor%', $this->convertToMajorMinorVersion($version), $dl);
        }
        if (strpos($dl, '%verDotless%') !== false) {
            $dl = str_replace('%verDotless%', $this->convertToDotlessVersion($version), $dl);
        }

        return $dl;
    }

    private function convertToDotlessVersion(string $version)
    {
        return str_replace('.', '', $version);
    }

    private function convertToMajorMinorVersion(string $version)
    {
        $numbers = explode('.', $version, 3);
        $major = $numbers[0];
        $minor = $numbers[1];
        return "$major.$minor";
    }
}
