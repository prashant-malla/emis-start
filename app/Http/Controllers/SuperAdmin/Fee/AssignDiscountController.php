<?php

namespace App\Http\Controllers\SuperAdmin\Fee;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkAssignDiscountRequest;
use App\Http\Requests\FilterRequest;
use App\Http\Requests\StoreAssignDiscountRequest;
use App\Models\AssignDiscount;
use App\Models\Category;
use App\Models\Program;
use App\Models\FeeDiscount;
use App\Models\Section;
use App\Models\Student;
use App\Models\YearSemester;
use App\Services\BatchService;
use App\Services\ProgramService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class AssignDiscountController extends Controller
{
    public function __construct(
        protected ProgramService $programService,
        protected BatchService $batchService,
    ) {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FilterRequest $request, FeeDiscount $feeDiscount)
    {
        $data['programs'] = $this->programService->getAll();
        $data['batches'] = $this->batchService->getAll();

        $validated = $request->validated();
        if (isset($validated['program_id']) && isset($validated['batch_id'])) {
            $data['yearSemesters'] = YearSemester::query()
                ->filterBy([
                    'program_id' => $validated['program_id'],
                    'batch_id' => $validated['batch_id']
                ])->get();
        }

        if (isset($validated['year_semester_id'])) {
            $data['sections'] = Section::where('year_semester_id', $validated['year_semester_id'])->get();
        }

        if (isset($validated['program_id']) && isset($validated['batch_id']) && isset($validated['year_semester_id']) && isset($validated['section_id'])) {
            $data['assignedDiscountStudents'] = AssignDiscount::query()
                ->where('fee_discount_id', $feeDiscount->id)
                ->filterBy([
                    'program_id' => $validated['program_id'],
                    'batch_id' => $validated['batch_id'],
                    'year_semester_id' => $validated['year_semester_id'],
                    'section_id' => $validated['section_id']
                ])
                ->with('student', 'fee_discount')
                ->latest()
                ->get();
        } else {
            $data['assignedDiscountStudents'] = AssignDiscount::query()
                ->where('fee_discount_id', $feeDiscount->id)
                ->with('student', 'fee_discount')
                ->latest()
                ->get();
        }

        $data['feeDiscount'] = $feeDiscount;

        return view('pages.fee.assign_discount.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(FeeDiscount $feeDiscount)
    {
        $data['programs'] = $this->programService->getAll();
        $data['batches'] = $this->batchService->getAll();
        $data['categories'] = Category::all();

        $data['students'] = Student::query()
            ->whereDoesntHave('assignDiscounts', function (Builder $query) use ($feeDiscount) {
                $query->where('fee_discount_id', '=', $feeDiscount->id);
            })->get();
        $data['feeDiscount'] = $feeDiscount;

        return view('pages.fee.assign_discount.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreAssignDiscountRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAssignDiscountRequest $request)
    {
        $feeDiscount = FeeDiscount::find($request->fee_discount_id);

        $student = Student::find($request->student_id);

        $student->assignDiscounts()->create([
            'fee_discount_id' => $feeDiscount->id,
            'program_id' => $student->program_id,
            'year_semester_id' => $student->year_semester_id,
            'section_id' => $student->section_id,
        ]);

        return redirect()->route('assigned_discount.index', compact('feeDiscount'))->with('success', 'Discount Assigned Successfully');
    }

    public function storeBulk(BulkAssignDiscountRequest $request)
    {
        $feeDiscount = FeeDiscount::find($request->fee_discount_id);

        foreach ($request->students as $studentId) {
            $data = [
                'student_id' => $studentId,
                'fee_discount_id' => $feeDiscount->id,
                'program_id' => $request->program_id,
                'year_semester_id' => $request->year_semester_id,
                'section_id' => $request->section_id,
                // 'gender' => $request->gender,
                // 'category_id' => $request->category_id,
            ];
            AssignDiscount::create($data);
        }

        return redirect()->route('assigned_discount.index', compact('feeDiscount'))->with('success', 'Discount Assigned Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $assignedFee = AssignDiscount::find($id);
        $assignedFee->delete();
        return redirect()->back()->with('success', "Assigned Discount Deleted Successfully.");
    }

    public function search(Request $request)
    {
        $feeDiscount = FeeDiscount::find($request->fee_discount_id);
        $programs = Program::all();
        $yearSemesters = YearSemester::all();
        $sections = Section::all();
        // $categories = Category::all();

        $searchedStudents = Student::query()
            ->where('program_id', $request->program_id)
            ->where('year_semester_id', $request->year_semester_id)
            ->where('section_id', $request->section_id)
            ->whereDoesntHave('assignDiscounts', function (Builder $query) use ($feeDiscount) {
                $query->where('fee_discount_id', '=', $feeDiscount->id);
            })->get();

        return view('pages.fee.assign_discount.create', compact('searchedStudents', 'programs', 'yearSemesters', 'sections', 'feeDiscount'));
    }

    // public function assignedDiscountStudentSearch(Request $request){
    //     $feeDiscount = FeeDiscount::find($request->fee_discount_id);
    //     $programs = Program::all();
    //     $yearSemesters = YearSemester::all();
    //     $sections = Section::all();
    //     $assignedDiscountStudents = AssignDiscount::where('fee_discount_id', $feeDiscount->id)
    //         ->where('program_id', $request->program_id)
    //         ->where('year_semester_id', $request->year_semester_id)
    //         ->where('section_id', $request->section_id)
    //         ->get();
    //     return view('pages.fee.assign_discount.index', compact('assignedDiscountStudents', 'programs', 'sections', 'yearSemesters', 'feeDiscount'));
    // }
}
