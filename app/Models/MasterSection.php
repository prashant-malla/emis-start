<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterSection extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    public function sections()
    {
        return $this->hasMany(Section::class);
    }
}
