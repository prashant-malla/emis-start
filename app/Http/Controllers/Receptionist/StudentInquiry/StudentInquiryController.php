<?php

namespace App\Http\Controllers\Receptionist\StudentInquiry;

use App\Models\Level;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Models\StudentInquiry;
use App\Models\StudentCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Enum\StudentInquiryStatusEnum;
use App\Exports\StudentInquiryExport;
use App\Http\Requests\Receptionist\StudentInquiry\StoreStudentInquiryRequest;
use App\Http\Requests\Receptionist\StudentInquiry\UpdateStudentInquiryRequest;
use App\Imports\StudentInquiryImport;

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

        return to_route('receptionist.student-inquiries.index');
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = StudentCategory::select('id', 'category_name')->get();
        $levels = DB::table('levels')->select('id', 'name')->get();
        $program = DB::table('programs')->select('id', 'name')->get();
        $yearSemester = DB::table('year_semesters')->select('id', 'name')->get();
        $section = Section::select('id', 'group_name')->get();

        return view('pages.student-inquiries.create', compact('category', 'levels', 'program', 'yearSemester', 'section'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStudentInquiryRequest $request)
    {
        $validated = $request->validated();

        $storeStudent = StudentInquiry::create($validated);

        if ($storeStudent) {
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
        }
        return redirect()->route('receptionist.student-inquiries.index')->with('success', 'Created successfully');
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['levels'] = Level::query()
            ->with('programs.yearSemesters.groups')
            ->get();

        $data['student'] = StudentInquiry::findOrFail($id);

        return view('pages.student-inquiries.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStudentInquiryRequest $request, $id)
    {
        $student = StudentInquiry::findOrFail($id);

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
        $validated = $request->validated();

        $student->update($validated);

        return redirect()->route('receptionist.student-inquiries.index')->with('success', 'Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $student = StudentInquiry::findOrFail($id);
            $student->delete();
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
        return redirect()->back()->with('success', 'Deleted successfully');
    }
}
