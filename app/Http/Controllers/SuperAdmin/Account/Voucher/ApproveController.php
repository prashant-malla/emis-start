<?php

namespace App\Http\Controllers\SuperAdmin\Account\Voucher;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreApproveRequest;
use App\Models\Approve;


class ApproveController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $approves = Approve::all();
        return  view('pages.account.voucher.approve.index', compact('approves'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.account.voucher.approve.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreApproveRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreApproveRequest $request)
    {
        $approve = new Approve();
        $approve->from_date = $request->from_date;
        $approve->to_date = $request->to_date;
        if($approve->save()){
            return redirect()->route('approve.index')->with('success', 'Created successfully');
        }else{
            return redirect()->route('approve.create')->with('error', 'Oops!! something went wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $approve = Approve::findOrFail($id);
        $approve->delete();
        return redirect()->route('approve.index')->with('success', 'Deleted successfully');
    }
}
