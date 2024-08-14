<?php

namespace App\Http\Controllers\SuperAdmin\Fee;

use App\Http\Controllers\Controller;
use App\Http\Requests\FilterRequest;
use App\Http\Requests\StoreFeeBillRequest;
use App\Models\Program;
use App\Models\Student;
use App\Models\YearSemester;
use App\Services\BatchService;
use App\Services\FeeService;
use App\Services\ProgramService;
use App\Services\SchoolSettingService;
use Illuminate\Http\Request;

class BillController extends Controller
{
    public function __construct(
        protected FeeService $feeService,
        protected ProgramService $programService,
        protected BatchService $batchService,
    ) {
    }

    public function index(FilterRequest $request)
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
            $data['studentBills'] = Student::query()
                ->filterBy([
                    'year_semester_id' => $validated['year_semester_id']
                ])
                ->with('program', 'batch', 'yearSemester', 'section')
                ->latest('id')
                ->get();
        }

        return view('pages.fee.bill.index', $data);
    }

    public function printBill(Student $student, SchoolSettingService $schoolSetting)
    {
        $data['billNumber'] = $this->feeService->generateBillNumber(
            $this->feeService->getLastBillSequenceNumber() + 1
        );

        $data['studentFees'] = $this->feeService->getStudentFees($student);

        $data['oldBalance'] = $this->feeService->getStudentOldBalance($student);

        $data['setting'] = $schoolSetting->getSetting();

        $data['student'] = $student;

        return view('pages.fee.bill.print', $data);
    }

    public function storeFeeBill(StoreFeeBillRequest $request, Student $student)
    {
        $data = $request->validated();

        $sequenceNumber = $this->feeService->getLastBillSequenceNumber() + 1;

        $student->feeBills()->create([
            'sequence_number' => $sequenceNumber,
            'bill_number' => $this->feeService->generateBillNumber($sequenceNumber),
            'total_amount' => $data['total_amount'],
        ]);

        return response()->json(['success' => true], 200);
    }
}
