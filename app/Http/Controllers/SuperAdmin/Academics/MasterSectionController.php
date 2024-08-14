<?php

namespace App\Http\Controllers\SuperAdmin\Academics;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMasterSectionRequest;
use App\Http\Requests\UpdateMasterSectionRequest;
use App\Models\MasterSection;

class MasterSectionController extends Controller
{
    protected $title = 'Master Group';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $data['mastersections'] = MasterSection::get();

        $data['title'] = $this->title;

        return view('pages.academics.master_section.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $data['title'] = $this->title;

        return view('pages.academics.master_section.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreMasterSectionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreMasterSectionRequest $request)
    {
        $data = $request->validated();

        MasterSection::create($data);

        return redirect()->route('master-section.index')->withSuccess('Master Group created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MasterSection  $mastersection
     * @return \Illuminate\View\View
     */
    public function show(MasterSection $mastersection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MasterSection  $mastersection
     * @return \Illuminate\View\View
     */
    public function edit(MasterSection $master_section)
    {
        $data['title'] = $this->title;
        $data['mastersection'] = $master_section;

        return view('pages.academics.master_section.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateMasterSectionRequest $request
     * @param  \App\Models\MasterSection  $mastersection
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateMasterSectionRequest $request, MasterSection $master_section)
    {
        $data = $request->validated();

        $master_section->update($data);

        return redirect()->route('master-section.index')->withSuccess('Master Group updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MasterSection  $mastersection
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(MasterSection $master_section)
    {
        $master_section->delete();

        return redirect()->route('master-section.index')->withSuccess('Master Group deleted successfully');
    }
}
