<?php

namespace App\Http\Controllers\SuperAdmin\Account\Voucher;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUnApproveRequest;
use App\Models\UnApprove;


class UnApproveController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $unapproves = UnApprove::all();
        return  view('pages.account.voucher.unapprove.index', compact('unapproves'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.account.voucher.unapprove.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreUnApproveRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUnApproveRequest $request)
    {
        UnApprove::create($request->all());
        return redirect()->route('unapprove.index')->with('success', 'Unapprove Created successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $unapprove = UnApprove::findOrFail($id);
        $unapprove->delete();
        return redirect()->route('unapprove.index')->with('success', 'Deleted successfully');
    }
}
