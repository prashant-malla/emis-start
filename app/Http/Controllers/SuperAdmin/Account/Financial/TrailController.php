<?php

namespace App\Http\Controllers\SuperAdmin\Account\Financial;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTrailRequest;
use App\Models\Trail;


class TrailController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trails = Trail::all();
        return  view('pages.account.financial.trail.index', compact('trails'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.account.financial.trail.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreTrailRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTrailRequest $request)
    {
        Trail::create($request->all());
        return redirect()->route('trail.index')->with('success', 'Created successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $trail = Trail::findOrFail($id);
        $trail->delete();
        return redirect()->route('trail.index')->with('success', 'Deleted successfully');
    }
}
