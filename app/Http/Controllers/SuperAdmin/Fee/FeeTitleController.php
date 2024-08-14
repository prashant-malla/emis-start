<?php

namespace App\Http\Controllers\SuperAdmin\Fee;

use App\Http\Controllers\Controller;
use App\Http\Requests\FeeTitleRequest;
use App\Models\FeeTitle;
use Illuminate\Http\Request;

class FeeTitleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $feeTitles = FeeTitle::latest()->get();
        return view('pages.fee.fee_title.index', compact('feeTitles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.fee.fee_title.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FeeTitleRequest $request)
    {
        FeeTitle::create($request->all());
        return redirect()->route('fee_title.index')->with('success', 'Fee Title Created Successfully.');
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
    public function edit(FeeTitle $feeTitle)
    {
        return view('pages.fee.fee_title.create', compact('feeTitle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FeeTitleRequest $request, FeeTitle $feeTitle)
    {
        $feeTitle->update($request->all());
        return redirect()->route('fee_title.index')->with('success', 'Fee Title Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(FeeTitle $feeTitle)
    {
        $feeTitle->delete();
        return redirect()->route('fee_title.index')->with('success', 'Fee Title Deleted Successfully.');
    }
}
