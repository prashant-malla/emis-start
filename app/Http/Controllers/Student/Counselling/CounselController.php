<?php

namespace App\Http\Controllers\Student\Counselling;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCounselRequest;
use App\Http\Requests\UpdateCounselRequest;
use App\Models\Counsel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CounselController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $counsellings = Counsel::where('student_id', Auth::guard('student')->user()->id)->latest()->get();
        return view('pages.counsel.index', compact('counsellings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
//    public function create()
//    {
//        $level = DB::table('levels')->select('id', 'name')->get();
//        $program = DB::table('programs')->select('id', 'name')->get();
//        $yearSemester = DB::table('year_semesters')->select('id', 'name')->get();
//        $section = DB::table('sections')->select('id', 'group_name')->get();
//        return view('pages.counsel.create', ['level' => $level, 'program' => $program, 'yearSemester'=> $yearSemester, 'section' => $section],);
//    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
//    public function store(StoreCounselRequest $request)
//    {
//        $request['student_id'] = Auth::guard('student')->user()->id;
//        Counsel::create($request->all());
//        return redirect()->route('student_counsel.index')->with('success', 'Created Successfully');
//    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Counsel  $counsel
     * @return \Illuminate\Http\Response
     */
    public function show(Counsel $counsel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Counsel  $counsel
     * @return \Illuminate\Http\Response
     */
//    public function edit(Counsel $counsel, $id)
//    {
//        $level = DB::table('levels')->select('id', 'name')->get();
//        $program = DB::table('programs')->select('id', 'name')->get();
//        $yearSemester = DB::table('year_semesters')->select('id', 'name')->get();
//        $section = DB::table('sections')->select('id', 'group_name')->get();
//        $counsel = Counsel::find($id);
//        return view('pages.counsel.edit', ['level' => $level, 'program' => $program, 'yearSemester'=> $yearSemester, 'section' => $section,'counsel' => $counsel]);
//    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Counsel  $counsel
     * @return \Illuminate\Http\RedirectResponse
     */
//    public function update(UpdateCounselRequest $request, $id)
//    {
//        $counsel = Counsel::find($id);
//        $request['student_id'] = Auth::guard('student')->user()->id;
//        $counsel->update($request->all());
//        return redirect()->route('student_counsel.index')->with('success', 'Updated Successfully');
//        // }
//        // else {
//        //     return redirect()->back()->with('error', 'Data already exists.');
//        // }
//    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Counsel  $counsel
     * @return \Illuminate\Http\Response
     */
//    public function destroy(Counsel $counsel, $id)
//    {
//        $counsel= Counsel::findOrFail($id);
//        $counsel ->delete();
//        return redirect()->route('student_counsel.index')->with('success', 'Deleted successfully');
//    }
}
