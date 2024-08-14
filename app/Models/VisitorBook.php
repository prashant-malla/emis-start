<?php

namespace App\Models;

use App\Casts\SystemDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorBook extends Model
{
    use HasFactory;

    protected $fillable = [
        'purpose_id',
        'visitor_name',
        'phone',
        'id_card',
        'no_of_person',
        'date',
        'in_time',
        'out_time',
        'note',
        'file'
    ];

    protected $casts = [
        'date' => SystemDate::class,
    ];

    public function purpose()
    {
        return $this->belongsTo('App\Models\Purpose', 'purpose_id', 'id');
    }
}
