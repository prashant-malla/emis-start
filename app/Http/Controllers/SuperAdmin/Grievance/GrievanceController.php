<?php

namespace App\Http\Controllers\SuperAdmin\Grievance;

use App\Models\Grievance;
use Illuminate\Http\Request;
use App\Models\SchoolSetting;
use App\Services\BatchService;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\GrievanceExport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\AcademicYearService;
use App\Http\Requests\StoreGrievanceRequest;
use App\Http\Requests\UpdateGrievanceRequest;

class GrievanceController extends Controller
{
    public function __construct(protected AcademicYearService $academicYearService, protected BatchService $batchService)
    {
        //    
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['academicYears'] = $this->academicYearService->getAll();
        $data['batches'] = $this->batchService->getAll();

        // set initial academic year id
        // $request->merge(['academic_year_id' => $request->academic_year_id ?? $data['academicYears']->where('is_active', 1)->first()->id]);

        $data['grievances'] = Grievance::latest()->get();
        return view('pages.grievance.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $options = array('Harassment', 'Discrimination', 'Unfair Action', 'Physical Assault', 'Bullying', 'Sexual Abuse');
        return view('pages.grievance.create', compact('options'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGrievanceRequest $request)
    {
        $request['user_id'] = Auth::user()->id;
        $request['status'] = "SuperAdmin";
        $request['complaint'] = $request->options;
        Grievance::create($request->all());
        return redirect()->route('grievance.index')->with('success', 'Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Grievance  $grievance
     * @return \Illuminate\Http\Response
     */
    public function show(Grievance $grievance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Grievance  $grievance
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $options = array('Harassment', 'Discrimination', 'Unfair Action', 'Physical Assault', 'Bullying', 'Sexual Abuse');
        $grievance = Grievance::find($id);
        return view('pages.grievance.edit', ['grievance' => $grievance], compact('options'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Grievance  $grievance
     * @return \Illuminate\Http\Response
     */

    public function update(UpdateGrievanceRequest $request, Grievance $grievance)
    {
        $grievance = Grievance::find($request->id);
        $request['user_id'] = Auth::user()->id;
        $request['status'] = "SuperAdmin";
        $request['complaint'] = $request->options;
        $grievance->update($request->all());
        return redirect()->route('grievance.index')->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Grievance  $grievance
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $grievance = Grievance::findOrFail($id);
        $grievance->delete();
        return redirect()->route('grievance.index')->with('success', 'Deleted successfully');
    }

    public function exportExcel()
    {
        return Excel::download(new GrievanceExport(Grievance::get()), 'grievance.xlsx');
    }

    public function exportPdf()
    {
        $data['items'] = Grievance::get();

        $data['title'] = 'Grievance Report';

        $data['settings'] = (new SchoolSetting())->first();

        $pdf = Pdf::loadView('pdf.grievance', $data);

        return
            $pdf
                ->download('grievance.pdf');
    }
}
