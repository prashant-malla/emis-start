<?php

namespace App\Http\Controllers\SuperAdmin\Account\Reports;

use App\Http\Controllers\Controller;
use App\Http\Requests\BalanceSheetFilterRequest;
use App\Models\AccountCategory;
use App\Models\FiscalYear;
use App\Services\AccountReportService;
use Illuminate\Support\Facades\DB;

class BalanceSheetController extends Controller
{
    private $categoryTypes = ['Assets', 'Liabilities'];

    public function index()
    {
        return view('pages.account.reports.balance_sheet.index');
    }

    public function filter(BalanceSheetFilterRequest $request, AccountReportService $accountReportService)
    {
        $asOfDate = convertToEngDate($request->as_of);

        $fiscalYear = FiscalYear::active()->first();
        if (!$fiscalYear) {
            return response()->json([
                'message' => 'You don\'t have any active fiscal year.'
            ], 403);
        }

        if (!$accountReportService->dateLiesWithinFiscalYear($fiscalYear, $asOfDate)) {
            return response()->json([
                'message' => 'Date must be within active fiscal year.'
            ], 403);
        }

        // TODO::check performance using subquery as well
        // $approvedVoucherTransactionsBetweenDatesSubQuery = $accountReportService->getApprovedVoucherTransactionsBetweenDatesSubQuery(null, $asOfDate);
        // $data['transactions'] = DB::table('ledger_accounts as la')
        //     ->join('account_categories as ac', 'ac.id', '=', 'la.account_category_id')
        //     ->leftJoin($approvedVoucherTransactionsBetweenDatesSubQuery, 't.ledger_account_id', '=', 'la.id')
        //     ->select(
        //         'la.id as ledger_account_id',
        //         'la.account_name as ledger_account_name',
        //         'ac.id as account_category_id',
        //         'ac.type',
        //         'ac.name as account_category_name',
        //         'la.balance as opening_balance',
        //         DB::raw("COALESCE(SUM(
        //             CASE 
        //                 WHEN ac.type = 'Assets' THEN t.debit_amount - t.credit_amount
        //                 WHEN ac.type = 'Liabilities' THEN t.credit_amount - t.debit_amount
        //                 ELSE 0
        //             END
        //         ), 0) + la.balance as balance")
        //     )
        //     ->whereIn('ac.type', $this->categoryTypes)
        //     ->groupBy('la.id', 'la.account_name', 'ac.id', 'ac.type', 'ac.name', 'la.balance')
        //     ->get();

        // TODO::filter using fiscal year with opening_balances table instead of checking all rows below certain date for performance
        $data['transactions'] = DB::table('ledger_accounts as la')
            ->join('account_categories as ac', 'ac.id', '=', 'la.account_category_id')
            ->leftJoin('general_ledgers as gl', 'gl.ledger_account_id', '=', 'la.id')
            ->leftJoin('vouchers as v', 'v.id', '=', 'gl.voucher_id')
            ->select(
                'la.id as ledger_account_id',
                'la.account_name as ledger_account_name',
                'ac.type',
                'ac.id as account_category_id',
                'ac.name as account_category_name',
                'la.balance as opening_balance',
                DB::raw("COALESCE(SUM(
                CASE 
                    WHEN ac.type = 'Assets' AND v.approval_status = 1 AND v.date <= '$asOfDate' THEN gl.debit_amount - gl.credit_amount
                    WHEN ac.type = 'Liabilities' AND v.approval_status = 1 AND v.date <= '$asOfDate' THEN gl.credit_amount - gl.debit_amount
                    ELSE 0
                END
            ), 0) + COALESCE(MAX(la.balance), 0) as balance")
            )
            ->whereIn('ac.type', $this->categoryTypes)
            ->groupBy('la.id', 'la.account_name', 'ac.id', 'ac.type', 'ac.name', 'la.balance')
            ->get();

        $startDate = convertToEngDate($fiscalYear->start_date);
        $netIncome = DB::table('general_ledgers as gl')
            ->join('ledger_accounts as la', 'gl.ledger_account_id', '=', 'la.id')
            ->join('account_categories as ac', 'la.account_category_id', '=', 'ac.id')
            ->join('vouchers as v', 'gl.voucher_id', '=', 'v.id')
            ->select(
                DB::raw("SUM(CASE 
                    WHEN ac.type = 'Income' THEN gl.credit_amount 
                    ELSE -gl.debit_amount
                END) as netIncome")
            )
            ->whereIn('ac.type', ['Income', 'Expenses'])
            ->where('v.approval_status', array_search('Approved', APPROVAL_STATUS))
            ->whereBetween('v.date', [$startDate, $asOfDate])
            ->first()?->netIncome;

        $data['netIncome'] = $netIncome ?? 0;

        $data['categories'] = AccountCategory::query()
            ->select('id', 'name', 'type', 'parent_id')
            ->whereIn('type', $this->categoryTypes)
            ->get();

        return response()->json($data);
    }
}
