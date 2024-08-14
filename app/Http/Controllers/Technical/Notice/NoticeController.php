<?php

namespace App\Http\Controllers\Technical\Notice;

use App\Models\Role;
use App\Models\Level;
use App\Models\Notice;
use App\Models\Program;
use App\Models\Section;
use App\Models\NoticeRole;
use App\Models\NoticeLevel;
use Illuminate\Http\Request;
use App\Models\NoticeProgram;
use App\Models\NoticeSection;
use App\Services\BatchService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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

        $data['notices'] = Notice::whereHas('roles', function ($query) {
            $query->where('role_id', '=', Auth::guard('staff')->user()->role_id);
        })
            ->orWhere('notice_to', 'All')
            ->filterBy($request->only(['academic_year_id', 'batch_id']))
            ->get();
        return  view('pages.notice.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //    public function create()
    //    {
    //        $roles = Role::all();
    //        $levels = Level::all();
    //        $programs = Program::all();
    //        $sections = Section::all();
    //        $receivers = array('Staff','Student');
    //        return view('pages.notice.create', compact('roles', 'levels', 'programs', 'sections', 'receivers'));
    //    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //    public function store(Request $request)
    //    {
    //        $notice = Notice::create($request->all());
    //        $notice->roles()->sync($request->role_id);
    //        $notice->levels()->sync($request->level_id);
    //        $notice->programs()->sync($request->program_id);
    //        $notice->sections()->sync($request->section_id);
    //        return redirect()->route('notice.index')->with('success', 'Created successfully');
    //    }

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
    //    public function edit(Notice $notice)
    //    {
    //        $roles = Role::all();
    //        $levels = Level::all();
    //        $programs = Program::all();
    //        $sections = Section::all();
    //        $receivers = array('Staff','Student');
    //        return view('pages.notice.edit', compact('notice', 'roles', 'levels', 'programs', 'sections', 'receivers'));
    //    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //    public function update(Request $request, Notice $notice)
    //    {
    //        $notice->update($request->all());
    //        $notice->roles()->sync($request->role_id);
    //        $notice->levels()->sync($request->level_id);
    //        $notice->programs()->sync($request->program_id);
    //        $notice->sections()->sync($request->section_id);
    //        return redirect()->route('notice.index')->with('success', 'Updated Successfully.');
    //    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //    public function destroy(Notice $notice)
    //    {
    //        $notice->roles()->detach();
    //        $notice->levels()->detach();
    //        $notice->programs()->detach();
    //        $notice->sections()->detach();
    //        $notice->delete();
    //        return redirect()->route('notice.index')->with('success', 'Deleted Successfully.');
    //    }
}
