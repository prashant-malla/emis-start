<?php

namespace App\Http\Controllers\SuperAdmin\AcademicCalendar;

use App\Http\Controllers\Controller;
use App\Models\Calendar;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    private $filePath = 'upload/files/calendar/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view ('pages.calendar.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('pages.calendar.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        if ($request->hasFile('file')) {
            $fileNames = uploadFilesAsArray($request->file('file'), $this->filePath);
            $data['file'] = json_encode($fileNames);
        }

        // $calendar = new Calendar();
        // $fileNames = [];
        // if ($request->hasFile('file')) {
        //     foreach ($request->file('file') as $image) {
        //         $imageName = $image->getClientOriginalName();
        //         $filename = date('YmdHi') . '.' . $imageName;
        //         $image->move(public_path('upload/files/calendar'), $filename);
        //         $fileNames[] = $filename;
        //     }
        // }
        // $calendar->file=json_encode($fileNames);
        // $calendar->save();
        // dd($request->all());
        Calendar::create($data);
        return redirect()->route('calendar.index')->with('success', 'Created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function show(Calendar $calendar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function edit(Calendar $calendar, $id)
    {
        $calendar = Calendar::find($id);
        return view('pages.calendar.edit', [ 'calendar'=> $calendar]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Calendar $calendar)
    {
        $calendar = Calendar::findOrFail($request->id);
        $data = $request->all();

        if ($request->hasFile('file')) {
            if ($calendar->file) {
                deleteFilesAsArray(json_decode($calendar->file), $this->filePath);
            }

            $fileNames = uploadFilesAsArray($request->file('file'), $this->filePath);
            $data['file'] = json_encode($fileNames);
        }

        // $calendar = Calendar::find($request->id);
        // $fileNames = [];
        // if ($request->hasFile('file')) {
        //     foreach ($request->file('file') as $image) {
        //         $imageName = $image->getClientOriginalName();
        //         $filename = date('YmdHi') . '.' . $imageName;
        //         $image->move(public_path('upload/files/calendar'), $filename);
        //         $fileNames[] = $filename;
        //     }
        // }
        // $calendar->file=json_encode($fileNames);
        // $calendar->update();
        $calendar->update($data);
        return redirect()->route('calendar.index')->with('success', 'Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Calendar $calendar, $id)
    {
        $calendar = Calendar::findOrFail($id);
        $calendar->delete();

        if ($calendar->file) {
            deleteFilesAsArray(json_decode($calendar->file), $this->filePath);
        }

        return redirect()->back()->with('success', 'Deleted successfully');
    }
}
