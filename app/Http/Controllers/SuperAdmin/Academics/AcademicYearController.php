<?php

namespace App\Http\Controllers\SuperAdmin\Academics;

use App\Http\Controllers\Controller;
use App\Http\Requests\AcademicYearRequest;
use App\Models\AcademicYear;

class AcademicYearController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['rows'] = AcademicYear::latest('start_date')->get();
        return view('pages.academics.academic_year.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.academics.academic_year.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AcademicYearRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AcademicYearRequest $request)
    {
        $data = $request->validated();

        if ($data['is_active']) {
            AcademicYear::query()->update(['is_active' => 0]);
        }

        AcademicYear::create($data);

        return
            redirect(route('academic-year.index'))
            ->withSuccess('Academic Year created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  AcademicYear $academicYear
     * @return \Illuminate\Http\Response
     */
    public function edit(AcademicYear $academicYear)
    {
        return view('pages.academics.academic_year.form', ['data' => $academicYear]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AcademicYearRequest $request
     * @param  AcademicYear $academicYear
     * @return \Illuminate\Http\Response
     */
    public function update(AcademicYearRequest $request, AcademicYear $academicYear)
    {
        $data = $request->validated();

        if ($data['is_active'] && !$academicYear->is_active) {
            AcademicYear::query()->update(['is_active' => 0]);
        }

        $academicYear->update($data);

        return
            redirect(route('academic-year.index'))
            ->withSuccess('Academic Year updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  AcademicYear $academicYear
     * @return \Illuminate\Http\Response
     */
    public function destroy(AcademicYear $academicYear)
    {
        $academicYear->delete();

        return
            redirect(route('academic-year.index'))
            ->withSuccess('Academic Year deleted successfully');
    }
}
