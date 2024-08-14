<?php

namespace App\Http\Controllers\SuperAdmin\Event;

use App\Exports\ExportCounsel;
use App\Exports\ExportEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Counsel;
use App\Models\Event;
use App\Models\Program;
use App\Models\Level;
use App\Models\Role;
use App\Models\SchoolSetting;
use App\Models\Section;
use App\Models\YearSemester;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;

class EventController extends Controller
{
    private $filePath = 'upload/files/event/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::latest()->get();
        return view('pages.event.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        $levels = Level::all();
        $programs = Program::all();
        $yearSemesters = YearSemester::all();
        $sections = Section::all();
        $participants = array('All', 'Staff', 'Student');
        return view('pages.event.create', compact('roles', 'levels', 'programs', 'yearSemesters', 'sections', 'participants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEventRequest $request)
    {
        if ($request->hasFile('documents')) {
            $fileNames = uploadFilesAsArray($request->file('documents'), $this->filePath);
            $request['report'] = json_encode($fileNames);
        }

        $event = Event::create($request->all());
        if ($event->participants != 'All') {
            $event->roles()->sync($request->role_id);
            $event->levels()->sync($request->level_id);
            $event->programs()->sync($request->program_id);
            $event->yearsemesters()->sync($request->year_semester_id);
            $event->sections()->sync($request->section_id);
        }
        return redirect()->route('event.index')->with('success', 'Created Successfully');
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
        $levelId = count($event->levels) > 0 ? $event->levels->first()->id : null;
        $programId = count($event->programs) > 0 ? $event->programs->first()->id : null;
        $yearSemesterId = count($event->yearSemesters) > 0 ? $event->yearSemesters->first()->id : null;

        $roles = Role::all();
        $levels = Level::all();
        $programs = Program::where('level_id', $levelId)->get();
        $yearSemesters = YearSemester::where('program_id', $programId)->get();
        $sections = Section::where('year_semester_id', $yearSemesterId)->get();
        $participants = array('All', 'Staff', 'Student');
        return view('pages.event.edit', compact('roles', 'levels', 'programs', 'yearSemesters', 'sections', 'participants', 'event'));
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
        if ($request->hasFile('documents')) {
            if ($event->report) {
                deleteFilesAsArray(json_decode($event->report), $this->filePath);
            }

            $fileNames = uploadFilesAsArray($request->file('documents'), $this->filePath);
            $request['report'] = json_encode($fileNames);
        }

        $event->update($request->all());
        if ($event->participants != 'All') {
            $event->roles()->sync($request->role_id);
            $event->levels()->sync($request->level_id);
            $event->programs()->sync($request->program_id);
            $event->yearsemesters()->sync($request->year_semester_id);
            $event->sections()->sync($request->section_id);
        }
        return redirect()->route('event.index')->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $event->roles()->detach();
        $event->levels()->detach();
        $event->programs()->detach();
        $event->yearsemesters()->detach();
        $event->sections()->detach();
        $event->delete();

        if ($event->report) {
            deleteFilesAsArray(json_decode($event->report), $this->filePath);
        }

        return redirect()->route('event.index')->with('success', 'Deleted successfully');
    }

    public function destroyImage(Request $request, Event $event)
    {
        $documents = array_diff(json_decode($event->report), [$request->file]);

        $path = public_path($this->filePath . $request->file);
        if (File::exists($path)) {
            unlink($path);
        }

        $event->update([
            'report' => json_encode($documents)
        ]);
    }

    public function exportExcel()
    {
        return Excel::download(new ExportEvent(Event::get()), 'event-report.xlsx');
    }

    public function exportPdf()
    {
        $data['items'] = Event::get();

        $data['title'] = 'Event Report';

        $data['settings'] = (new SchoolSetting())->first();

        $pdf = Pdf::loadView('pdf.event', $data);

        return
            $pdf
            ->download('event-report.pdf');
    }
}
