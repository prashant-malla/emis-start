<?php

namespace App\Repositories;

use App\Models\Event;
use App\Contracts\EventInterface;

class EventRepository implements EventInterface
{
    public function getTotalEvents($student): int
    {
        return Event::query()
            ->where(function ($query) use ($student) {
                $query->where('participants', 'All')
                    ->orWhere(function ($query) use ($student) {
                        $query->whereHas('programs', function ($query) use ($student) {
                            $query->where('program_id', $student->program_id);
                        })
                            ->whereHas('yearsemesters', function ($query) use ($student) {
                                $query->where('year_semester_id', $student->year_semester_id);
                            })
                            ->whereHas('sections', function ($query) use ($student) {
                                $query->where('section_id', $student->section_id);
                            });
                    });
            })
            ->count();
    }
}
