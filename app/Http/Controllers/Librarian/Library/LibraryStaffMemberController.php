<?php

namespace App\Http\Controllers\Librarian\Library;

use App\Http\Controllers\Controller;
use App\Models\StaffDirectory;

class LibraryStaffMemberController extends Controller
{
    public function index(){
        $staffs = StaffDirectory::where('status', 1)->get();
        return view('pages.library.library_staff_member', compact('staffs'));
    }
}
