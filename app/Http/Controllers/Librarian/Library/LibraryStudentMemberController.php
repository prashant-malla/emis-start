<?php

namespace App\Http\Controllers\Librarian\Library;

use App\Models\Eclass;
use App\Models\Program;
use App\Models\Section;
use App\Models\Student;
use App\Models\YearSemester;
use Illuminate\Http\Request;
use App\Services\BatchService;
use App\Http\Controllers\Controller;
use App\Services\AcademicYearService;

class LibraryStudentMemberController extends Controller
{
    public function __construct(protected AcademicYearService $academicYearService, protected BatchService $batchService)
    {
        //    
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['academicYears'] = $this->academicYearService->getAll();
        $data['batches'] = $this->batchService->getAll();

        $data['programs'] = Program::all();
        $data['yearSemesters'] = YearSemester::all();
        $data['sections'] = Section::all();
        $data['students'] = Student::filterBy($request->only(['academic_year_id', 'batch_id']))
            ->latest('id')
            ->get();
        return view('pages.library.library_student_member', $data);
    }

    public function getStudents(Request $request)
    {
        $data['academicYears'] = $this->academicYearService->getAll();
        $data['batches'] = $this->batchService->getAll();

        $data['programs'] = Program::all();
        $data['yearSemesters'] = YearSemester::all();
        $data['sections'] = Section::all();
        $data['searchedStudents'] = Student::filterBy($request->only('academic_year_id', 'batch_id'))
            ->where([
                ['program_id', $request->program_id],
                ['year_semester_id', $request->year_semester_id],
                ['section_id', $request->section_id],
            ])
            ->get();
        return view('pages.library.library_student_member', $data);
    }
}
