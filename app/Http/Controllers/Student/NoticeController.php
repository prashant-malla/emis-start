<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use App\Services\AcademicYearService;
use App\Services\BatchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NoticeController extends Controller
{
    public function __construct(protected AcademicYearService $academicYearService, protected BatchService $batchService)
    {
        
    }
    public function index(Request $request)
    {
        $data['academicYears'] = $this->academicYearService->getAll();
        $data['batches'] = $this->batchService->getAll();

        $student = Auth::guard('student')->user();
        $data['notices'] = Notice::leftJoin('notice_level', 'notice_level.notice_id', '=', 'notices.id')
            ->leftJoin('notice_program', 'notice_program.notice_id', '=', 'notices.id')
            ->leftJoin('notice_year_semester', 'notice_year_semester.notice_id', '=', 'notices.id')
            ->leftJoin('notice_section', 'notice_section.notice_id', '=', 'notices.id')
            ->where('notices.notice_to', 'All')
            ->orWhere(function ($query) use ($student) {
                $query->where('notices.notice_to', 'Student')
                    ->where(function ($query) use ($student) {
                        $query->where('notice_level.level_id', $student->level_id)
                            ->where(function ($query) use ($student) {
                                $query->where('notice_program.program_id', $student->program_id)
                                    ->orWhere('notice_program.program_id', null);
                            })
                            ->where(function ($query) use ($student) {
                                $query->where('notice_year_semester.year_semester_id', $student->year_semester_id)
                                    ->orWhere('notice_year_semester.year_semester_id', null);
                            })
                            ->where(function ($query) use ($student) {
                                $query->where('notice_section.section_id', $student->section_id)
                                    ->orWhere('notice_section.section_id', null);
                            });
                    });
            })
            ->select('notices.*')
            // ->filterBy($request->only(['academic_year_id', 'batch_id']))
            ->latest('id')
            ->get();

        return view('student.notice.index', $data);
    }

    public function show($id)
    {
        $notice = Notice::find($id);
        return view('pages.notice.show', compact('notice'));
    }
}
