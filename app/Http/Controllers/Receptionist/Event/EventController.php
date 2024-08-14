<?php

namespace App\Http\Controllers\Receptionist\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::whereHas('roles', function ($query) {
            $query->where('role_id', '=', Auth::guard('staff')->user()->role_id);
        })->orWhere('participants', '=', 'All')->get();
        return view('pages.event.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //        $roles = Role::all();
        //        $levels = Level::all();
        //        $programs = Program::all();
        //        $yearSemesters = YearSemester::all();
        //        $sections = Section::all();
        //        $participants = array('Staff','Student');
        //        return view('pages.event.create', compact('roles', 'levels', 'programs', 'yearSemesters', 'sections', 'participants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEventRequest $request)
    {
        //        $fileNames = [];
        //        if ($request->hasFile('documents')) {
        //            foreach ($request->file('documents') as $image) {
        //                $imageName = $image->getClientOriginalName();
        //                $filename = date('YmdHi') . '.' . $imageName;
        //                $image->move(public_path('upload/files/event'), $filename);
        //                $fileNames[] = $filename;
        //            }
        //        }
        //        $request['report'] = json_encode($fileNames);
        //        $event = Event::create($request->all());
        //        $event->roles()->sync($request->role_id);
        //        $event->levels()->sync($request->level_id);
        //        $event->programs()->sync($request->program_id);
        //        $event->yearsemesters()->sync($request->year_semester_id);
        //        $event->sections()->sync($request->section_id);
        //        return redirect()->route('event.index')->with('success', 'Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $counsel
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        return view('pages.event.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        //        $roles = Role::all();
        //        $levels = Level::all();
        //        $programs = Program::all();
        //        $yearSemesters = YearSemester::all();
        //        $sections = Section::all();
        //        $participants = array('Staff','Student');
        //        return view('pages.event.edit', compact('roles', 'levels', 'programs','yearSemesters', 'sections', 'participants', 'event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\RedirectResponse
     */

    public function update(UpdateEventRequest $request, Event $event)
    {
        //        $fileNames = [];
        //        if ($request->hasFile('report')) {
        //            foreach ($request->file('report') as $image) {
        //                $imageName = $image->getClientOriginalName();
        //                $filename = date('YmdHi') . '.' . $imageName;
        //                $image->move(public_path('upload/files/event'), $filename);
        //                $fileNames[] = $filename;
        //            }
        //        }
        //        $request['report'] = json_encode($fileNames);
        //        $event->update($request->all());
        //        $event->roles()->sync($request->role_id);
        //        $event->levels()->sync($request->level_id);
        //        $event->programs()->sync($request->program_id);
        //        $event->yearsemesters()->sync($request->year_semester_id);
        //        $event->sections()->sync($request->section_id);
        //    return redirect()->route('event.index')->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */

    public function destroy(Event $event)
    {
        //        $event->roles()->detach();
        //        $event->levels()->detach();
        //        $event->programs()->detach();
        //        $event->yearsemesters()->detach();
        //        $event->sections()->detach();
        //        $event ->delete();
        //        return redirect()->route('event.index')->with('success', 'Deleted successfully');
    }
}
