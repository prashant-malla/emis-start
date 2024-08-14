<?php

namespace App\Http\Controllers\Administrative;

use App\Http\Controllers\Controller;
use App\Models\StaffDirectory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('administrative');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('administrative.dashboard');
    }

    public function administrativeProfile()
    {
        $administrative = StaffDirectory::where('id', Auth::guard('staff')->user()->id)->first();
        return view('administrative.profile', compact('administrative'));
    }
}
