<?php

namespace App\Http\Controllers\Teacher\Notice;

use App\Http\Controllers\Controller;
use App\Http\Requests\NoticeBoardRequest;
use App\Models\Program;
use App\Models\Level;
use App\Models\NoticeBoard;
use App\Models\Role;
use App\Models\Section;

class NoticeBoardController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notice_boards = NoticeBoard::all();
        return  view('pages.notice.index', compact('notice_boards'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        $levels = Level::all();
        $programs = Program::all();
        $sections = Section::all();
        $receivers = array('Staff','Student');
        return view('pages.notice.create', compact('roles', 'levels', 'programs', 'sections', 'receivers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\NoticeBoardRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NoticeBoardRequest $request)
    {
        NoticeBoard::create($request->all());
        return redirect()->route('notice.index')->with('success', 'Created successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $noticeBoard = NoticeBoard::findOrFail($id);
        $noticeBoard->delete();
        return redirect()->route('notice.index')->with('success', 'Deleted successfully');
    }

    public function edit()
    {
        $roles = Role::all();
        $levels = Level::all();
        $programs = Program::all();
        $sections = Section::all();
        $receivers = array('Staff','Student');
        return view('pages.notice.edit', compact('roles', 'levels', 'programs', 'sections', 'receivers'));
    }
}
