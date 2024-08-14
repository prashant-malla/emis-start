<?php

namespace App\Http\Controllers\Receptionist\Skill;

use App\Exports\SkillGapExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSkillRequest;
use App\Http\Requests\UpdateSkillRequest;
use App\Models\SchoolSetting;
use App\Models\Skill;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $skills = Skill::latest()->get();
        return view('pages.skill.index', compact('skills'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $receivers = array('admin','principal','student','teacher', 'superadmin');
        return view('pages.skill.create', compact('receivers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSkillRequest $request)
    {
        $request['staff_id'] = Auth::user()->id;
        $request['message_to'] = json_encode($request->receivers);

        Skill::create($request->all());
        return redirect()->route('receptionist.skill.index')->with('success', 'Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Skill  $counsel
     * @return \Illuminate\Http\Response
     */
    public function show(Skill $skill)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Skill $skill, $id)
    {
        $skill = Skill::find($id);
        $receivers = array('admin','principal','student','teacher', 'superadmin');
        return view('pages.skill.edit', ['skill' => $skill],compact('receivers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Skill  $skill
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateSkillRequest $request, Skill $skill)
    {
        $skill = Skill::find($request->id);
        $skill->staff_id = Auth::user()->id;
        $skill-> organize = $request->organize;
        $skill-> staff = $request->staff;
        $skill->employees = $request->employees;
        $skill->objective = $request->objective;
        $skill->message_to = json_encode($request->receivers);
        $skill->update();
        return redirect()->route('receptionist.skill.index')->with('success', 'Updated Successfully');
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Skill  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Skill $skill, $id)
    {
        $skill= Skill::findOrFail($id);
        $skill ->delete();
        return redirect()->route('receptionist.skill.index')->with('success', 'Deleted successfully');
    }

    public function exportExcel()
    {
        return Excel::download(new SkillGapExport(Skill::get()), 'skill-gap-feedback-report.xlsx');
    }

    public function exportPdf()
    {
        $data['items'] = Skill::get();

        $data['title'] = 'Skill Gap Feedback Report';

        $data['settings'] = (new SchoolSetting())->first();

        $pdf = Pdf::loadView('pdf.skill_gap', $data);

        return
            $pdf
                ->download('skill-gap-feedback-report.pdf');
    }
}
