<?php

namespace App\Http\Controllers\SuperAdmin\Fee;

use App\Http\Controllers\Controller;
use App\Http\Requests\FeeTypeRequest;
use App\Models\AccountCategory;
use App\Models\FeeType;
use Illuminate\Http\Request;

class FeeTypeController extends Controller
{
    protected function isFeeTypeAssigned(FeeType $feeType)
    {
        return $feeType->feeMasters()->whereHas('assignFees')->exists();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $feeTypes = FeeType::latest()->get();
        return view('pages.fee.fee_type.index', compact('feeTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $accountLedgers = AccountCategory::all();
        return view('pages.fee.fee_type.create', compact('accountLedgers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FeeTypeRequest $request)
    {
        FeeType::create($request->all());
        return redirect()->route('fee_type.index')->with('success', 'Fee Type Created Successfully.');
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
    public function edit(FeeType $feeType)
    {
        $accountLedgers = AccountCategory::all();
        $isFeeTypeAssigned = $this->isFeeTypeAssigned($feeType);
        return view('pages.fee.fee_type.create', compact('feeType', 'accountLedgers', 'isFeeTypeAssigned'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FeeType $feeType)
    {
        $data = $request->all();
        if($this->isFeeTypeAssigned($feeType)){
            $data['submission_type'] = $feeType->submission_type;
        }
        $feeType->update($data);
        return redirect()->route('fee_type.index')->with('success', 'Fee Type Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(FeeType $feeType)
    {
        $feeType->delete();
        return redirect()->route('fee_type.index')->with('success', 'Fee Type Deleted Successfully.');
    }
}
