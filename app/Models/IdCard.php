<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class IdCard extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name',
        'header',
        'title',
        'fields',
        'primary_color',
        'secondary_color',
        'signature_title',
        'valid_upto',
        'logo_height',
        'header_height',
        'image_width',
        'image_height',
        'field_item_height',
        'footer',
        'theme',
    ];

    protected $appends = [
        'background_image',
        'logo',
        'signature',
        'seal_image'
    ];

    protected $casts = [
        'fields' => 'array'
    ];

    public function getBackgroundImageAttribute()
    {
        return $this->hasMedia() ? $this->getMedia()[0]->getFullUrl() : '';
    }

    public function getLogoAttribute()
    {
        return $this->hasMedia('logo') ? $this->getMedia('logo')[0]->getFullUrl() : '';
    }

    public function getSignatureAttribute()
    {
        return $this->hasMedia('signature') ? $this->getMedia('signature')[0]->getFullUrl() : '';
    }

    public function getSealImageAttribute()
    {
        return $this->hasMedia('seal_image') ? $this->getMedia('seal_image')[0]->getFullUrl() : '';
    }
}
