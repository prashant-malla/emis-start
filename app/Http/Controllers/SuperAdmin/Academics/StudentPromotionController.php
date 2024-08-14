<?php

namespace App\Http\Controllers\SuperAdmin\Academics;

use App\Enum\StudentStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentPromotionRequest;
use App\Models\AcademicYear;
use App\Models\Batch;
use App\Models\Program;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentEnrollment;
use App\Models\StudentPromotion;
use App\Models\YearSemester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentPromotionController extends Controller
{
    public function create(Request $request)
    {
        $data['title'] = 'Manage Students';

        $data['academicYears'] = AcademicYear::latest('start_date')->get();

        $data['batches'] = Batch::all();

        $data['programs'] = Program::all();

        $data['yearSemesters'] = YearSemester::where([
            'academic_year_id' => $request->academic_year_id,
            'batch_id' => $request->batch_id,
            'program_id' => $request->program_id,
        ])->get();

        $data['sections'] = Section::where('year_semester_id', $request->year_semester_id)->get();

        // Get student list
        if ($request->academic_year_id && $request->batch_id && $request->year_semester_id) {
            $data['students'] = Student::query()
                ->where([
                    'academic_year_id' => $request->academic_year_id,
                    'batch_id' => $request->batch_id,
                    'year_semester_id' => $request->year_semester_id,
                    'status' => StudentStatusEnum::ACTIVE,
                ])->when($request->section_id, function ($query, $sectionId) {
                    return $query->where('section_id', $sectionId);
                })->get();
        }

        $data['filters'] = $request->all(['academic_year_id', 'batch_id', 'program_id', 'year_semester_id', 'section_id']);

        return view('pages.academics.student.promotion.create', $data);
    }

    private function updateStudent($studentId, $academicYearId, $yearSemesterId, $sectionId, $roll = null)
    {
        $student = Student::find($studentId);

        if ($student) {
            $student->academic_year_id = $academicYearId;
            $student->year_semester_id = $yearSemesterId;
            $student->section_id = $sectionId;
            $student->roll = $roll;

            $student->save();
        }
    }

    private function updateStudentStatus($studentId, $status, $date, $remarks)
    {
        $student = Student::find($studentId);

        if ($student) {
            $student->status = $status;
            $student->status_updated_at = $date;
            $student->remarks = $remarks;

            $student->save();
        }
    }

    private function createPromotion($studentId, $fromYearSemesterId, $toYearSemesterId, $promotionDate)
    {
        StudentPromotion::create([
            'student_id' => $studentId,
            'from_year_semester_id' => $fromYearSemesterId,
            'to_year_semester_id' => $toYearSemesterId,
            'promotion_date' => $promotionDate
        ]);
    }

    private function createOrUpdateEnrollment($studentId, $academicYearId, $batchId, $programId, $yearSemesterId, $sectionId, $roll = null, $enrollmentDate)
    {
        StudentEnrollment::updateOrCreate([
            'student_id' => $studentId,
            'year_semester_id' => $yearSemesterId,
        ], [
            'academic_year_id' => $academicYearId,
            'batch_id' => $batchId,
            'program_id' => $programId,
            'section_id' => $sectionId,
            'roll' => $roll,
            'enrollment_date' => $enrollmentDate
        ]);
    }

    public function store(StoreStudentPromotionRequest $request)
    {
        try {
            DB::beginTransaction();

            foreach ($request->student_id as $sid) {
                if ($request->action === 'update_status') {
                    // status update case
                    $remarks = $request->remarks[$sid] ?? null;
                    $this->updateStudentStatus($sid, $request->status, $request->date, $remarks);
                } else {
                    // promotion case
                    $roll = $request->to_roll[$sid] ?? null;
                    $this->updateStudent($sid, $request->to_academic_year_id, $request->to_year_semester_id, $request->to_section_id[$sid], $roll);
                    $this->createPromotion($sid, $request->from_year_semester_id, $request->to_year_semester_id, $request->date);
                    // Enrollment is unique to student based on year_semester_id
                    // We update enrollment if already exists for given year/semester
                    $this->createOrUpdateEnrollment($sid, $request->to_academic_year_id, $request->to_batch_id, $request->to_program_id, $request->to_year_semester_id, $request->to_section_id[$sid], $roll, $request->date);
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Student updated successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to promote student. ' . $e->getMessage());
        }
    }
}
