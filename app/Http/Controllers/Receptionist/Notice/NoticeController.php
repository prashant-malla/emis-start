<?php

namespace App\Http\Controllers\Receptionist\Notice;

use App\Models\Role;
use App\Models\Level;
use App\Models\Notice;
use App\Models\Program;
use App\Models\Section;
use App\Models\NoticeRole;
use App\Models\NoticeLevel;
use App\Models\YearSemester;
use Illuminate\Http\Request;
use App\Models\NoticeProgram;
use App\Models\NoticeSection;
use App\Services\BatchService;
use App\Http\Controllers\Controller;
use App\Http\Requests\NoticeRequest;
use App\Services\AcademicYearService;

class NoticeController extends Controller
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

        $data['notices'] = Notice::query()
            ->with(['yearsemesters', 'levels', 'programs', 'sections'])
            ->filterBy($request->only(['academic_year_id', 'batch_id']))
            ->latest('id')
            ->get();

        return view('pages.notice.index', $data);
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

        $data['roles'] = Role::all();
        $data['levels'] = Level::all();
        $data['receivers'] = array('All', 'Staff', 'Student');

        return view('pages.notice.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NoticeRequest $request)
    {
        $notice = Notice::create($request->all());
        if ($notice->notice_to != 'All') {
            $notice->roles()->sync($request->role_id);
            $notice->levels()->sync($request->level_id);
            $notice->programs()->sync($request->program_id);
            $notice->yearsemesters()->sync($request->year_semester_id);
            $notice->sections()->sync($request->section_id);
        }
        return redirect()->route('receptionist.notice.index')->with('success', 'Created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Notice $notice)
    {
        return view('pages.notice.show', compact('notice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Notice $notice)
    {
        $data['academicYears'] = $this->academicYearService->getAll();
        $data['batches'] = $this->batchService->getAll();

        $notice->load(['yearSemesters', 'levels', 'programs', 'sections']);

        $data['roles'] = Role::all();
        $data['levels'] = Level::query()
            ->with('programs.yearSemesters.groups')
            ->get();
        $data['receivers'] = array('All', 'Staff', 'Student');
        $data['notice'] = $notice;

        // dd($data);
        return view('pages.notice.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(NoticeRequest $request, Notice $notice)
    {
        $notice->update($request->all());
        if ($notice->notice_to != 'All') {
            $notice->roles()->sync($request->role_id);
            $notice->levels()->sync($request->level_id);
            $notice->programs()->sync($request->program_id);
            $notice->yearsemesters()->sync($request->year_semester_id);
            $notice->sections()->sync($request->section_id);
        }
        return redirect()->route('receptionist.notice.index')->with('success', 'Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notice $notice)
    {
        $notice->roles()->detach();
        $notice->levels()->detach();
        $notice->programs()->detach();
        $notice->yearsemesters()->detach();
        $notice->sections()->detach();
        $notice->delete();
        return redirect()->route('receptionist.notice.index')->with('success', 'Deleted Successfully.');
    }
}
