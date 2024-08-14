<?php

namespace App\Http\Controllers\Receptionist\FrontOffice;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdmissionInquiryRequest;
use App\Http\Requests\UpdateAdmissionInquiryRequest;
use App\Models\AdmissionInquiry;
use App\Models\Eclass;
use App\Models\Program;
use App\Models\Level;
use App\Models\Reference;
use App\Models\Source;
use App\Models\Staff;
use App\Models\YearSemester;
use Illuminate\Http\Request;

class AdmissionInquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $level = Level::select('id', 'name')->get();
        $program = Program::select('id', 'name')->get();
        $yearSemester = YearSemester::select('id', 'name')->get();
        $reference = Reference::select('id', 'reference')->get();
        $source = Source::select('id', 'source')->get();
        $admissionInquiry = AdmissionInquiry::all();
        return view('pages.front_office.admission_inquiry.index', ['level' => $level, 'program' => $program, 'yearSemester' => $yearSemester, 'reference' => $reference, 'source' => $source], compact('admissionInquiry'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $level = Level::select('id', 'name')->get();
        $program = Program::select('id', 'name')->get();
        $yearSemester = YearSemester::select('id', 'name')->get();
        $reference = Reference::select('id', 'reference')->get();
        $source = Source::select('id', 'source')->get();
        return view('pages.front_office.admission_inquiry.create', ['level' => $level, 'program' => $program, 'yearSemester' => $yearSemester, 'reference' => $reference, 'source' => $source]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreAdmissionInquiryRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdmissionInquiryRequest $request)
    {
        $admissionInquiry = AdmissionInquiry::where('full_name', '=', $request->full_name)
            ->where('phone', '=', $request->phone)
            ->where('source_id', '=', $request->source_id)
            ->first();
        if (is_null($admissionInquiry)) {
            AdmissionInquiry::create($request->all());
            return redirect()->route('admission-inquiry.index')->with('success', 'Created successfully');
        } else {
            return redirect()->back()->with('error', 'Data already exists.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AdmissionInquiry  $admissionInquiry
     * @return \Illuminate\Http\Response
     */
    public function show(AdmissionInquiry $admissionInquiry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AdmissionInquiry  $admissionInquiry
     * @return \Illuminate\Http\Response
     */
    public function edit(AdmissionInquiry $admissionInquiry, $id)
    {
        $level = Level::select('id', 'name')->get();
        $program = Program::select('id', 'name')->get();
        $yearSemester = YearSemester::select('id', 'name')->get();
        $reference = Reference::select('id', 'reference')->get();
        $source = Source::select('id', 'source')->get();
        $admissionInquiry = AdmissionInquiry::findOrFail($id);
        return view('pages.front_office.admission_inquiry.edit', ['level' => $level, 'program' => $program, 'yearSemester' => $yearSemester, 'reference' => $reference, 'source' => $source, 'admissionInquiry' => $admissionInquiry]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdateAdmissionInquiryRequest  $request
     * @param  \App\Models\AdmissionInquiry  $admissionInquiry
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdmissionInquiryRequest $request, AdmissionInquiry $admissionInquiry)
    {
        $admissionInquiry = AdmissionInquiry::find($request->id);
        $admissionInquiry->full_name = $request->full_name;
        $admissionInquiry->phone = $request->phone;
        $admissionInquiry->email = $request->email;
        $admissionInquiry->address = $request->address;
        $admissionInquiry->description = $request->description;
        $admissionInquiry->note = $request->note;
        $admissionInquiry->inquiry_date = $request->inquiry_date;
        $admissionInquiry->follow_up = $request->follow_up;
        $admissionInquiry->source_id = $request->source_id;
        $admissionInquiry->reference_id = $request->reference_id;
        $admissionInquiry->level_id = $request->level_id;
        $admissionInquiry->program_id = $request->program_id;
        $admissionInquiry->year_semester_id = $request->year_semester_id;
        $admissionInquiry->no_of_child = $request->no_of_child;
        $admissionInquiry->update();
        return redirect()->route('admission-inquiry.index')->with('success', 'Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AdmissionInquiry  $admissionInquiry
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdmissionInquiry $admissionInquiry, $id)
    {
        $admissionInquiry = AdmissionInquiry::findOrFail($id);
        $admissionInquiry->delete();
        return redirect()->back()->with('success', 'Deleted successfully');
    }
}
