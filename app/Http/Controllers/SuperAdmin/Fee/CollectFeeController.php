<?php

namespace App\Http\Controllers\SuperAdmin\Fee;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePaidFeeRequest;
use App\Models\AssignFee;
use App\Models\CollectFee;
use App\Models\Program;
use App\Models\FeeDiscount;
use App\Models\FeeMaster;
use App\Models\FeeType;
use App\Models\PaidFee;
use App\Models\PaidFeeItems;
use App\Models\Section;
use App\Models\Student;
use App\Models\YearSemester;
use App\Services\BatchService;
use App\Services\ProgramService;
use App\Services\SchoolSettingService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CollectFeeController extends Controller
{
    public function __construct(
        protected ProgramService $programService,
        protected BatchService $batchService,
    ) {
    }

    public function index()
    {
        $data['batches'] = $this->batchService->getAll();
        $data['programs'] = $this->programService->getAll();

        // Todo::Use Ajax for Student Filter
        $data['students'] = Student::with(['program', 'yearsemester', 'section'])->get();

        return view('pages.fee.collect_fee.index', $data);
    }

    public function search(Request $request)
    {
        $sectionId = $request->section_id;
        if (!$sectionId) {
            return redirect()->back()->withError('Invalid filter parameters.');
        }

        $data['searchedStudents'] = Student::query()
            ->where('section_id', $request->section_id)
            ->get();

        return view('pages.fee.collect_fee.index', $data);
    }

    protected function generateReceiptBillNumber($billPrefix = '')
    {
        $lastPayment = PaidFee::latest('id')->first();
        $sequenceNumber = 0;
        if ($lastPayment && $lastPayment->bill_number) {
            $sequenceNumber = intval(substr($lastPayment->bill_number, strlen($billPrefix)));
        }
        $sequenceNumber += 1;
        return $billPrefix . $sequenceNumber;
    }

    function getAssignFeeBalances($assignFeeIds)
    {
        // return AssignFee::query()
        //     ->join('fee_masters', 'fee_masters.id', 'assign_fees.fee_master_id')
        //     ->whereIn('assign_fees.id', $assignFeeIds)
        //     ->sum('amount');

        return AssignFee::query()
            ->join('fee_masters', 'fee_masters.id', 'assign_fees.fee_master_id')
            ->join('fee_types', 'fee_types.id', 'fee_masters.fee_type_id')
            ->leftJoin('fee_discounts', 'fee_discounts.fee_type_id', 'fee_types.id')
            ->leftJoin('assign_discounts', function ($join) {
                $join->on('fee_discounts.id', '=', 'assign_discounts.fee_discount_id')
                    ->on('fee_types.id', '=', 'fee_discounts.fee_type_id')
                    ->on('assign_fees.student_id', '=', 'assign_discounts.student_id');
            })
            ->leftJoin('paid_fee_items', 'assign_fees.id', 'paid_fee_items.assign_fee_id')
            ->select(
                'assign_fees.id',
                DB::raw("
                COALESCE(SUM(fee_masters.amount), 0) -
                COALESCE(SUM(CASE 
                    WHEN fee_discounts.discount_type = 'Percentage' THEN fee_masters.amount * fee_discounts.percentage / 100
                    WHEN fee_discounts.discount_type = 'Amount' THEN fee_discounts.amount
                    ELSE 0
                END), 0) +
                COALESCE(SUM(CASE 
                    WHEN fee_masters.fine_type = 'Percentage' AND CURRENT_DATE > assign_fees.due_date THEN fee_masters.amount * fee_masters.percentage / 100
                    WHEN fee_masters.fine_type = 'Fix Amount' AND CURRENT_DATE > assign_fees.due_date THEN fee_masters.fine_amount
                    ELSE 0
                END), 0) -
                COALESCE(SUM(paid_fee_items.amount_paid), 0) as balance
                "),
            )
            ->whereIn('assign_fees.id', $assignFeeIds)
            ->groupBy('assign_fees.id')
            ->get();
    }

    function getAssignFeeDetails($assignFeeIds, $studentId)
    {
        $studentFeeDiscountQueryTable = DB::raw("
        (SELECT DISTINCT fee_discounts.* 
        FROM fee_discounts 
        JOIN assign_discounts ON assign_discounts.fee_discount_id = fee_discounts.id 
        WHERE assign_discounts.student_id = $studentId) AS student_fee_discounts
        ");

        return AssignFee::query()
            ->join('fee_masters', 'fee_masters.id', 'assign_fees.fee_master_id')
            ->join('fee_types', 'fee_types.id', 'fee_masters.fee_type_id')
            ->leftJoin(
                $studentFeeDiscountQueryTable,
                function ($join) {
                    $join->on('fee_types.id', '=', 'student_fee_discounts.fee_type_id');
                }
            )
            ->select(
                'assign_fees.id',
                'fee_types.id as fee_type_id',
                'fee_masters.amount',
                'assign_fees.month_name',
                'assign_fees.due_date',
                DB::raw("CASE 
                    WHEN fee_masters.fine_type = 'Percentage' AND CURRENT_DATE > assign_fees.due_date THEN fee_masters.amount * fee_masters.percentage / 100
                    WHEN fee_masters.fine_type = 'Fix Amount' AND CURRENT_DATE > assign_fees.due_date THEN fee_masters.fine_amount
                    ELSE 0
                END as fine_amount"),
                DB::raw("CASE 
                    WHEN student_fee_discounts.discount_type = 'Percentage' THEN fee_masters.amount * student_fee_discounts.percentage / 100
                    WHEN student_fee_discounts.discount_type = 'Amount' THEN student_fee_discounts.amount
                    ELSE 0
                END as discount_amount"),
            )
            ->whereIn('assign_fees.id', $assignFeeIds)
            ->get();
    }

    public function dueFees()
    {
        $programs = Program::all();
        $sections = Section::all();
        $yearSemesters = YearSemester::all();
        return view('pages.fee.due_fees', compact('programs', 'sections', 'yearSemesters'));
    }

    public function collectFee($id)
    {
        $data['student'] = Student::findOrFail($id);

        $collectedAssignFeeIds = $data['student']->collectFees()->pluck('assign_fee_id');

        // creates intermediate table joining fee_discounts and assign_discounts for query
        $studentFeeDiscountQueryTable = DB::raw("
        (SELECT DISTINCT fee_discounts.* 
        FROM fee_discounts 
        JOIN assign_discounts ON assign_discounts.fee_discount_id = fee_discounts.id 
        WHERE assign_discounts.student_id = $id) AS student_fee_discounts
        ");
        $data['assignedFees'] = AssignFee::query()
            ->join('fee_masters', 'fee_masters.id', 'assign_fees.fee_master_id')
            ->join('fee_types', 'fee_types.id', 'fee_masters.fee_type_id')
            ->leftJoin(
                $studentFeeDiscountQueryTable,
                function ($join) {
                    $join->on('fee_types.id', '=', 'student_fee_discounts.fee_type_id');
                }
            )
            // ->leftJoin('paid_fee_items', 'assign_fees.id', 'paid_fee_items.assign_fee_id')
            ->select(
                'assign_fees.id',
                'fee_types.name',
                'fee_types.submission_type',
                'fee_masters.amount',
                'assign_fees.month_name',
                'assign_fees.due_date',
                'student_fee_discounts.name as discount_name',
                DB::raw("CASE 
                    WHEN fee_masters.fine_type != 'None' AND CURRENT_DATE > assign_fees.due_date THEN true
                    ELSE false
                END as is_due"),
                DB::raw("CASE 
                    WHEN fee_masters.fine_type = 'Percentage' AND CURRENT_DATE > assign_fees.due_date THEN fee_masters.amount * fee_masters.percentage / 100
                    WHEN fee_masters.fine_type = 'Fix Amount' AND CURRENT_DATE > assign_fees.due_date THEN fee_masters.fine_amount
                    ELSE 0
                END as fine_amount"),
                DB::raw("CASE 
                    WHEN student_fee_discounts.discount_type = 'Percentage' THEN fee_masters.amount * student_fee_discounts.percentage / 100
                    WHEN student_fee_discounts.discount_type = 'Amount' THEN student_fee_discounts.amount
                    ELSE 0
                END as discount_amount"),
                // DB::raw("COALESCE(SUM(paid_fee_items.amount_paid), 0) as amount_paid"),
            )
            ->where('assign_fees.student_id', $id)
            ->whereNotIn('assign_fees.id', $collectedAssignFeeIds)
            // ->groupBy(
            //     'assign_fees.id',
            //     'fee_types.name',
            //     'fee_types.submission_type',
            //     'fee_masters.amount',
            //     'assign_fees.month_name',
            //     'assign_fees.due_date',
            //     'fee_discounts.name',
            //     'fee_masters.fine_type',
            //     'fee_masters.percentage',
            //     'fee_masters.fine_amount',
            //     'fee_discounts.discount_type',
            //     'fee_discounts.percentage',
            //     'fee_discounts.amount'
            // )
            ->orderBy('assign_fees.due_date')
            ->get();
        // dd($data['assignedFees']);

        // $paidAssignFeeIds = PaidFeeItems::query()
        //     ->join('paid_fees', 'paid_fees.id', 'paid_fee_items.paid_fee_id')
        //     ->where('student_id', $id)
        //     ->pluck('assign_fee_id')->toArray();

        // $data['dueFees'] = $data['assignedFees']->whereNotIn('id', $paidAssignFeeIds);
        // $data['partialFees'] = $data['assignedFees']->whereIn('id', $paidAssignFeeIds)->filter(function ($fee) {
        //     $feeBalance = $fee->amount - $fee->discount_amount + $fee->fine_amount;
        //     return $feeBalance > $fee->amount_paid;
        // });

        // $data['unpaidFees'] = AssignFee::where('student_id', $id)->whereNotIn('id', $paidAssignFeeIds)->get();
        $data['oldBalance'] = PaidFee::query()
            ->selectRaw('SUM(COALESCE(due_amount, 0)) + SUM(COALESCE(fine_amount, 0)) - SUM(COALESCE(discount_amount, 0)) - SUM(COALESCE(paid_amount, 0)) as balanceDue')
            ->where('student_id', $id)
            ->first()?->balanceDue;

        $data['oldBalance'] = $data['oldBalance'] ?? 0;
        $data['advance'] = 0;

        if ($data['oldBalance'] < 0) {
            $data['advance'] = -$data['oldBalance'];
            $data['oldBalance'] = 0;
        }

        // $data['advance'] = PaidFee::where('student_id', $id)->sum('paid_amount');
        // $data['oldBalance'] = 0;

        $data['studentFines'] = $data['student']->studentFines()->unPaid()->latest('id')->get();

        return view('pages.fee.collect_fee.add_fee', $data);
    }

    public function createPaidFee(CreatePaidFeeRequest $request)
    {
        $data = $request->validated();
        $assignFeeIds = $data['assign_fee_id'];

        // trying to pay from advance
        if ($data['paid_amount'] <= 0) {

            // fee items must be selected
            if (count($assignFeeIds) === 0) {
                return response()->json(['message' => 'Please select fees that should be paid.'], 400);
            }

            // advance amount must be availble
            // TODO::check advance amount form DB instead of request which could be altered
            if ($data['advance_amount'] <= 0) {
                return response()->json(['message' => 'Please enter paid amount.'], 400);
            }
        }

        $assignFeeDetails = $this->getAssignFeeDetails($assignFeeIds, $data['student_id']);
        $dueBalance = $assignFeeDetails->reduce(function ($balance, $item) {
            return $balance + $item->amount - $item->discount_amount + $item->fine_amount;
        }, 0);
        // dd($dueBalance);
        $paidData = [
            'student_id' => $data['student_id'],
            'date' => $data['date'],
            'bill_number' => $this->generateReceiptBillNumber(),
            'payment_mode' => $data['payment_mode'],
            'due_amount' => $dueBalance,
            'old_balance' => $data['old_balance'],
            'fine_amount' => $data['fine_amount'],
            'discount_amount' => $data['discount_amount'],
            'paid_amount' => $data['paid_amount'],
            'note' => $data['note'],
        ];

        $printUrl = '';
        DB::beginTransaction();
        try {
            $paidFee = PaidFee::create($paidData);
            $printUrl = route('payment.print', $paidFee->id);

            // pay fine first
            $student = Student::find($data['student_id']);
            $student->studentFines()->whereIn('id', $data['fine_id'])->update(['is_paid' => 1]);

            // pay fee items using reamaining paid balance after fine payment
            // $paidRemainingBalance = $data['paid_amount'] - $data['fine_amount'];
            $collectFeeData = [];
            foreach ($assignFeeDetails as $assignFee) {
                $collectFeeData[] = [
                    'paid_fee_id' => $paidFee->id,
                    'student_id' => $student->id,
                    'fee_type_id' => $assignFee->fee_type_id,
                    'assign_fee_id' => $assignFee->id,
                    'due_date' => $assignFee->due_date,
                    'fee_amount' => $assignFee->amount,
                    'discount' => $assignFee->discount_amount,
                    'fine' => $assignFee->fine_amount,
                    'previous_session_fee' => 0,
                    'total_balance' => $assignFee->amount - $assignFee->discount_amount + $assignFee->fine_amount,
                    'status' => 0
                ];
            }

            // $paidItemsData = collect($assignFeeIds)->map(function ($id) use ($assignFeeBalancesGroup) {
            //     if($paidRemainingBalance > 0){
            //         $paidRemainingBalance -= $paidAmount - 
            //     }
            //     return ['assign_fee_id' => $id, 'paid_amount' => $assignFeeBalancesGroup->get($id)];
            // });
            $paidFee->collect_fees()->createMany($collectFeeData);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Failed to save payment' . $e->getMessage()], 500);
        }

        return response()->json([
            'printUrl' => $printUrl,
            'message' => 'Fee paid Successfully'
        ]);
    }

    public function studentSearch(Request $request)
    {
        $request->validate([
            'student_id' => 'required',
        ], [
            'student_id.required' => 'Please Select Student.'
        ]);
        $studentId = $request->student_id;
        $feeMasterId = $request->fee_master_id;
        $feeDiscountId = $request->fee_discount_id;
        if ($feeMasterId) {
            $feeMaster = FeeMaster::find($feeMasterId);
            $programs = Program::all();
            $students = Student::all();
            $searchedStudents = Student::where('id', $studentId)->get();
            return view('pages.fee.assign_fee.create', compact('searchedStudents', 'programs', 'students', 'feeMaster'));
        } elseif ($feeDiscountId) {
            $feeDiscount = FeeDiscount::find($feeDiscountId);
            $programs = Program::all();
            $students = Student::all();
            $searchedStudents = Student::where('id', $studentId)->get();
            return view('pages.fee.assign_discount.create', compact('searchedStudents', 'programs', 'students', 'feeDiscount'));
        }
        return redirect()->route('student.collect_fee', $studentId);
    }

    public function paymentHistories(Request $request)
    {
        $filters = [
            'from_date' => $request->from_date ?? getTodaySystemDate(),
            'to_date' => $request->to_date ?? getTodaySystemDate(),
        ];

        $data['paymentHistories'] = PaidFee::filterBy($filters)->latest('id')->get();

        $data['filters'] = $filters;

        return view('pages.fee.payment_history.index', $data);
    }

    public function studentPaymentHistories(Request $request, Student $student)
    {
        $filters = [
            'from_date' => $request->from_date ?? getTodaySystemDate(),
            'to_date' => $request->to_date ?? getTodaySystemDate(),
            'student_id' => $student->id
        ];

        $data['paymentHistories'] = PaidFee::filterBy($filters)->latest('id')->get();

        $data['filters'] = $filters;

        $data['student'] = $student;

        return view('pages.fee.payment_history.student', $data);
    }

    public function deletePayment(PaidFee $paidFee)
    {
        $isLastPayment = PaidFee::where('student_id', $paidFee->student_id)->latest('id')->first()?->id == $paidFee->id;
        if (!$isLastPayment) {
            return redirect()->back()->withError('You can only delete last payment of student.');
        }

        $paidFee->collectedFees()->delete();
        $paidFee->delete();
        return redirect()->back()->withSuccess('Payment Deleted Successfully');
    }

    public function printPayment(PaidFee $paidFee, SchoolSettingService $schoolSetting)
    {
        // $paidFee->load(['feeType', 'assignFee']);
        $data['payment'] = $paidFee;
        // $data['payment']->load('collectedFees.feeType')

        $data['setting'] = $schoolSetting->getSetting();

        $data['oldBalance'] = PaidFee::query()
            ->selectRaw('SUM(COALESCE(due_amount, 0)) + SUM(COALESCE(fine_amount, 0)) - SUM(COALESCE(discount_amount, 0)) - SUM(COALESCE(paid_amount, 0)) as balanceDue')
            ->where('id', '<', $paidFee->id)
            ->where('student_id', $paidFee->student_id)
            ->first()?->balanceDue;
        $data['oldBalance'] = $data['oldBalance'] ?? 0;

        return view('pages.fee.payment.print', $data);
    }
}
