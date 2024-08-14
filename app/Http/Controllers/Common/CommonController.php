<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Teacher;
use App\Models\AcademicYear;
use App\Models\Batch;
use App\Models\Exam;
use App\Models\ExamMark;
use App\Models\Program;
use App\Models\Section;
use App\Models\StaffDirectory;
use App\Models\Student;
use App\Models\Subject;
use App\Models\TeacherAssign;
use App\Models\YearSemester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommonController extends Controller
{
    public function getPrograms(Request $request, $levelId)
    {
        $assignedOnly = filter_var($request->assignedOnly, FILTER_VALIDATE_BOOLEAN);
        if ($assignedOnly) {
            $assignedProgramIds = TeacherAssign::where([
                'teacher_id' => Auth::guard('staff')->user()->id,
                'level_id' => $levelId,
            ])->pluck('program_id')->unique();

            return json_encode(Program::whereIn('id', $assignedProgramIds)->get());
        }

        return json_encode(Program::where('level_id', $levelId)->get());
    }

    public function getProgramType($id)
    {
        $programs = Program::where('id', $id)->get();
        return response(json_encode($programs));
    }

    public function getYearSemester(Request $request, $programId)
    {
        $assignedOnly = filter_var($request->assignedOnly, FILTER_VALIDATE_BOOLEAN);
        if ($assignedOnly) {
            $assignedYearSemesterIds = TeacherAssign::where([
                'teacher_id' => Auth::guard('staff')->user()->id,
                'program_id' => $programId,
            ])->pluck('year_semester_id')->unique();

            return json_encode(YearSemester::whereIn('id', $assignedYearSemesterIds)->get());
        }

        return json_encode(YearSemester::where('program_id', $programId)->get());
    }

    public function getProgramYearSemester(Request $request, $programId)
    {
        $assignedOnly = filter_var($request->assignedOnly, FILTER_VALIDATE_BOOLEAN);

        $filters = [
            'program_id' => $programId,
        ];

        if ($request->batchId) {
            $filters['batch_id'] = $request->batchId;
        }

        $query = YearSemester::where($filters)->active();

        if ($assignedOnly) {
            $assignedYearSemesterIds = [];
            $teacherId = Auth::guard('staff')->user()?->id;
            if ($teacherId) {
                $assignedYearSemesterIds = TeacherAssign::where([
                    'teacher_id' => $teacherId,
                    'program_id' => $programId,
                ])->pluck('year_semester_id')->unique();
            }
            $query->whereIn('id', $assignedYearSemesterIds);
        }

        // filter year/semesters within academic year
        if ($request->academicYearId) {
            // $academicYear = AcademicYear::find($request->academicYearId);
            // $query->where(function ($query) use ($academicYear) {
            //     $query
            //         ->whereNull('start_date')
            //         ->orWhere('start_date', '<=', convertToEngDate($academicYear->end_date));
            // })->where(function ($query) use ($academicYear) {
            //     $query
            //         ->whereNull('end_date')
            //         ->orWhere('end_date', '>=', convertToEngDate($academicYear->start_date));
            // });
            $query->where('academic_year_id', $request->academicYearId);
        }

        return json_encode($query->orderBy('term_number')->get());
    }

    public function getYearSemesterByProgramAndBatch(Request $request, $programId, $batchId)
    {
        $assignedOnly = filter_var($request->assignedOnly, FILTER_VALIDATE_BOOLEAN);
        $withSections = filter_var($request->withSections, FILTER_VALIDATE_BOOLEAN);
        $all = filter_var($request->all, FILTER_VALIDATE_BOOLEAN);

        $filters = [
            'program_id' => $programId,
            'batch_id' => $batchId
        ];

        $query = YearSemester::where($filters);

        if (!$all) {
            $query->active();
        }

        if ($assignedOnly) {
            $assignedYearSemesterIds = [];
            $teacherId = Auth::guard('staff')->user()?->id;
            if ($teacherId) {
                $assignedYearSemesterIds = TeacherAssign::where([
                    'teacher_id' => $teacherId,
                    'program_id' => $programId,
                ])->pluck('year_semester_id')->unique();
            }
            $query->whereIn('id', $assignedYearSemesterIds);
        }

        if ($withSections) {
            $query->with('sections');
        }

        return json_encode($query->orderBy('term_number')->get());
    }

    public function getAssignedSubjectsByYearSemesterId($id)
    {
        $subjects = TeacherAssign::where('teacher_id', Auth::guard('staff')->user()->id)->where('year_semester_id', $id)->with('subject')->get();
        return response(json_encode($subjects));
    }

    public function getSections(Request $request, $yearSemesterId)
    {
        $assignedOnly = filter_var($request->assignedOnly, FILTER_VALIDATE_BOOLEAN);
        if ($assignedOnly) {
            $assignedSectionIds = TeacherAssign::where([
                'teacher_id' => Auth::guard('staff')->user()->id,
                'year_semester_id' => $yearSemesterId,
            ])->pluck('section_id')->unique();

            return json_encode(Section::whereIn('id', $assignedSectionIds)->get());
        }

        return json_encode(Section::where('year_semester_id', $yearSemesterId)->get());
    }

    public function getSubjects($id)
    {
        $yearSemester = YearSemester::find($id);
        $yearSubjects = Subject::where('year_semester_id', $id)->get();
        $semesterSubjects = $yearSemester->subjects;

        $subjects = $yearSubjects->union($semesterSubjects);
        return json_encode($subjects);
    }
    public function getStudents($id)
    {
        return json_encode(Student::where('section_id', $id)->get());
    }
    public function getTeachers($id)
    {
        $teachers = DB::table('staff_directories')
            ->join('teacher_assigns', 'staff_directories.id', '=', 'teacher_assigns.teacher_id')
            ->where('teacher_assigns.subject_id', $id)
            ->select('staff_directories.id as id', 'staff_directories.name as name')
            ->get();
        return json_encode($teachers);
    }

    public function getAssignedTeachers($id)
    {
        $teachers = StaffDirectory::whereHas('teacher_assigns', function ($query) use ($id) {
            $query->where('section_id', $id);
        })->get();
        return response(json_encode($teachers));
    }
    public function getTable(Request $request)
    {
        $teacherAssign = DB::table('teacher_assigns')
            ->join('levels', 'levels.id', '=', 'teacher_assigns.level_id')
            ->join('programs', 'programs.id', '=', 'teacher_assigns.program_id')
            ->join('year_semesters', 'year_semesters.id', '=', 'teacher_assigns.year_semester_id')
            ->join('subjects', 'subjects.id', '=', 'teacherAssign.subject_id')
            ->join('staff_directories', 'staff_directories.id', '=', 'teacherAssign.teacher_id')
            ->where('teacher_assigns.year_semester_id', '=', $request->year_semester_id)
            ->get();
        $view = view('pages.teacher_assign.table', compact('teacherAssign'));
        echo $view;
    }
    public function getExamsByYearSemesterId($yearSemesterId)
    {
        $exams = Exam::select('id', 'name')->where('year_semester_id', $yearSemesterId)->active()->get();
        return json_encode($exams);
    }

    public function getSectionsByYearSemesterId($yearSemesterId)
    {
        $sections = Section::select('id', 'group_name')->where('year_semester_id', $yearSemesterId)->get();
        return json_encode($sections);
    }

    public function getExamStudents($examId)
    {
        $examStudentIds = ExamMark::where('exam_id', $examId)->pluck('student_id')->toArray();
        $students = Student::select('id', 'sname')->whereIn('id', $examStudentIds)->get();
        return json_encode($students);
    }
    public function fetchSubjects(Request $request)
    {
        try {
            $requestData = $request->requestData; // Get the entire request data
            $sectionIds = $requestData['sections']; // Get the selected section IDs

            // Ensure $sectionIds is an array
            if (!is_array($sectionIds)) {
                return response()->json(['error' => 'Invalid input'], 400);
            }

            // Fetch unique subjects for the selected sections
            $subject = Subject::whereIn('id', function ($query) use ($sectionIds) {
                $query->select('subject_id')
                    ->from('teacher_assigns')
                    ->whereIn('section_id', $sectionIds);
            })->distinct()->pluck('id', 'name');

            // Return the list of unique subjects as JSON response
            return response()->json($subject);
        } catch (\Exception $e) {
            // Handle the exception here
            return response()->json(['error' => 'An error occurred'], 500);
        }
    }

    public function getAssignedSection($yearSemesterId)
    {
        try {
            // Retrieve the YearSemester model based on the provided $yearSemesterId
            $sectionIds = TeacherAssign::where('year_semester_id', $yearSemesterId)->get('section_id');

            $sections = Section::whereIn('id', $sectionIds)->distinct()->pluck('group_name', 'id');

            // Check if there are assigned sections
            if ($sections) {
                // Prepare the response data

                // Return the list of assigned sections as a JSON response
                return response()->json($sections);
            } else {
                // Handle the case where there are no assigned sections
                return response()->json(['message' => 'No sections assigned for this Year/Semester'], 200);
            }
        } catch (\Exception $e) {
            // Handle the exception here
            return response()->json(['error' => 'An error occurred'], 500);
        }
    }

    // public function getBatchByAcademicYearId(AcademicYear $academicYear)
    // {
    //     $batchIds = YearSemester::where('academic_year_id', $academicYear->id)->pluck('batch_id')->toArray();
    //     $batches = Batch::whereIn('id', $batchIds)->get();
    //     return response(json_encode($batches));
    // }
}
