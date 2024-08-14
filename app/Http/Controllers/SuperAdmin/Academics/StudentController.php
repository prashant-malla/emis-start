<?php

namespace App\Http\Controllers\SuperAdmin\Academics;

use App\Enum\StudentStatusEnum;
use App\Exports\ExportStudent;
use App\Http\Controllers\Controller;
use App\Http\Requests\ResetStudentPasswordRequest;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Imports\ImportStudent;
use App\Models\AcademicYear;
use App\Models\Batch;
use App\Models\Program;
use App\Models\Level;
use App\Models\Sparent;
use App\Models\YearSemester;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentCategory;
use App\Models\StudentEnrollment;
use App\Models\StudentPromotion;
use App\Services\CalendarService;
use App\Services\StudentService;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    public function __construct(
        private StudentService $student
    ) {
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        set_time_limit(900);

        try {
            DB::beginTransaction();

            Excel::import(new ImportStudent(), $request->file('file'));

            DB::commit();
            session()->flash('success', 'Imported successfully');
        } catch (\Throwable $th) {

            DB::rollBack();
            session()->flash('error', $th->getMessage());
        }

        return to_route('student.index');
    }

    public function export(Request $request)
    {
        $students = Student::filterBy($request->all())->get();
        $students->load(['level', 'program', 'yearsemester', 'section']);

        return
            Excel::download(
                new ExportStudent($students),
                'students.xlsx'
            );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['academicYears'] = AcademicYear::latest('start_date')->get();
        $data['batches'] = Batch::latest('id')->get();
        $data['levels'] = Level::all();
        $data['programs'] = Program::where('level_id', $request->level_id)->get();
        $data['yearSemester'] = YearSemester::query()
            ->where([
                'program_id' => $request->program_id,
            ])->filterBy(
                $request->only(['academic_year_id', 'batch_id'])
            )->get();
        $data['sections'] = Section::where('year_semester_id', $request->year_semester_id)->get();
        $data['students'] = Student::query()
            ->with('batch', 'level', 'program', 'yearsemester.batch', 'section', 'media')
            ->filterBy(
                $request->only(['level_id', 'program_id', 'year_semester_id', 'section_id', 'batch_id', 'academic_year_id', 'status'])
            )
            ->latest('id')
            ->get();
        $data['filters'] = $request->all(['level_id', 'program_id', 'year_semester_id', 'section_id', 'batch_id', 'academic_year_id', 'status']);

        // count students not enrolled yet
        $enrolledStudentIds = StudentEnrollment::pluck('student_id')->toArray();
        $data['studentNotEnrolledCount'] = $data['students']->whereNotIn('id', $enrolledStudentIds)->count();

        // $category = DB::table('student_categories')->select('id', 'category_name')->get();
        // $data['level'] = DB::table('levels')->select('id', 'name')->get();
        // $data['program'] = DB::table('programs')
        //     ->where('level_id', $request->level_id)
        //     ->select('id', 'name')
        //     ->get();
        // $yearSemester = DB::table('year_semesters')
        //     ->where('program_id', $request->program_id)
        //     ->select('id', 'name')
        //     ->get();
        // $section = DB::table('sections')
        //     ->where('year_semester_id', $request->year_semester_id)
        //     ->select('id', 'group_name')
        //     ->get();
        // $students = Student::filterBy($request->only(['level_id', 'program_id', 'year_semester_id', 'section_id']))
        //     ->latest()
        //     ->with('batch', 'level', 'program', 'section')
        //     ->get();

        return view('pages.academics.student.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['academicYears'] = AcademicYear::latest('start_date')->get();
        $data['batches'] = Batch::all();

        $data['levels'] = Level::get();

        return view('pages.academics.student.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreStudentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStudentRequest $request)
    {
        $student = Student::where('sname', '=', $request->sname)
            ->where('email', '=', $request->email)
            ->first();
        if ($student === null) {
            $storeStudent = Student::create([
                'sname' => $request->sname,
                'email' => $request->email,
                'password' => Hash::make($request->phone),
                'academic_year_id' => $request->academic_year_id,
                'batch_id' => $request->batch_id,
                'ethnicity' => $request->ethnicity,
                'level_id' => $request->level_id,
                'program_id' => $request->program_id,
                'year_semester_id' => $request->year_semester_id,
                'section_id' => $request->section_id,
                'admission' => $request->admission,
                'roll' => $request->roll,
                'dob' => $request->dob,
                'gender' => $request->gender,
                'bloodgroup' => $request->bloodgroup,
                'phone' => $request->phone,
                'caddress' => $request->caddress,
                'paddress' => $request->paddress,
                'caste' => $request->caste,
                'religion' => $request->religion,
            ]);
            if ($request->file('profile_image')) {
                $storeStudent->addMedia($request->file('profile_image'))->toMediaCollection();
            }
            if ($request->file('slc_certificate')) {
                $storeStudent->addMedia($request->file('slc_certificate'))->toMediaCollection('slc_certificate');
            }
            if ($request->file('high_school_certificate')) {
                $storeStudent->addMedia($request->file('high_school_certificate'))->toMediaCollection('high_school_certificate');
            }
            if ($request->file('other_certificate')) {
                $storeStudent->addMedia($request->file('other_certificate'))->toMediaCollection('other_certificate');
            }
            if ($storeStudent) {
                Sparent::create([
                    'student_id' => $storeStudent->id,
                    'email' => $request->parent_email,
                    'password' => bcrypt($request->fathercontact),
                    'father_name' => $request->fathername,
                    'father_contact' => $request->fathercontact,
                    'father_job' => $request->fatherjob,
                    'mother_name' => $request->mothername,
                    'mother_contact' => $request->mothercontact,
                    'mother_job' => $request->motherjob,
                    'guardian_name' => $request->guardname,
                    'guardian_email' => $request->guardemail,
                    'guardian_relation' => $request->guardrelation,
                    'guardian_job' => $request->guardjob,
                    'guardian_contact' => $request->guardcontact,
                    'guardian_address' => $request->guardaddress,
                ]);

                // enroll student
                StudentEnrollment::create([
                    'student_id' => $storeStudent->id,
                    'academic_year_id' => $request->academic_year_id,
                    'batch_id' => $request->batch_id,
                    'program_id' => $request->program_id,
                    'year_semester_id' => $request->year_semester_id,
                    'section_id' => $request->section_id,
                    'roll' => $request->roll,
                    'enrollment_date' => app(CalendarService::class)->today()
                ]);
            }
            return redirect()->route('student.index')->with('success', 'Created successfully');
        } else {
            return redirect()->back()->with('error', 'Data already exists.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        $level = DB::table('levels')->select('id', 'name')->get();
        $program = DB::table('programs')->select('id', 'name')->get();
        $yearSemester = DB::table('year_semesters')->select('id', 'name')->get();
        $section = DB::table('sections')->select('id', 'group_name')->get();
        return view('pages.academics.student.view', ['level' => $level, 'program' => $program, 'yearSemester' => $yearSemester, 'section' => $section, 'student' => $student]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        $data['academicYears'] = AcademicYear::latest('start_date')->get();
        $data['batches'] = Batch::all();

        $data['levels'] = Level::query()
            ->with('programs.yearSemesters.groups')
            ->get();

        $data['student'] = $student;
        $data['promoted'] = StudentPromotion::where('student_id', $student->id)->exists();

        return view('pages.academics.student.form', $data);
    }

    private function uploadMedias($request, $student)
    {
        if ($request->hasFile('profile_image')) {
            if ($student->hasMedia()) {
                $student->deleteMedia($student->getMedia()[0]);
            }
            $student->addMedia($request->file('profile_image'))->toMediaCollection();
        }

        if ($request->hasFile('slc_certificate')) {
            $student->clearMediaCollection('slc_certificate');
            $student->addMedia($request->file('slc_certificate'))->toMediaCollection('slc_certificate');
        }

        if ($request->hasFile('high_school_certificate')) {
            $student->clearMediaCollection('high_school_certificate');
            $student->addMedia($request->file('high_school_certificate'))->toMediaCollection('high_school_certificate');
        }

        if ($request->hasFile('other_certificate')) {
            $student->clearMediaCollection('other_certificate');
            $student->addMedia($request->file('other_certificate'))->toMediaCollection('other_certificate');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdateStudentRequest  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStudentRequest $request, Student $student)
    {
        $studentData = [
            'sname' => $request->sname,
            'email' => $request->email,
            'ethnicity' => $request->ethnicity,
            'section_id' => $request->section_id,
            'roll' => $request->roll,
            'admission' => $request->admission,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'bloodgroup' => $request->bloodgroup,
            'phone' => $request->phone,
            'caddress' => $request->caddress,
            'paddress' => $request->paddress,
            'caste' => $request->caste,
            'religion' => $request->religion,
            'status' => $request->status,
            'status_updated_at' => $request->status_updated_at,
            'remarks' => $request->remarks,
        ];

        try {
            DB::beginTransaction();

            $promoted = $student->promotions()->exists();

            // update all academic fields if initial enrollment
            if (!$promoted) {
                $studentData['academic_year_id'] = $request->academic_year_id;
                $studentData['batch_id'] = $request->batch_id;
                $studentData['level_id'] = $request->level_id;
                $studentData['program_id'] = $request->program_id;
                $studentData['year_semester_id'] = $request->year_semester_id;
            }

            $student->update($studentData);
            $this->uploadMedias($request, $student);

            // update enrollments table
            if (!$promoted) {
                $student->enrollments()->where('student_id', $student->id)->update([
                    'academic_year_id' => $request->academic_year_id,
                    'batch_id' => $request->batch_id,
                    'program_id' => $request->program_id,
                    'year_semester_id' => $request->year_semester_id,
                    'section_id' => $request->section_id,
                    'roll' => $request->roll
                ]);
            } else {
                $student->enrollments()->where('year_semester_id', $student->year_semester_id)->update([
                    'section_id' => $request->section_id,
                    'roll' => $request->roll
                ]);
            }

            Sparent::updateOrCreate([
                'student_id' => $student->id,
            ], [
                'email' => $request->parent_email,
                'password' => bcrypt($request->fathercontact),
                'father_name' => $request->fathername,
                'father_contact' => $request->fathercontact,
                'father_job' => $request->fatherjob,
                'mother_name' => $request->mothername,
                'mother_contact' => $request->mothercontact,
                'mother_job' => $request->motherjob,
                'guardian_name' => $request->guardname,
                'guardian_email' => $request->guardemail,
                'guardian_relation' => $request->guardrelation,
                'guardian_job' => $request->guardjob,
                'guardian_contact' => $request->guardcontact,
                'guardian_address' => $request->guardaddress,
            ]);

            DB::commit();
            return redirect()->route('student.index')->with('success', 'Updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update student. ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        try {
            $student->delete();
        } catch (\Exception $e) {
            return back()->with('error', 'Cannot delete a parent year/semester. This year/semester is being used in other modules.');
        }
        return redirect()->back()->with('success', 'Deleted successfully');
    }

    public function generateQrCode()
    {
        $students = Student::all();
        foreach ($students as $student) {
            $level = $student->level->name;
            $program = $student->program->name;
            $yearSemester = $student->yearsemester->name;
            $section = $student->section->group_name;
            $qrText = "Name: $student->sname \n Admission No: $student->admission \n Roll Number: $student->roll \n Ethnicity: $student->ethnicity \n\n Level: $level \n Program: $program \n Year/Semester: $yearSemester \n Section: $section \n Gender: $student->gender";
            QrCode::generate($qrText, public_path("images\academics\students\qrcode_$student->id.svg"));
            $student->qr_code = asset("images\academics\students\qrcode_$student->id.svg");
            $student->save();
        }
        return redirect()->back()->with('success', 'QrCode Generated Successfully.');
    }

    public function resetPassword(ResetStudentPasswordRequest $request)
    {
        $this->student->resetPassword($request);

        return response()->json([
            'message' => 'Password reset successfully.'
        ], 200);
    }

    public function drop(Student $student)
    {
        $student = Student::findOrFail($student->id);
        if ($student->status == StudentStatusEnum::DROPPED) {
            session()->flash('error', 'Already dropped');
            return back();
        }

        $student->status = StudentStatusEnum::DROPPED->value;
        $success = $student->save();

        if ($success) {
            session()->flash('success', 'Dropped successfully');
        } else {
            session()->flash('error', 'Failed to drop');
        }
        return back();
    }

    public function enroll(CalendarService $calendarService)
    {
        // Check if any year semester is not set up
        if (YearSemester::whereNull('academic_year_id')->orWhereNull('batch_id')->exists()) {
            return redirect()->back()->with('error', 'Academic Year or Batch not set for some Year/Semesters. Please set up all Year/Semesters first.');
        }

        // Get IDs of already enrolled students
        $enrolledStudentIds = StudentEnrollment::pluck('student_id')->toArray();

        // Get students who are not enrolled yet and their corresponding year semesters
        $studentsToEnroll = Student::whereNotIn('id', $enrolledStudentIds)
            ->with('yearSemester')
            ->get(['id', 'program_id', 'year_semester_id', 'section_id', 'roll']);

        // Enroll students
        $enrollments = [];
        foreach ($studentsToEnroll as $student) {
            $enrollments[] = [
                'student_id' => $student->id,
                'academic_year_id' => $student->yearSemester->academic_year_id,
                'batch_id' => $student->yearSemester->batch_id,
                'program_id' => $student->program_id,
                'year_semester_id' => $student->year_semester_id,
                'section_id' => $student->section_id,
                'roll' => $student->roll,
                'enrollment_date' => $student->created_at ? $calendarService->toSystemDate($student->created_at->format('Y-m-d')) : $calendarService->today()
            ];
        }

        // Bulk insert enrollments
        StudentEnrollment::insert($enrollments);

        // Update student data
        foreach ($studentsToEnroll as $student) {
            $student->update([
                'academic_year_id' => $student->yearSemester->academic_year_id,
                'batch_id' => $student->yearSemester->batch_id
            ]);
        }

        return redirect()->back()->with('success', 'Students Enrolled Successfully.');
    }
}
