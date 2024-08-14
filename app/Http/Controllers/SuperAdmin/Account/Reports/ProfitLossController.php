<?php

namespace App\Http\Controllers\SuperAdmin\Account\Reports;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfitLossFilterRequest;
use App\Models\AccountCategory;
use App\Models\FiscalYear;
use App\Services\AccountReportService;
use Illuminate\Support\Facades\DB;

class ProfitLossController extends Controller
{
    private $categoryTypes = ['Income', 'Expenses'];

    public function index()
    {
        $data['fiscalYear'] = FiscalYear::active()->first();
        return view('pages.account.reports.profit_loss.index', $data);
    }

    public function filter(ProfitLossFilterRequest $request, AccountReportService $accountReportService)
    {
        $fromDate = convertToEngDate($request->from_date);
        $toDate = convertToEngDate($request->to_date);

        $fiscalYear = FiscalYear::active()->first();
        if (!$fiscalYear) {
            return response()->json([
                'message' => 'You don\'t have any active fiscal year.'
            ], 403);
        }

        if (!$accountReportService->fromToDateLiesWithinFiscalYear($fiscalYear, $fromDate, $toDate)) {
            return response()->json([
                'message' => 'Date must be within active fiscal year.'
            ], 403);
        }

        // TODO::check performance using subquery as well
        // $approvedVoucherTransactionsBetweenDatesSubQuery = $accountReportService->getApprovedVoucherTransactionsBetweenDatesSubQuery($fromDate, $toDate);
        // $data['transactions'] = DB::table('ledger_accounts as la')
        //     ->join('account_categories as ac', 'ac.id', '=', 'la.account_category_id')
        //     ->leftJoin($approvedVoucherTransactionsBetweenDatesSubQuery, 't.ledger_account_id', '=', 'ledger_accounts.id')
        //     ->select(
        //         'la.id as ledger_account_id',
        //         'la.account_name as ledger_account_name',
        //         'ac.id as account_category_id',
        //         'ac.type as type',
        //         'ac.name as account_category_name',
        //         't.debit_amount',
        //         't.credit_amount'
        //     )
        //     ->whereIn('ac.type', $this->categoryTypes)
        //     ->get();
        // dd($data['transactions']);

        $data['transactions'] = DB::table('ledger_accounts as la')
            ->join('account_categories as ac', 'ac.id', '=', 'la.account_category_id')
            ->leftJoin('general_ledgers as gl', 'gl.ledger_account_id', '=', 'la.id')
            ->leftJoin('vouchers as v', 'v.id', '=', 'gl.voucher_id')
            ->select(
                'la.id as ledger_account_id',
                'la.account_name as ledger_account_name',
                'ac.id as account_category_id',
                'ac.type',
                'ac.name as account_category_name',
                'la.balance as opening_balance',
                DB::raw("SUM(
                    CASE 
                        WHEN v.approval_status = 1 AND v.date >= '$fromDate' AND v.date <= '$toDate' THEN gl.debit_amount
                        ELSE 0
                    END
                ) as debit_amount"),
                DB::raw("SUM(
                    CASE 
                        WHEN v.approval_status = 1 AND v.date >= '$fromDate' AND v.date <= '$toDate' THEN gl.credit_amount
                        ELSE 0
                    END
                ) as credit_amount"),
            )
            ->whereIn('ac.type', $this->categoryTypes)
            ->groupBy('la.id', 'la.account_name', 'ac.id', 'ac.type', 'ac.name', 'la.balance')
            ->get();

        $data['totalRevenue'] = $data['transactions']->where('type', 'Income')->sum('credit_amount');
        $data['totalExpense'] = $data['transactions']->where('type', 'Expenses')->sum('debit_amount');
        $data['netIncome'] = $data['totalRevenue'] - $data['totalExpense'];

        $data['categories'] = AccountCategory::query()
            ->select('id', 'name', 'type', 'parent_id')
            ->whereIn('type', $this->categoryTypes)
            ->get();

        return response()->json($data);
    }
}
