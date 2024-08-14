<?php

namespace App\Http\Controllers\SuperAdmin\Stake;

use App\Exports\StakeHolderExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStakeRequest;
use App\Http\Requests\UpdateStakeRequest;
use App\Models\SchoolSetting;
use App\Models\Stake;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class StakeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stakes = Stake::latest()->get();
        return view('pages.stake.index', compact('stakes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $options = array('Academic/educational', 'Management/administration/governance', 'Student support service',
            'Infrastructure/facilities/services', 'Research and Extension', 'Communication/Publication', 'Other');
        return view('pages.stake.create',compact('options'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStakeRequest $request)
    {
        $request['area'] = $request->options;
        $request['user_id'] = Auth::user()->id;
        Stake::create($request->all());
        return redirect()->route('stake.index')->with('success', 'Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stake  $grievance
     * @return \Illuminate\Http\Response
     */
    public function show(Stake $stake)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stake  $grievance
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $options = array('Academic/educational', 'Management/administration/governance', 'Student support service',
            'Infrastructure/facilities/services', 'Research and Extension', 'Communication/Publication', 'Other');
        $stake = Stake::find($id);
        return view('pages.stake.edit', ['stake' => $stake],compact('options'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Stake  $grievance
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStakeRequest $request)
    {
        $stake = Stake::find($request->id);
        $request['area'] = $request->options;
        $request['user_id'] = Auth::user()->id;
        $stake->update($request->all());
        return redirect()->route('stake.index')->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Grievance  $grievance
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $stake= Stake::findOrFail($id);
        $stake ->delete();
        return redirect()->route('stake.index')->with('success', 'Deleted successfully');
    }

    public function exportExcel()
    {
        return Excel::download(new StakeHolderExport(Stake::get()), 'stakeholder.xlsx');
    }

    public function exportPdf()
    {
        $data['items'] = Stake::get();

        $data['title'] = 'Stakeholder Report';

        $data['settings'] = (new SchoolSetting())->first();

        $pdf = Pdf::loadView('pdf.stakeholder', $data);

        return
            $pdf
                ->download('stakeholder.pdf');
    }
}
