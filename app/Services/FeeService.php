<?php

namespace App\Services;

use App\Models\AssignFee;
use App\Models\FeeBill;
use App\Models\PaidFee;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class FeeService
{
    public function getStudentFees(Student $student)
    {
        $collectedAssignFeeIds = $student->collectFees()->pluck('assign_fee_id');

        // creates intermediate table joining fee_discounts and assign_discounts for query
        $studentFeeDiscountQueryTable = DB::raw("
        (SELECT DISTINCT fee_discounts.* 
        FROM fee_discounts 
        JOIN assign_discounts ON assign_discounts.fee_discount_id = fee_discounts.id 
        WHERE assign_discounts.student_id = $student->id) AS student_fee_discounts
        ");

        // get all assigned fees with associated discount, fine
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
                // DB::raw("CASE 
                //     WHEN fee_masters.fine_type = 'Percentage' AND CURRENT_DATE > assign_fees.due_date THEN fee_masters.amount * fee_masters.percentage / 100
                //     WHEN fee_masters.fine_type = 'Fix Amount' AND CURRENT_DATE > assign_fees.due_date THEN fee_masters.fine_amount
                //     ELSE 0
                // END as fine_amount"),
                DB::raw("CASE 
                    WHEN student_fee_discounts.discount_type = 'Percentage' THEN fee_masters.amount * student_fee_discounts.percentage / 100
                    WHEN student_fee_discounts.discount_type = 'Amount' THEN student_fee_discounts.amount
                    ELSE 0
                END as discount_amount"),
            )
            ->where('assign_fees.student_id', $student->id)
            ->whereNotIn('assign_fees.id', $collectedAssignFeeIds)
            ->orderBy('assign_fees.due_date')
            ->get();
    }

    public function getStudentOldBalance(Student $student)
    {
        $lastPayment = PaidFee::where('student_id', $student->id)->latest('id')->first();

        return $lastPayment ? $lastPayment->old_balance : 0;
    }

    public function getLastBillSequenceNumber()
    {
        $lastBill = FeeBill::latest('id')->first();
        if ($lastBill) {
            return $lastBill->sequence_number;
        }
        return 0;
    }

    public function generateBillNumber($sequenceNumber)
    {
        // Place to add Further logic for prefix/suffix
        return $sequenceNumber;
    }
}
