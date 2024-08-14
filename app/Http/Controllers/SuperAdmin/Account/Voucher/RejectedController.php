<?php

namespace App\Http\Controllers\SuperAdmin\Account\Voucher;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRejectedRequest;
use App\Models\Rejected;


class RejectedController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rejecteds = Rejected::all();
        return  view('pages.account.voucher.rejected.index', compact('rejecteds'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.account.voucher.rejected.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreRejectedRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRejectedRequest $request)
    {
        Rejected::create($request->all());
        return redirect()->route('rejected.index')->with('success', 'Unapprove Created successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rejected = Rejected::findOrFail($id);
        $rejected->delete();
        return redirect()->route('rejected.index')->with('success', 'Deleted successfully');
    }
}
