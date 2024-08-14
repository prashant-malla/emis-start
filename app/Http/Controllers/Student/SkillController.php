<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSkillRequest;
use App\Http\Requests\UpdateSkillRequest;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $skills = Skill::latest()->where('student_id', Auth::guard('student')->user()->id)->get();
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
        $skill = Skill::where('organize', '=', $request->organize)
            ->where('staff', '=', $request->staff)
            ->where('employees', '=', $request->employees)
            ->where('objective', '=', $request->objective)
            ->first();
        if (is_null($skill)){
            $skill = new Skill();
            $skill->student_id = Auth::guard('student')->user()->id;
            $skill->organize = $request->organize;
            $skill->staff = $request->staff;
            $skill->employees = $request->employees;
            $skill->objective = $request->objective;
            $skill->message_to = json_encode($request->receivers);
            $skill->save();
            return redirect()->route('student.skill.index')->with('success', 'Created Successfully');
       }
        else {
          return redirect()->back()->with('error', 'Data already exists.');
        }
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
            $skill->student_id = Auth::guard('student')->user()->id;
            $skill-> organize = $request->organize;
            $skill-> staff = $request->staff;
            $skill->employees = $request->employees;
            $skill->objective = $request->objective;
            $skill->message_to = json_encode($request->receivers);
            $skill->update();

            // $event = Event::create($request->all());

            return redirect()->route('student.skill.index')->with('success', 'Updated Successfully');
            // }
            // else {
            //     return redirect()->back()->with('error', 'Data already exists.');
            // }
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
        return redirect()->route('student.skill.index')->with('success', 'Deleted successfully');    }
}
