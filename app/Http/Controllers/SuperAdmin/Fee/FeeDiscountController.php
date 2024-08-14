<?php

namespace App\Http\Controllers\SuperAdmin\Fee;

use App\Http\Controllers\Controller;
use App\Http\Requests\FeeDiscountRequest;
use App\Http\Requests\FilterRequest;
use App\Models\FeeDiscount;
use App\Models\FeeType;
use App\Services\BatchService;
use App\Services\ProgramService;
use Illuminate\Http\Request;

class FeeDiscountController extends Controller
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
    public function index()
    {
        $feeDiscounts = FeeDiscount::latest()->get();
        return view('pages.fee.fee_discount.index', compact('feeDiscounts'));
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

        $data['feeTypes'] = FeeType::all();

        return view('pages.fee.fee_discount.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FeeDiscountRequest $request)
    {
        FeeDiscount::create($request->all());
        return redirect()->route('fee_discount.index')->with('success', 'Fee Discount Created Successfully.');
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
    public function edit(FeeDiscount $feeDiscount)
    {
        $feeTypes = FeeType::all();
        return view('pages.fee.fee_discount.create', compact('feeDiscount', 'feeTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FeeDiscountRequest $request, FeeDiscount $feeDiscount)
    {
        $feeDiscount->update($request->all());
        return redirect()->route('fee_discount.index')->with('success', 'Fee Discount Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(FeeDiscount $feeDiscount)
    {
        $feeDiscount->delete();
        return redirect()->route('fee_discount.index')->with('success', 'Fee Discount Deleted Successfully.');
    }
}
