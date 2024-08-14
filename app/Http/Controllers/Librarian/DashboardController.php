<?php

namespace App\Http\Controllers\Librarian;

use App\Models\Book;
use App\Models\Event;
use App\Models\Notice;
use Illuminate\Http\Request;
use App\Models\LibraryMember;
use App\Models\StaffDirectory;
use App\Http\Controllers\Controller;
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
        $this->middleware('librarian');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['totalBooksCount'] = Book::count();
        $data['totalEventsCount'] = Event::query()
            ->where(function ($query) {
                $query->where('participants', 'All')
                    ->orWhere(function ($query) {
                        $query->whereHas('roles', function ($query) {
                            $query->where('role_id', auth()->guard('staff')->user()->role_id);
                        })
                        ;
                    })
                ;
            })
            ->count();
        $data['totalNoticesCount'] = Notice::query()
            ->where(function ($query) {
                $query->where('notice_to', 'All')
                    ->orWhere(function ($query) {
                        $query->whereHas('roles', function ($query) {
                            $query->where('role_id', auth()->guard('staff')->user()->role_id);
                        })
                        ;
                    })
                ;
            })
            ->count();

        $data['libraryMembers'] = LibraryMember::query()
            ->latest()
            ->take(10)
            ->get();

        return view('librarian.dashboard', $data);
    }

    public function teacherProfile()
    {
        $librarian = StaffDirectory::where('id', Auth::guard('staff')->user()->id)->first();
        return view('librarian.profile', compact('librarian'));
    }
}
