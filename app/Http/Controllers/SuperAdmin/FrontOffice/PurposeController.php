<?php

namespace App\Http\Controllers\SuperAdmin\FrontOffice;

use App\Http\Controllers\Controller;
use App\Http\Requests\PurposeRequest;
use App\Models\Purpose;
use Illuminate\Http\Request;

class PurposeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purposes = Purpose::all();
        return view('pages.front_office.set_up.purpose.index',compact('purposes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.front_office.set_up.purpose.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PurposeRequest $request)
    {
        $purpose = Purpose::where('purpose', '=', $request->purpose)
            ->where('description', '=', $request->description)
            ->first();
        if (is_null($purpose)) {
            Purpose::create($request->all());
            return redirect()->route('purpose.index')->with('success', 'Created Successfully');
        }
        else{
            return redirect()->back()->with('error', 'Data Already Exists.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purpose  $purpose
     * @return \Illuminate\Http\Response
     */
    public function show(Purpose $purpose)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Purpose  $purpose
     * @return \Illuminate\Http\Response
     */
    public function edit(Purpose $purpose)
    {
        return view('pages.front_office.set_up.purpose.create', compact('purpose'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Purpose  $purpose
     * @return \Illuminate\Http\Response
     */
    public function update(PurposeRequest $request, Purpose $purpose)
    {
        $purpose->update($request->all());
        return redirect()->route('purpose.index')->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purpose  $purpose
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purpose $purpose)
    {
        $purpose ->delete();
        return redirect()->route('purpose.index')->with('success', 'Deleted Successfully');
    }
}
