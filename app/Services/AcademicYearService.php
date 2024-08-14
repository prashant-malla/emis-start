<?php

namespace App\Services;

use App\Models\AcademicYear;
use Illuminate\Support\Collection;

// use App\Contracts\AcademicYearServiceInterface;

class AcademicYearService
{
    public function getAll(): Collection
    {
        return AcademicYear::latest('start_date')->get();
    }
}
