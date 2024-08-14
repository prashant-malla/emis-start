<?php

namespace App\Http\Controllers\SuperAdmin\Account\Reports;

use App\Http\Controllers\Controller;
use App\Http\Requests\TrialBalanceFilterRequest;
use App\Models\AccountCategory;
use App\Models\FiscalYear;
use App\Models\GeneralLedger;
use App\Models\LedgerAccount;
use App\Services\AccountReportService;
use App\Services\SchoolSettingService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrialBalanceController extends Controller
{
    public function index()
    {
        $data['fiscalYear'] = FiscalYear::active()->first();
        return view('pages.account.reports.trial_balance.index', $data);
    }

    public function filter(TrialBalanceFilterRequest $request, AccountReportService $accountReportService)
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

        // TODO::filter using fiscal year with opening_balances table instead of checking all rows below certain date for performance
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
                DB::raw("COALESCE(SUM(
                    CASE 
                        WHEN ac.type IN ('Assets', 'Expenses') AND v.approval_status = 1 AND v.date <= '$asOfDate' THEN gl.debit_amount - gl.credit_amount
                        WHEN ac.type IN ('Liabilities', 'Income') AND v.approval_status = 1 AND v.date <= '$asOfDate' THEN gl.credit_amount - gl.debit_amount
                        ELSE 0
                    END
                ), 0) + COALESCE(MAX(la.balance), 0) as balance")
            )
            ->groupBy('la.id', 'la.account_name', 'ac.id', 'ac.type', 'ac.name', 'la.balance')
            ->get();

        $data['categories'] = AccountCategory::query()
            ->select('id', 'name', 'type', 'parent_id')
            ->get();

        return response()->json($data);
    }

    public function print(Request $request, SchoolSettingService $schoolSetting)
    {
        $data = [];

        if ($request->from_date && $request->to_date) {

            $data['ledgerAccounts'] = LedgerAccount::all();

            $data['transactions'] = GeneralLedger::whereHas(
                'voucher',
                function (Builder $query) use ($request) {
                    $query->approved()
                        ->whereBetween('date', [convertToEngDate($request->from_date), convertToEngDate($request->to_date)]);
                }
            )
                ->get();

            // $legerAccountIds = $data['transactions']
            //     ->pluck('ledger_account_id')
            //     ->unique()
            //     ->toArray();

            // $data['ledgerAccounts'] = LedgerAccount::whereIn('id', $legerAccountIds)
            //     ->get();

            $data['categories'] = AccountCategory::whereNull('parent_id')
                ->with('allChildren')
                ->get();
        }

        $data['filters'] =  $request->all('from_date', 'to_date');
        $data['setting'] =  $schoolSetting->getSetting();

        return view('pages.account.reports.trial_balance.print', $data);
    }
}
