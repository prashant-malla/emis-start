<?php

namespace App\Http\Controllers\Receptionist\FrontOffice;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReferenceRequest;
use App\Http\Requests\UpdateReferenceRequest;
use App\Models\Reference;
use Illuminate\Http\Request;

class ReferenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reference = Reference::all();
        return view('pages.front_office.set_up.reference.index',compact('reference'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.front_office.set_up.reference.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReferenceRequest $request)
    {
        $reference = new Reference();
        $reference->reference = $request->reference;
        $reference->description = $request->description;
        $reference->save();
        return redirect()->route('reference.index')->with('success', 'Created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reference  $reference
     * @return \Illuminate\Http\Response
     */
    public function show(Reference $reference)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reference  $reference
     * @return \Illuminate\Http\Response
     */
    public function edit(Reference $reference, $id)
    {
        $reference = Reference::find($id);
        return view('pages.front_office.set_up.reference.edit', ['reference' => $reference]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdateReferenceRequest  $request
     * @param  \App\Models\Reference  $reference
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReferenceRequest $request, Reference $reference)
    {
        $reference = Reference::where('reference', '=', $request->reference)->first();
        if($reference === null){
            $reference = Reference::find($request->id);
            $reference->reference= $request->reference;
            $reference->description = $request->description;
            $reference->update();
            return redirect()->route('reference.index')->with('success', 'Updated successfully');
        }
        else {
            return redirect()->route('reference.update')->with('error', 'Data already exists.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reference  $reference
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reference $reference, $id)
    {
        $reference = Reference::find($id);
        $reference->delete();
        return redirect()->route('reference.index')->with('success', 'Deleted successfully');
    }
}
