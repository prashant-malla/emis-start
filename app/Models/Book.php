<?php

namespace App\Models;

use App\Casts\SystemDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Book extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected  $fillable = ['title', 'book_number', 'isbn_number', 'publisher', 'author', 'subject', 'rack_number', 'quantity', 'book_price', 'post_date', 'description', 'book_type','book_edition'];

    protected $appends = ['document', 'image'];

    protected $casts = [
        'post_date' => SystemDate::class,
    ];

    public function getDocumentAttribute($value)
    {
        return $this->hasMedia() ? $this->getMedia()[0]->getFullUrl() : '';
    }

    public function getImageAttribute($value)
    {
        return $this->hasMedia('image') ? $this->getMedia('image')[0]->getFullUrl() : '';
    }

    public function bookNumbers()
    {
        return $this->hasMany(BookNumber::class,'book_id');
    }
}
