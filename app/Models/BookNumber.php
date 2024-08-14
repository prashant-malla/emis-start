<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookNumber extends Model
{
    use HasFactory;

    protected $fillable = ['book_id','book_number','publisher','author','book_edition'];


    public function book()
    {
        return $this->belongsTo(Book::class,'book_id');
    }
}
