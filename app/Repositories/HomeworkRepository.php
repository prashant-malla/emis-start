<?php

namespace App\Repositories;

use App\Models\Homework;
use App\Contracts\HomeworkInterface;
use Illuminate\Database\Eloquent\Collection;

class HomeworkRepository implements HomeworkInterface
{
    public function getHomeworks($student): Collection
    {
        return Homework::query()
            ->where('level_id', $student->level_id)
            ->where('program_id', $student->program_id)
            ->where('year_semester_id', $student->year_semester_id)
            ->where('section_id', $student->section_id)
            ->with('subject')
            ->latest('id')
            ->take(10)
            ->get();
    }

    public function getTotalHomeworks($student): int
    {
        return Homework::query()
            ->where('program_id', $student->program_id)
            ->where('year_semester_id', $student->year_semester_id)
            ->where('section_id', $student->section_id)
            ->count();
    }
}
