<?php

namespace App\Http\Controllers\SuperAdmin\Fee;

use App\Http\Controllers\Controller;
use App\Http\Requests\FineCreateRequest;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentFineController extends Controller
{
    public function list(Request $request, Student $student)
    {
        $data = $student->studentFines()->latest('id')->get();
        return response()->json($data, 200);
    }

    public function save(FineCreateRequest $request, Student $student)
    {
        $data = $request->validated();
        $fine = $student->studentFines()->create($data);

        return response()->json($fine, 200);
    }
}
