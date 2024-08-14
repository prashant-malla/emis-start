<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Certificate extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name',
        'sub_heading',
        'header_left',
        'header_middle',
        'header_right',
        'content',
        'footer_left',
        'footer_middle',
        'footer_right',
        'header_height',
        'title_height',
        'content_height',
        'footer_height'
    ];

    protected $appends = [
        'background_image'
    ];

    public function getBackgroundImageAttribute()
    {
        return $this->hasMedia() ? $this->getMedia()[0]->getFullUrl() : '';
    }
}
