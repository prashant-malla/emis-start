<?php

namespace App\Http\Controllers\Receptionist\FrontOffice;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreComplainTypeRequest;
use App\Http\Requests\UpdateComplainTypeRequest;
use App\Models\ComplainType;
use Illuminate\Http\Request;

class ComplainTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $complainType = ComplainType::all();
        return view('pages.front_office.set_up.complain_type.index',compact('complainType'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.front_office.set_up.complain_type.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreComplainTypeRequest $request)
    {
        $complaintype= new ComplainType();
        $complaintype->complain_type = $request->complain_type;
        $complaintype->description = $request->description;
        $complaintype->save();
        return redirect()->route('complain-type.index')->with('success', 'Created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ComplainType  $complainType
     * @return \Illuminate\Http\Response
     */
    public function show(ComplainType $complainType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ComplainType  $complainType
     * @return \Illuminate\Http\Response
     */
    public function edit(ComplainType $complainType, $id)
    {
        $complainType = ComplainType::find($id);
        return view('pages.front_office.set_up.complain_type.edit', ['complainType' => $complainType]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdateComplainTypeRequest  $request
     * @param  \App\Models\ComplainType  $complainType
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateComplainTypeRequest $request, ComplainType $complainType)
    {
        $complainType = ComplainType::where('complain_type', $request->complain_type)->first();
        if ($complainType === null) {
            $complainType = ComplainType::find($request->id);
            $complainType->complain_type = $request->complain_type;
            $complainType->description = $request->description;
            $complainType->update();
            return redirect()->route('complain-type.index')->with('success', 'Updated successfully');
        }
        else{
            return redirect()->route('complain-type.update')->with('error', 'Data already exists.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ComplainType  $complainType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ComplainType $complainType, $id)
    {
        $complainType = ComplainType::find($id);
        $complainType->delete();
        return redirect()->back()->with('success', 'Deleted successfully');
    }
}
