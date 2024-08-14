<?php

namespace App\Http\Controllers\SuperAdmin\HumanResources;

use App\Http\Controllers\Controller;

use App\Http\Requests\StoreRoleRequest;

use App\Models\Role;

class RoleController extends Controller
{
    /**we
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::latest()->get();
        return view('pages.human_resource.role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.human_resource.role.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoleRequest $request)
    {
        Role::create($request->all());
        return redirect()->route('role.index')->with('success', 'Role Created Successfully.');
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
    public function edit(Role $role)
    {
        return view('pages.human_resource.role.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRoleRequest $request)
    {
        $role = Role::find($request->id);
        $role->update($request->all());
        return redirect()->route('role.index')->with('success', 'Role Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        try {
            $role->delete();
        } catch (\Exception $e){
            return back()->with('error','Cannot delete a parent role. This role is being used in other modules.');
        }
        return redirect()->back()->with('success', 'Role Deleted Successfully.');
    }
}
