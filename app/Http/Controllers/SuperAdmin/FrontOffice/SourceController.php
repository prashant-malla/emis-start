<?php

namespace App\Http\Controllers\SuperAdmin\FrontOffice;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSourceRequest;
use App\Http\Requests\UpdateSourceRequest;
use App\Models\Source;
use Illuminate\Http\Request;

class SourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $source = Source::all();
        return view('pages.front_office.set_up.source.index',compact('source'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.front_office.set_up.source.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSourceRequest $request)
    {
        $source = new Source();
        $source->source = $request->source;
        $source->description = $request->description;
        $source->save();
        return redirect()->route('source.index')->with('success', 'Created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Source  $source
     * @return \Illuminate\Http\Response
     */
    public function show(Source $source)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Source  $source
     * @return \Illuminate\Http\Response
     */
    public function edit(Source $source, $id)
    {
        $source= Source::find($id);
        return view('pages.front_office.set_up.source.edit', ['source' => $source]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdateSourceRequest $request
     * @param  \App\Models\Source  $source
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSourceRequest $request, Source $source)
    {
        $source = Source::where('source', '=', $request->source)
            ->first();
        if ($source === null) {
            $source =Source::find($request->id);
            $source->source = $request->source;
            $source->description = $request->description;
            $source->update();
            return redirect()->route('source.index')->with('success', 'Updated successfully');
        }
        else{
            return redirect()->route('source.update')->with('error', 'Data already exists.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Source  $source
     * @return \Illuminate\Http\Response
     */
    public function destroy(Source $source, $id)
    {
        $source= Source::findOrFail($id);
        $source->delete();
        return redirect()->route('source.index')->with('success', 'Deleted successfully');
    }
}
