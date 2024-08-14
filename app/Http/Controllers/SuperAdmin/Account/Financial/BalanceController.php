<?php

namespace App\Http\Controllers\SuperAdmin\Account\Financial;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class BalanceController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $pls = Pl::all();
        return  view('pages.account.financial.balancesheet.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.account.financial.balancesheet.create');
    }
}
