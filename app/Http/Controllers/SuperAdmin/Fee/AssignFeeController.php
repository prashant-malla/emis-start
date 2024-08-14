<?php

namespace App\Http\Controllers\SuperAdmin\Fee;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssignFeeRequest;
use App\Models\AssignFee;
use App\Models\Program;
use App\Models\FeeMaster;
use App\Models\Section;
use App\Models\Student;
use App\Models\YearSemester;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class AssignFeeController extends Controller
{
    public function index(Request $request, FeeMaster $feeMaster)
    {
        // handle old data without year_semester_id
        if (!$feeMaster->year_semester_id) {
            return redirect()->route('fee_master.index')->with('error', 'Please assign Year/Semester for the fee first.');
        }

        $filterParams = ['section_id', 'month_name'];

        $sectionId = $request->section_id && $request->section_id !== 'All' ? $request->section_id : null;

        $data['assignedFeeStudents'] = AssignFee::query()
            ->where('fee_master_id', $feeMaster->id)
            ->filterBy(
                collect($request->only($filterParams))->replace([
                    'section_id' => $sectionId
                ])
            )
            ->with('student', 'fee_master')
            ->latest()
            ->get();

        $data['feeMaster'] = $feeMaster;
        $data['filters'] = $request->all($filterParams);

        return view('pages.fee.assign_fee.index', $data);
    }

    public function create(Request $request, FeeMaster $feeMaster)
    {
        // handle old data without year_semester_id
        if (!$feeMaster->year_semester_id) {
            return redirect()->route('fee_master.index')->with('error', 'Please assign Year/Semester for the fee first.');
        }

        $data['feeMaster'] = $feeMaster;

        if ($request->section_id) {
            $sectionId = $request->section_id !== 'All' ? $request->section_id : null;
            $monthName = $request->month_name;
            $data['students'] = Student::query()
                ->where('year_semester_id', $feeMaster->year_semester_id)
                ->when($sectionId, function (Builder $query, $sectionId) {
                    $query->where('section_id', $sectionId);
                })
                ->whereDoesntHave('assignFees', function (Builder $query) use ($feeMaster, $monthName) {
                    // get assigned fee which is used to filter out students
                    $query
                        ->where('fee_master_id', $feeMaster->id)
                        ->when($monthName, function ($query, $monthName) {
                            $query->where('month_name', $monthName);
                        });
                })
                ->with('program', 'yearSemester', 'section')
                ->get();
        }

        return view('pages.fee.assign_fee.create', $data);
    }

    public function store(AssignFeeRequest $request, FeeMaster $feeMaster)
    {
        foreach ($request->students as $student) {
            $data = [
                'student_id' => $student,
                'fee_master_id' => $feeMaster->id,
                'program_id' => $request->program_id,
                'year_semester_id' => $request->year_semester_id,
                'section_id' => $request->section_id,
                'month_name' => $request->month_name ?? '',
                'due_date' => $request->due_date,
            ];
            AssignFee::create($data);
        }
        return redirect()->back()->with('success', 'Fee Assigned Successfully for ' . count($request->students) . ' student(s).');
    }

    public function destroy($id)
    {
        $assignedFee = AssignFee::findOrFail($id);
        $assignedFee->delete();
        return redirect()->back()->with('success', "Assigned Fee Deleted Successfully.");
    }
}
