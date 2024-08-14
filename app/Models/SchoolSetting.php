<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class SchoolSetting extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected  $fillable = [
        'name',
        'slogan',
        'email_address',
        'established_year',
        'phone_number',
        'address',
        'session_id',
        'calendar_type',
        'date_format',
        'crn_prefix',
        'crn_start_from',
    ];

    protected $appends = ['logo_url', 'favicon_url'];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('favicon')
            ->nonQueued()
            ->width(32)
            ->height(32);
    }

    // Attribute Appends
    public function getLogoUrlAttribute()
    {
        return $this->hasMedia() ? $this->getMedia()[0]->getFullUrl() : asset('template/images/logo/logo-white.png');
    }

    public function getFaviconUrlAttribute()
    {
        return $this->hasMedia() ? $this->getMedia()[0]->getFullUrl('favicon') : asset('template/images/logo/logo-white.png');
    }
}
