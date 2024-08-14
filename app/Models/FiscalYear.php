<?php

namespace App\Models;

use App\Casts\SystemDate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FiscalYear extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'start_date',
        'end_date',
        'is_active'
    ];

    protected $casts = [
        'start_date' => SystemDate::class,
        'end_date' => SystemDate::class,
    ];

    public function scopeActive(Builder $query)
    {
        return $query->where('is_active', 1);
    }
}
