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

    public function detectinfo()
    {
        return $this->belongsTo(DetectInfo::class);
    }

    public function app()
    {
        return $this->belongsTo(App::class);
    }

    public function parsedDownloadLink(): string
    {
        $version = $this->app->version;
        $dl = $this->download_link;

        $dl = str_replace('%ver.0%', str_replace('.', '', $version), $dl);
        $dl = str_replace('%ver.1%', $this->splitVersion($version, 2), $dl);
        $dl = str_replace('%ver.2%', $this->splitVersion($version, 3), $dl);
        $dl = str_replace('%ver.3%', $this->splitVersion($version, 4), $dl);

        return $dl;
    }

    private function splitVersion(?string $version, int $digits)
    {
        if (!$version) {
            return '';
        }

        $numbers = explode($version, '.', $digits);
        $newVersion = implode('.', $numbers);

        return $newVersion;
    }
}
