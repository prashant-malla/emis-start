<?php

namespace App\Http\Controllers\SuperAdmin\Fee;

use App\Http\Controllers\Controller;
use App\Http\Requests\FeeMasteRequest;
use App\Http\Requests\FilterRequest;
use App\Http\Requests\StoreFeeCloneRequest;
use App\Models\Program;
use App\Models\FeeMaster;
use App\Models\FeeType;
use App\Models\YearSemester;
use App\Services\BatchService;
use App\Services\ProgramService;
use Illuminate\Http\Request;

class FeeMasterController extends Controller
{
    public function __construct(
        protected ProgramService $programService,
        protected BatchService $batchService,
    ) {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FilterRequest $request)
    {
        $data['programs'] = $this->programService->getAll();
        $data['batches'] = $this->batchService->getAll();

        $validated = $request->validated();
        if (isset($validated['program_id']) && isset($validated['batch_id'])) {
            $data['yearSemesters'] = YearSemester::query()
                ->filterBy([
                    'program_id' => $validated['program_id'],
                    'batch_id' => $validated['batch_id']
                ])->get();
        }

        // list year/semesters data
        if (isset($validated['year_semester_id'])) {
            $data['feeMasters'] = FeeMaster::query()
                ->filterBy([
                    'year_semester_id' => $validated['year_semester_id']
                ])
                ->with('yearSemester.program', 'yearSemester.batch')
                ->latest('id')
                ->get();
        } else {
            $data['feeMasters'] = FeeMaster::with('yearSemester.program', 'yearSemester.batch')->latest('id')->get();
        }

        return view('pages.fee.fee_master.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(FilterRequest $request)
    {
        $data['programs'] = $this->programService->getAll();
        $data['batches'] = $this->batchService->getAll();

        // $validated = $request->validated();
        // if (isset($validated['program_id']) && isset($validated['batch_id'])) {
        //     $data['yearSemesters'] = YearSemester::query()
        //         ->filterBy([
        //             'program_id' => $validated['program_id'],
        //             'batch_id' => $validated['batch_id']
        //         ])->get();
        // }

        // if (isset($validated['year_semester_id'])) {
        //     $data['feeTypes'] = FeeType::all();
        // }
        $data['feeTypes'] = FeeType::all();

        return view('pages.fee.fee_master.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FeeMasteRequest $request)
    {
        FeeMaster::create($request->all());

        // Return to create page with year semester for quick create
        return redirect()
            ->route('fee_master.create', ['year_semester_id' => $request->year_semester_id])
            ->with('success', 'Fee Structure Created Successfully.');
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
    public function edit(FeeMaster $feeMaster)
    {
        $data['programs'] = $this->programService->getAll();
        $data['batches'] = $this->batchService->getAll();

        $data['yearSemesters'] = YearSemester::query()
            ->filterBy([
                'program_id' => $feeMaster->yearSemester->program_id,
                'batch_id' => $feeMaster->yearSemester->batch_id
            ])
            ->get();

        $data['feeTypes'] = FeeType::all();

        $data['feeMaster'] = $feeMaster;

        return view('pages.fee.fee_master.create', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FeeMasteRequest $request, FeeMaster $feeMaster)
    {
        // update due date to all assignFees
        if ($request->due_date !== $feeMaster->due_date) {
            $feeMaster->assignFees()->update(['due_date' => convertToEngDate($request->due_date)]);
        }

        $feeMaster->update($request->all());
        return redirect()->route('fee_master.index')->with('success', 'Fee Structure Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(FeeMaster $feeMaster)
    {
        $feeMaster->delete();
        return redirect()->route('fee_master.index')->with('success', 'Fee Structure Deleted Successfully.');
    }

    public function clone(FilterRequest $request)
    {
        $data['programs'] = $this->programService->getAll();
        $data['batches'] = $this->batchService->getAll();

        $validated = $request->validated();
        if (isset($validated['program_id']) && isset($validated['batch_id'])) {
            $data['yearSemesters'] = YearSemester::query()
                ->filterBy([
                    'program_id' => $validated['program_id'],
                    'batch_id' => $validated['batch_id']
                ])->get();
        }

        return view('pages.fee.fee_master.clone', $data);
    }

    public function storeClone(StoreFeeCloneRequest $request)
    {
        $feeMasters = FeeMaster::query()
            ->where('year_semester_id', $request->clone_year_semester_id)
            ->get();

        if ($feeMasters->isEmpty()) {
            return redirect()
                ->route('fee_master.clone', $request->all('program_id', 'batch_id', 'year_semester_id'))
                ->with('warning', 'No fee avilable in requested program/batch/semester to clone.');
        }

        $newFeeMasters = [];
        foreach ($feeMasters as $feeMaster) {
            $newFeeMaster = $feeMaster->replicate();
            $newFeeMaster->year_semester_id = $request->year_semester_id;

            // casting to eng required since insert does not casts model date
            $newFeeMaster->due_date = convertToEngDate($newFeeMaster->due_date);

            $newFeeMasters[] = $newFeeMaster->attributesToArray();
        }

        FeeMaster::insert($newFeeMasters);

        return redirect()->route('fee_master.index')->withSuccess(count($newFeeMasters) . ' fee(s) cloned successfully.');
    }
}
