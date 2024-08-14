<?php

namespace App\Repositories;

use App\Models\Notice;
use App\Contracts\NoticeInterface;

class NoticeRepository implements NoticeInterface
{
    public function getTotalNotices($student): int
    {
        return Notice::query()
            ->where(function ($query) use ($student) {
                $query->where('notice_to', 'All')
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
