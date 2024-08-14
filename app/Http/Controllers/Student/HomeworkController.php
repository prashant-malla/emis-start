<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHomeworkSubmissionRequest;
use App\Models\Homework;
use App\Models\HomeworkSubmission;
use Illuminate\Support\Facades\Auth;

class HomeworkController extends Controller
{
  public function index()
  {
    $student = Auth::guard('student')->user();
    $homework = Homework::where('homework.level_id', '=', $student->level_id)
      ->where('homework.program_id', '=', $student->program_id)
      ->where('homework.section_id', '=', $student->section_id)
      ->withCount(['homeworkSubmission' => function ($q) use ($student) {
        return $q->where('student_id', $student->id);
      }])->latest('assign')->get();
    return view('student.homework.index', compact('homework'));
  }


  public function show($id)
  {
    $student = Auth::guard('student')->user();
    $homework = Homework::where('id', $id)->with(['homeworksubmission' => function ($q) use ($student) {
      return $q->where('student_id', $student->id);
    }])->first();
    return view('student.homework.view', compact('homework'));
  }


  public function uploadSubmission(StoreHomeworkSubmissionRequest $request, $id)
  {
    $homework = Homework::findOrFail($id);
    $homeworkSubmission = new HomeworkSubmission();
    $homeworkSubmission->student_id = Auth::guard('student')->user()->id;
    $homeworkSubmission->homework_id = $homework->id;
    $homeworkSubmission->save();
    foreach ($request->file('file') as $file) {
      $homeworkSubmission->addMedia($file)->toMediaCollection();
    }
    return redirect()->back()->with('success', 'Homework submitted successfully!');
  }


  public function deleteSubmission($id)
  {
    $homework = Homework::findOrFail($id);
    $homework->homeworksubmission()->delete();
    return redirect()->back()->with('success', 'Submission deleted successfully!');
  }
}
