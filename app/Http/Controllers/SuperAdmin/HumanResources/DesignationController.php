<?php

namespace App\Http\Controllers\SuperAdmin\HumanResources;

use App\Http\Controllers\Controller;

use App\Http\Requests\StoreDesignationRequest;

use App\Models\Department;
use App\Models\Designation;
use App\Models\SubDepartment;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $designations = Designation::all();
        return view('pages.human_resource.designation.index', compact('designations'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::all();
        $subDepartments = SubDepartment::all();
        return view('pages.human_resource.designation.create', compact('departments', 'subDepartments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDesignationRequest $request)
    {
        Designation::create($request->all());
        return redirect()->route('designation.index')->with('success', 'Designation Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Designation $designation)
    {
        $departments = Department::all();
        $subDepartments = SubDepartment::with('department')->get();
        return view('pages.human_resource.designation.create', compact('departments', 'subDepartments', 'designation'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreDesignationRequest $request, Designation $designation)
    {
        $designation->update($request->all());
        return redirect()->route('designation.index')->with('success', 'Designation Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $designation = Designation::findOrFail($id);
        try {
            $designation->delete();
        } catch (\Exception $e){
            return back()->with('error','Cannot delete a parent designation. This designation is being used in other modules.');
        }
        return redirect()->back()->with('success', 'Deleted Successfully');
    }
}
