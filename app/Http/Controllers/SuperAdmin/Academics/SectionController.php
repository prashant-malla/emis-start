<?php

namespace App\Http\Controllers\SuperAdmin\Academics;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSectionRequest;
use App\Http\Requests\UpdateSectionRequest;
use App\Models\AcademicYear;
use App\Models\Batch;
use App\Models\Program;
use App\Models\Level;
use App\Models\Section;
use App\Models\YearSemester;
use Illuminate\Http\Request;

class SectionController extends Controller
{
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
        // if (!$request->academic_year_id) {
        //     $request['academic_year_id'] = $data['academicYears']->where('is_active', true)->first()?->id;
        // }
        $data['yearSemester'] = YearSemester::where([
            'program_id' => $request->program_id,
        ])->filterBy(
            $request->only(['academic_year_id', 'batch_id'])
        )->get();
        $data['groups'] = Section::query()
            ->with('level', 'program', 'yearsemester.batch')
            ->filterBy(
                $request->only(['level_id', 'program_id', 'year_semester_id', 'batch_id', 'academic_year_id'])
            )
            ->get();

        $data['filters'] = $request->all(['level_id', 'program_id', 'year_semester_id', 'batch_id', 'academic_year_id']);
        return view('pages.academics.section.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['academicYears'] = AcademicYear::latest('start_date')->get();
        $data['batches'] = Batch::latest('id')->get();
        $data['levels'] = Level::all();
        $data['programs'] = [];
        $data['yearSemesters'] = [];
        return view('pages.academics.section.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreSectionRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSectionRequest $request)
    {
        $data = $request->validated();

        Section::create($data);

        return redirect()->route('section.index')->with('success', 'Group Created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section)
    {
        $data['academicYears'] = AcademicYear::latest('start_date')->get();
        $data['batches'] = Batch::latest('id')->get();
        $data['levels'] = Level::all();
        $data['programs'] = Program::where('level_id', $section->level_id)->get();
        $data['yearSemesters'] = YearSemester::where('program_id', $section->program_id)->get();
        $data['section'] = $section;
        return view('pages.academics.section.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateSectionRequest  $request
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSectionRequest $request, Section $section)
    {
        $data = $request->validated();

        $section->update($data);

        return redirect()->route('section.index')->with('success', 'Group Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Section $section)
    {
        $section->delete();
        return redirect()->route('section.index')->with('success', 'Group Deleted successfully');
    }

    public function getProgram($id)
    {
        $programs = Program::where('level_id', $id)->get();
        return response(json_encode($programs));
    }
}
