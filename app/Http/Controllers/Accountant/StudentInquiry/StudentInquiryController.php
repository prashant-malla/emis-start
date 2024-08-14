<?php

namespace App\Http\Controllers\Accountant\StudentInquiry;

use App\Models\Level;
use App\Models\Section;
use App\Models\Sparent;
use Illuminate\Http\Request;
use App\Models\StudentInquiry;
use App\Models\StudentCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StudentInquiryExport;
use App\Imports\StudentInquiryImport;
use App\Enum\StudentInquiryStatusEnum;
use App\Http\Requests\Receptionist\StudentInquiry\StoreStudentInquiryRequest;
use App\Http\Requests\Receptionist\StudentInquiry\UpdateStudentInquiryRequest;
use App\Models\Student;

class StudentInquiryController extends Controller
{
    public function import(Request $request)
    {
        set_time_limit(900);

        try {
            Excel::import(new StudentInquiryImport, $request->file('file')->store('excel/files'));

            session()->flash('success', 'Imported successfully');
        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage());
        }

        return to_route('accountant_student-inquiries.index');
    }

    public function export()
    {
        return Excel::download(new StudentInquiryExport, 'student-inquiries.xlsx');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $category = DB::table('student_categories')->select('id', 'category_name')->get();

        $level = DB::table('levels')->select('id', 'name')->get();

        $program = DB::table('programs')
            ->where('level_id', $request->level_id)
            ->select('id', 'name')
            ->get();

        $students = StudentInquiry::query()
            ->with('level', 'program')
            ->when($request->level_id, function ($query) use ($request) {
                return $query->where('level_id', $request->level_id);
            })
            ->when($request->program_id, function ($query) use ($request) {
                return $query->where('program_id', $request->program_id);
            })
            ->when($request->year_semester_id, function ($query) use ($request) {
                return $query->where('year_semester_id', $request->year_semester_id);
            })
            ->when($request->section_id, function ($query) use ($request) {
                return $query->where('section_id', $request->section_id);
            })
            ->when($request->status, function ($query) use ($request) {
                return $query->where('status', $request->status);
            })
            ->latest()
            ->get();

        return view('pages.student-inquiries.index', [
            'level' => $level,
            'program' => $program,
            'category' => $category,
            'filters' => $request->all(['level_id', 'program_id', 'status'])
        ], compact('students'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $level = DB::table('levels')->select('id', 'name')->get();
        $program = DB::table('programs')->select('id', 'name')->get();
        $yearSemester = DB::table('year_semesters')->select('id', 'name')->get();
        $section = DB::table('sections')->select('id', 'group_name')->get();

        $student = StudentInquiry::findOrFail($id);
        return view('pages.student-inquiries.view', [
            'level' => $level,
            'program' => $program,
            'yearSemester' => $yearSemester,
            'section' => $section,
            'student' => $student
        ]);
    }

    public function statusChange(Request $request, $id)
    {
        $studentInquiry = StudentInquiry::findOrFail($id);
        if (!$studentInquiry) {
            session()->flash('error', 'Failed to change status');
            return back();
        }

        if(Student::where('email', $studentInquiry->email)->exists()) {
            session()->flash('error', 'Failed to change status. student with same email already exists');
            return back();
        }

        if ($studentInquiry->status == StudentInquiryStatusEnum::IN_PROGRESS && $request->status == StudentInquiryStatusEnum::COMPLETED->value) {
            $result = $this->copyDataToStudentTable($studentInquiry);

            if (!$result) {
                session()->flash('error', 'Failed to change status');
                return back();
            }
        }

        $success = $studentInquiry->update([
            'status' => $request->status
        ]);

        if ($success) {
            session()->flash('success', 'Status Changed successfully');
        } else {
            session()->flash('error', 'Failed to change status');
        }

        return back();
    }

    private function copyDataToStudentTable($studentInquiry)
    {
        try {
            $existingStudent = Student::where('email', $studentInquiry->email)->first();

            if (!$existingStudent) {
                DB::beginTransaction();

                // create a student
                $student = Student::create([
                    'sname' => $studentInquiry->name,
                    'email' => $studentInquiry->email,
                    'password' => bcrypt($studentInquiry->phone),
                    'ethnicity' => $studentInquiry->ethnicity,
                    'level_id' => $studentInquiry->level_id,
                    'program_id' => $studentInquiry->program_id,
                    'year_semester_id' => $studentInquiry->year_semester_id,
                    'section_id' => $studentInquiry->section_id,
                    'admission' => '',
                    'rolle' => '',
                    'phone' => $studentInquiry->phone,
                    'dob' => $studentInquiry->dob,
                    'gender' => $studentInquiry->gender,
                    'caddress' => $studentInquiry->caddress,
                    'paddress' => $studentInquiry->paddress,
                    'caste' => $studentInquiry->caste,
                    'religion' => $studentInquiry->religion,
                ]);

                // add media to studnet
                // if ($studentInquiry->file('profile_image')) {
                //     $student->addMedia($studentInquiry->file('profile_image'))->toMediaCollection();
                // }
                // if ($studentInquiry->file('slc_certificate')) {
                //     $student->addMedia($studentInquiry->file('slc_certificate'))->toMediaCollection('slc_certificate');
                // }
                // if ($studentInquiry->file('high_school_certificate')) {
                //     $student->addMedia($studentInquiry->file('high_school_certificate'))->toMediaCollection('high_school_certificate');
                // }
                // if ($studentInquiry->file('other_certificate')) {
                //     $student->addMedia($studentInquiry->file('other_certificate'))->toMediaCollection('other_certificate');
                // }

                // create parent of student
                $parent = Sparent::create([
                    'student_id' => $student->id,
                    'email' => $studentInquiry->parent_email,
                    'password' => bcrypt($studentInquiry->father_contact),
                    'father_name' => $studentInquiry->father_name,
                    'father_contact' => $studentInquiry->father_contact,
                    'father_job' => $studentInquiry->father_job,
                    'mother_name' => $studentInquiry->mother_name,
                    'mother_contact' => $studentInquiry->mother_contact,
                    'mother_job' => $studentInquiry->mother_job,
                    'guardian_name' => $studentInquiry->guardian_name,
                    'guardian_email' => $studentInquiry->guardian_email,
                    'guardian_relation' => $studentInquiry->guardian_relation,
                    'guardian_job' => $studentInquiry->guardian_job,
                    'guardian_contact' => $studentInquiry->guardian_contact,
                    'guardian_address' => $studentInquiry->guardian_address,
                ]);

                if ($student && $parent) {
                    DB::commit();
                    return true;
                } else {
                    DB::rollBack();
                    return false;
                }
            } else {
                session()->flash('error', 'Student already exists');
                return true;
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Failed to copy data to student table: ' . $th->getMessage());
            return false;
        }
    }
}
