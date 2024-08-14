<?php

namespace App\Http\Controllers\SuperAdmin\AcademicCalendar;

use App\Http\Controllers\Controller;
use App\Models\AcademicCalendar;
use Illuminate\Http\Request;

class AcademicCalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = AcademicCalendar::all();
        return view('pages.academic_calendar.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.academic_calendar.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd('store', $request->all());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AcademicCalendar  $academicCalendar
     * @return \Illuminate\Http\Response
     */
    public function edit(AcademicCalendar $academicCalendar)
    {
        return view('pages.academic_calendar.form')->with('data', $academicCalendar);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AcademicCalendar  $academicCalendar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AcademicCalendar $academicCalendar)
    {
        dd('update', $request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AcademicCalendar  $academicCalendar
     * @return \Illuminate\Http\Response
     */
    public function destroy(AcademicCalendar $academicCalendar)
    {
        dd('delete', $academicCalendar);
    }
}
