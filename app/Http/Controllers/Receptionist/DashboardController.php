<?php

namespace App\Http\Controllers\Receptionist;

use App\Models\Event;
use App\Models\Notice;
use Illuminate\Http\Request;
use App\Models\StaffDirectory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $data['totalEventsCount'] = Event::query()
            ->where(function ($query) {
                $query->where('participants', 'All')
                    ->orWhere(function ($query) {
                        $query->whereHas('roles', function ($query) {
                            $query->where('role_id', auth()->guard('staff')->user()->role_id);
                        });
                    });
            })
            ->count();
            
        $data['totalNoticesCount'] = Notice::query()
            ->where(function ($query) {
                $query->where('notice_to', 'All')
                    ->orWhere(function ($query) {
                        $query->whereHas('roles', function ($query) {
                            $query->where('role_id', auth()->guard('staff')->user()->role_id);
                        });
                    });
            })
            ->count();

        return view('receptionist.dashboard', $data);
    }

    public function profile()
    {
        $receptionist = StaffDirectory::where('id', Auth::guard('staff')->user()->id)->first();
        
        return view('receptionist.profile', compact('receptionist'));
    }
}
