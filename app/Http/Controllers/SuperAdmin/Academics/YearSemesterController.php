<?php

namespace App\Http\Controllers\SuperAdmin\Academics;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreYearSemesterRequest;
use App\Http\Requests\UpdateYearSemesterRequest;
use App\Models\AcademicYear;
use App\Models\Batch;
use App\Models\Program;
use App\Models\Level;
use App\Models\MasterSection;
use App\Models\Section;
use App\Models\YearSemester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class YearSemesterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['batches'] = Batch::select('id', 'title')->latest()->get();
        $data['programs'] = Program::select('id', 'name')->latest()->get();
        $data['yearSemesters'] = YearSemester::query()
            ->with(['program', 'batch'])
            ->filterBy(
                $request->only(['program_id', 'batch_id'])
            )
            ->orderBy('term_number')
            ->get();
        return view('pages.academics.year_semester.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['programs'] = Program::latest('id')->get();

        $data['batches'] = Batch::latest('id')->get();

        $data['unassignedYearSemesterExists'] = YearSemester::whereNull('batch_id')->orWhereNull('program_id')->exists();

        $data['masterGroups'] = MasterSection::select('id', 'title')->get();

        $data['academicYears'] = AcademicYear::select('id', 'title', 'start_date', 'end_date')->get();

        return view('pages.academics.year_semester.form-v2', $data);
    }

    private function deleteYearSemester($yearSemesterId)
    {
        if (!$yearSemesterId) {
            return;
        }

        Section::where('year_semester_id', $yearSemesterId)->delete();
        YearSemester::find($yearSemesterId)->delete();
    }

    private function createYearSemester($item, $masterSectionIds)
    {
        $yearSemester = YearSemester::create($item);
        $masterSections = MasterSection::whereIn('id', $masterSectionIds)->get();
        foreach ($masterSections as $masterSection) {
            $yearSemester->sections()->create([
                'master_section_id' => $masterSection->id,
                'group_name' => $masterSection->title,
                'program_id' => $item['program_id'],
                'level_id' => $item['level_id'],
            ]);
        }
    }

    private function updateYearSemester($id, $item, $masterSectionIds)
    {
        $yearSemester = YearSemester::find($id);
        $yearSemester->update($item);

        $yearSemesterGroups = $yearSemester->sections;

        // delete unchecked sections
        $deletedSectionIds = $yearSemesterGroups->whereNotIn('master_section_id', $masterSectionIds)->pluck('id');
        if ($deletedSectionIds->count() > 0) {
            try {
                Section::whereIn('id', $deletedSectionIds)->delete();
            } catch (\Exception $e) {
                throw new \ErrorException('Cannot delete section which is being used in other modules.');
            }
        }

        // update or create sections
        $masterSections = MasterSection::whereIn('id', $masterSectionIds)->get();
        foreach ($masterSections as $masterSection) {
            $yearSemester->sections()->updateOrCreate([
                'master_section_id' => $masterSection->id,
            ], [
                'group_name' => $masterSection->title,
                'program_id' => $item['program_id'],
                'level_id' => $item['level_id'],
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreYearSemesterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreYearSemesterRequest $request)
    {
        $data = $request->validated();

        $redirectParams = [
            'program_id' => $data['program_id'],
            'batch_id' => $data['batch_id'],
        ];

        $program = Program::find($request->program_id);

        // common values
        $item = [
            'batch_id' => $data['batch_id'],
            'program_id' => $program->id,
            'type' => $program->type,
            'level_id' => $program->level_id,
        ];

        try {
            DB::beginTransaction();

            // create/update/delete year/semesters
            foreach ($data['rowIndex'] as $i) {
                $yearSemesterId = $data['id'][$i];
                $masterSectionIds = $data['master_section_id'][$i] ?? [];
                $isDeleted = $data['is_deleted'][$i];

                if ($isDeleted) {
                    $this->deleteYearSemester($yearSemesterId);
                    continue;
                }

                // fill individual data
                $item['name'] = $data['name'][$i];
                $item['term_number'] = $data['term_number'][$i];
                $item['start_date'] = $data['start_date'][$i];
                $item['end_date'] = $data['end_date'][$i];
                $item['is_active'] = $data['is_active'][$i];
                $item['academic_year_id'] = $data['academic_year_id'][$i];

                if (is_null($yearSemesterId) || $yearSemesterId === "") {
                    // create year/semesters with group names
                    $this->createYearSemester($item, $masterSectionIds);
                } else {
                    // update year/semesters with group names
                    $this->updateYearSemester($yearSemesterId, $item, $masterSectionIds);
                }
            }

            DB::commit();
            return
                redirect()
                ->route('year-semester.create', $redirectParams)
                ->with('success', 'Saved Successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return
                redirect()
                ->route('year-semester.create', $redirectParams)
                ->with('error', 'Failed to save year/semesters. ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\YearSemester  $yearSemester
     * @return \Illuminate\Http\Response
     */
    public function show(YearSemester $yearSemester)
    {
        return $yearSemester->related_data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\YearSemester  $yearSemester
     * @return \Illuminate\Http\Response
     */
    public function edit(YearSemester $yearSemester)
    {
        $data['academicYears'] = AcademicYear::latest('start_date')->get();
        $data['batches'] = Batch::latest('id')->get();
        $data['levels'] = Level::all();
        $data['programs'] = Program::where('level_id', $yearSemester->level_id)->get();
        $data['yearSemester'] = $yearSemester;
        return view('pages.academics.year_semester.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateYearSemesterRequest  $request
     * @param  \App\Models\YearSemester  $yearSemester
     * @return \Illuminate\Http\Responses
     */
    public function update(UpdateYearSemesterRequest $request, YearSemester $yearSemester)
    {
        $data = $request->validated();

        if ($yearSemester->program_id != $request->program_id) {
            $program = Program::find($request->program_id);
            $data['type'] = $program->type;
        }

        $yearSemester->update($data);
        return redirect()->route('year-semester.index')->with('success', 'Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\YearSemester  $yearSemester
     * @return \Illuminate\Http\Response
     */
    public function destroy(YearSemester $yearSemester)
    {
        $yearSemester->delete();
        return redirect()->route('year-semester.index')->with('success', 'Deleted successfully');
    }
}
