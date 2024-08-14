<?php

namespace App\Http\Controllers\SuperAdmin\HumanResources;

use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Controllers\Controller;
use App\Models\Department;
use SimpleSoftwareIO\QrCode\Facades\QrCode;;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::latest()->get();
        return view('pages.human_resource.department.index', compact('departments'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.human_resource.department.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDepartmentRequest $request)
    {
        $departments= Department::where('department', '=', $request->department)->first();
        if($departments === null){
            Department::create($request->all());
            return redirect()->route('department.index')->with('success', 'Created Successfully.');
        }
        else{
            return redirect()->back()->with('error', 'Data already exists.');
        }

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
    public function edit(Department $department, $id)
    {
        $department = Department::findOrFail($id);
        return view('pages.human_resource.department.edit', ['department' => $department]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreDepartmentRequest $request, Department $department)
    {
        $department= Department::where('department', '=', $request->department)->first();
        if($department === null){
            $department =Department::find($request->id);
            $department->update($request->all());
            return redirect()->route('department.index')->with('success', 'Updated Successfully.');
        }
        else{
            return redirect()->back()->with('error', 'Data already exists.');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department, $id)
    {
        $department = Department::findOrFail($id);
        try {
            $department->delete();
        } catch (\Exception $e){
            return back()->with('error','Cannot delete a parent department. This department is being used in other modules.');
        }
        return redirect()->route('department.index')->with('success', 'Deleted Successfully');
    }
}
