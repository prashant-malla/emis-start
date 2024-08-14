<?php

namespace App\Http\Controllers\SuperAdmin\Academics;

use App\Http\Controllers\Controller;
use App\Models\StudentCategory;
use Illuminate\Http\Request;

class StudentCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view ('pages.academics.student_category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('pages.academics.student_category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $studentCategory = StudentCategory::where('category_name', '=', $request->category_name)->first();
        if ($studentCategory === null) {
            $studentCategory = new StudentCategory();
            $studentCategory->category_name = $request->category_name;
            $studentCategory->save();
            return redirect()->route('category.index')->with('success', 'Created successfully');
        }
        else{
            return redirect()->back()->with('error', 'Data already exists.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StudentCategory  $studentCategory
     * @return \Illuminate\Http\Response
     */
    public function show(StudentCategory $studentCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StudentCategory  $studentCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentCategory $studentCategory, $id)
    {
        $studentCategory = StudentCategory::find($id);
        return view('pages.academics.student_category.edit', [ 'studentCategory' => $studentCategory]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StudentCategory  $studentCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StudentCategory $studentCategory)
    {
        $studentCategory = StudentCategory::where('category_name', '=', $request->category_name)->first();
        if ($studentCategory === null) {
            $studentCategory= StudentCategory::find($request->id);
            $studentCategory->category_name = $request->category_name;
            $studentCategory->update();
            return redirect()->route('category.index')->with('success', 'Updated successfully');
        }
        else{
            return redirect()->route('category.update')->with('error', 'Data already exists.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudentCategory  $studentCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentCategory $studentCategory, $id)
    {
        $studentCategory = StudentCategory::findOrFail($id);
        $studentCategory->delete();
        return redirect()->back()->with('success', 'Deleted successfully.');
    }
}
