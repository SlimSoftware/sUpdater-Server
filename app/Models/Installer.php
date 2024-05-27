<?php

namespace App\Models;

use App\Helpers\VariableHelper;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
    protected $hidden = ['app', 'created_at', 'updated_at'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['download_link_raw'];

    public function detectinfo()
    {
        return $this->belongsTo(DetectInfo::class);
    }

    public function app()
    {
        return $this->belongsTo(App::class);
    }

    protected function downloadLink(): Attribute
    {
        return new Attribute(get: fn() => VariableHelper::parseDownloadLink($this->getRawOriginal('download_link'), $this->app->version));
    }

    protected function downloadLinkRaw(): Attribute
    {
        return new Attribute(get: fn() => $this->getRawOriginal('download_link'));
    }
}
