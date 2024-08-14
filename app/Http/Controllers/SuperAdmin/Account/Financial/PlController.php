<?php

namespace App\Http\Controllers\SuperAdmin\Account\Financial;

use App\Http\Controllers\Controller;


class PlController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $pls = Pl::all();
        return  view('pages.account.financial.profitloss.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.account.financial.profitloss.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StorePlRequest  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(StorePlRequest $request)
    // {
    //     Pl::create($request->all());
    //     return redirect()->route('trail.index')->with('success', 'Created successfully');
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     $trail = Trail::findOrFail($id);
    //     $trail->delete();
    //     return redirect()->route('trail.index')->with('success', 'Deleted successfully');
    // }
}
