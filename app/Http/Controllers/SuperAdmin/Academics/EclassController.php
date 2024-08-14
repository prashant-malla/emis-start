<?php

namespace App\Http\Controllers\SuperAdmin\Academics;

use App\Http\Controllers\Controller;
use App\Models\Eclass;
use Illuminate\Http\Request;

class EclassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view ('pages.academics.class.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('pages.academics.class.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $eclass = Eclass::where('class_name', '=', $request->class_name )
            ->where('description', '=', $request->description)
            ->first();
        if($eclass === null){
            $class = new Eclass();
            $class->class_name = $request->class_name;
            $class->description = $request->description;
            $class->save();
            return redirect()->route('class.index')->with('success', 'Created successfully');
        }
        else{
            return redirect()->back()->with('error', 'Data already exists.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Eclass  $eclass
     * @return \Illuminate\Http\Response
     */
    public function show(Eclass $eclass)
    {
        $eclass = Eclass::all();
        return view('pages.academics.class.index',compact('eclass'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Eclass  $eclass
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $class = Eclass::all();
        $eclass = Eclass::findOrFail($id);
        return view('pages.academics.class.edit', ['eclass' => $eclass,'class' => $class]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Eclass  $eclass
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Eclass $eclass)
    {
        $eclass = Eclass::where('class_name', '=', $request->class_name )
            ->first();
        if($eclass === null){
            $eclass = Eclass::find($request->id);
            $eclass->class_name = $request->class_name;
            $eclass->description = $request->description;
            $eclass->update();
            return redirect()->route('class.index')->with('success', 'Updated successfully');
        }
        else{
            return redirect()->route('class.update')->with('error', 'Data already exists.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Eclass  $eclass
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $eclass = Eclass::findOrFail($id);
        $eclass->delete();
        return redirect()->route('class.index')->with('success', 'Deleted successfully');
    }
}
