<?php

namespace App\Http\Controllers\Student\Grievance;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGrievanceRequest;
use App\Http\Requests\UpdateGrievanceRequest;
use App\Models\Grievance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GrievanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grievances = Grievance::where('student_id', Auth::guard('student')->user()->id)->latest()->get();
        return view('pages.grievance.index', compact('grievances'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $options = array('Harassment', 'Discrimination', 'Unfair Action', 'Physical Assault', 'Bullying', 'Sexual Abuse');
        return view('pages.grievance.create',compact('options'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGrievanceRequest $request)
    {
        $request['student_id'] = Auth::guard('student')->user()->id;
        $request['status'] = "Student";
        $request['complaint'] = $request->options;
        Grievance::create($request->all());
        return redirect()->route('student_grievance.index')->with('success', 'Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Grievance  $grievance
     * @return \Illuminate\Http\Response
     */
    public function show(Grievance $grievance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Grievance  $grievance
     * @return \Illuminate\Http\Response
     */
    public function edit(Grievance $grievance, $id)
    {
        $options = array('Harassment', 'Discrimination', 'Unfair Action', 'Physical Assault', 'Bullying', 'Sexual Abuse');
        $grievance = Grievance::find($id);
        return view('pages.grievance.edit', ['grievance' => $grievance],compact('options'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Grievance  $grievance
     * @return \Illuminate\Http\Response
     */

    public function update(UpdateGrievanceRequest $request)
    {
        $grievance = Grievance::find($request->id);
        $request['student_id'] = Auth::guard('student')->user()->id;
        $request['status'] = "Student";
        $request['complaint'] = $request->options;
        $grievance->update($request->all());
        return redirect()->route('student_grievance.index')->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Grievance  $grievance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Grievance $grievance, $id)
    {
        $grievance= Grievance::findOrFail($id);
        $grievance ->delete();
        return redirect()->route('student_grievance.index')->with('success', 'Deleted successfully');
    }
}
