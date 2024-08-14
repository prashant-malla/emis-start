<?php

namespace App\Http\Controllers\SuperAdmin\Meeting;

use App\Models\Level;
use App\Models\Eclass;
use App\Models\Meeting;
use App\Models\Program;
use App\Models\Section;
use App\Models\YearSemester;
use Illuminate\Http\Request;
use App\Models\StaffDirectory;
use App\Services\BatchService;
use App\Services\ProgramService;
use App\Http\Controllers\Controller;
use App\Http\Requests\MeetingRequest;
use App\Services\AcademicYearService;
use App\Services\YearSemesterService;

class MeetingController extends Controller
{
    public function __construct(protected AcademicYearService $academicYearService, protected BatchService $batchService, protected ProgramService $programService, protected YearSemesterService $yearSemesterService)
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

        // set initial academic year id
        $request->merge(['academic_year_id' => $request->academic_year_id ?? $data['academicYears']->where('is_active', 1)->first()->id]);

        $data['level'] = Level::select('id', 'name')->get();
        $data['program'] = Program::select('id', 'name')->get();
        $data['yearSemester'] = YearSemester::select('id', 'name')->get();
        $data['section'] = Section::select('id', 'group_name')->get();
        $data['staff'] = new StaffDirectory();
        $data['teacher'] = $data['staff']->whereHas('role', function ($query) {
            $query->where('role', 'Teacher');
        });
        $data['meeting'] = Meeting::filterBy($request->only('academic_year_id', 'batch_id'))->get();
        return view('pages.meeting.index', $data,);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['academicYears'] = $this->academicYearService->getAll();
        $data['batches'] = $this->batchService->getAll();

        $data['levels'] = Level::select('id', 'name')->get();

        return view('pages.meeting.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MeetingRequest $request)
    {
        $meeting = new Meeting();
        $meeting->level_id = $request->level_id;
        $meeting->program_id = $request->program_id;
        $meeting->year_semester_id = $request->year_semester_id;
        $meeting->section_id = $request->section_id;
        $meeting->teacher_id = $request->teacher_id;
        $meeting->meeting_date = $request->meeting_date;
        $meeting->meeting_time = $request->meeting_time;
        $meeting->note = $request->note;
        $meeting->link = $request->link;
        $fileNames = [];
        if ($request->hasFile('document')) {
            foreach ($request->file('document') as $image) {
                $imageName = $image->getClientOriginalName();
                $filename = date('YmdHi') . '.' . $imageName;
                $image->move(public_path('upload/files/meeting'), $filename);
                $fileNames[] = $filename;
            }
        }
        $meeting->document = json_encode($fileNames);
        $meeting->save();
        return redirect()->route('meeting.index')->with('success', 'Created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function show(Meeting $meeting, $id)
    {
        $level = Level::select('id', 'name')->get();
        $program = Program::select('id', 'name')->get();
        $yearSemester = YearSemester::select('id', 'name')->get();
        $section = Section::select('id', 'group_name')->get();
        $staff = new StaffDirectory();
        $teacher = $staff->whereHas('role', function ($query) {
            $query->where('role', 'Faculty Member');
        });
        $meeting = Meeting::findOrFail($id);
        return view('pages.meeting.show', ['level' => $level, 'program' => $program, 'yearSemester' => $yearSemester, 'section' => $section,  'teacher' => $teacher->get()], compact('meeting'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['academicYears'] = $this->academicYearService->getAll();
        $data['batches'] = $this->batchService->getAll();
        $data['levels'] = Level::query()
            ->with('programs.yearSemesters.groups')
            ->get();

        $data['meeting'] = Meeting::find($id);

        // $level = Level::select('id', 'name')->get();
        $data['programs'] = Program::where('level_id', $data['meeting']->level_id)->select('id', 'name')->get();
        $data['yearSemesters'] = YearSemester::where('program_id', $data['meeting']->program_id)->select('id', 'name')->get();
        $data['sections'] = Section::where('year_semester_id', $data['meeting']->year_semester_id)->select('id', 'group_name')->get();

        $data['teachers'] = StaffDirectory::whereHas('teacher_assigns', function ($query) use ($data) {
            $query->where('level_id', $data['meeting']->level_id)->where('program_id', $data['meeting']->program_id)
                ->where('year_semester_id', $data['meeting']->year_semester_id)
                ->where('section_id', $data['meeting']->section_id);
        })->get();
        
        return view('pages.meeting.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function update(MeetingRequest $request)
    {
        $meeting = Meeting::find($request->id);
        $meeting->level_id = $request->level_id;
        $meeting->program_id = $request->program_id;
        $meeting->year_semester_id = $request->year_semester_id;
        $meeting->section_id = $request->section_id;
        $meeting->teacher_id = $request->teacher_id;
        $meeting->meeting_date = $request->meeting_date;
        $meeting->meeting_time = $request->meeting_time;
        $meeting->note = $request->note;
        $meeting->link = $request->link;
        $fileNames = [];
        if ($request->hasFile('document')) {
            foreach ($request->file('document') as $image) {
                $imageName = $image->getClientOriginalName();
                $filename = date('YmdHi') . '.' . $imageName;
                $image->move(public_path('upload/files/meeting'), $filename);
                $fileNames[] = $filename;
            }
        }
        $meeting->document = json_encode($fileNames);
        $meeting->update();
        return redirect()->route('meeting.index')->with('success', 'Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Meeting $meeting)
    {
        $meeting = Meeting::findOrFail($id);
        $meeting->delete();
        return redirect()->route('meeting.index')->with('success', 'Deleted successfully');
    }
}
