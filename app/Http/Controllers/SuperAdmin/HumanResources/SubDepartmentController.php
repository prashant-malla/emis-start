<?php

namespace App\Http\Controllers\SuperAdmin\HumanResources;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubDepartmentRequest;
use App\Models\Department;
use App\Models\SubDepartment;
use Illuminate\Http\Request;

class SubDepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subDepartments = SubDepartment::all();
        return view('pages.human_resource.sub_department.index', compact('subDepartments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::whereNotIn('department', ['Faculty Member', 'Teaching'])->get();
        return view('pages.human_resource.sub_department.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubDepartmentRequest $request)
    {
        SubDepartment::create($request->all());
        return redirect()->route('sub_department.index')->with('success', 'Sub-Department created successfully');
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
    public function edit(SubDepartment $subDepartment)
    {
        $departments = Department::all();
        return view('pages.human_resource.sub_department.create', compact('subDepartment', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SubDepartmentRequest $request, SubDepartment $subDepartment)
    {
        $subDepartment->update($request->all());
        return redirect()->route('sub_department.index')->with('success', 'Sub-Department updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubDepartment $subDepartment)
    {
        try {
            $subDepartment->delete();
        } catch (\Exception $e){
            return back()->with('error','Cannot delete a parent sub-department. This sub-department is being used in other modules.');
        }
        return redirect()->route('sub_department.index')->with('success', 'Sub-Department deleted successfully');
    }
}
