<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class AccountReportService
{
    public function dateLiesWithinFiscalYear($fiscalYear, $date)
    {
        if ($date < convertToEngDate($fiscalYear->start_date) || $date > convertToEngDate($fiscalYear->end_date)) {
            return false;
        }

        return true;
    }

    public function fromToDateLiesWithinFiscalYear($fiscalYear, $fromDate, $toDate)
    {
        if ($fromDate < convertToEngDate($fiscalYear->start_date) || $toDate > convertToEngDate($fiscalYear->end_date)) {
            return false;
        }

        return true;
    }

    // TODO::filter transactions of only one fiscal year for performance
    public function getApprovedVoucherTransactionsBetweenDatesSubQuery($fromDate = null, $toDate)
    {
        $formDateQueryString = $fromDate ? "v.date >= '$fromDate' AND" : "";

        return DB::raw("
        (SELECT 
            gl.ledger_account_id, 
            SUM(gl.debit_amount) as debit_amount, 
            SUM(gl.credit_amount) as credit_amount
        FROM vouchers v
        JOIN general_ledgers gl ON gl.voucher_id = v.id
        WHERE 
            v.approval_status = 1 AND 
            $formDateQueryString 
            v.date <= '$toDate'
        GROUP BY 
            gl.ledger_account_id
        )
        AS t
    ");
    }
}
