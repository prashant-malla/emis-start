<?php

namespace App\Http\Controllers\SuperAdmin\Account\Reports;

use App\Http\Controllers\Controller;
use App\Http\Requests\LedgerDetailFilterRequest;
use App\Models\FiscalYear;
use App\Models\LedgerAccount;
use App\Models\Voucher;
use Illuminate\Support\Facades\DB;

class MainLedgerController extends Controller
{
    public function index()
    {
        $data['fiscalYear'] = FiscalYear::active()->first();
        $data['ledgerAccounts'] = LedgerAccount::select('id', 'account_name', 'account_category_id')->with('accountCategory')->get();

        return view('pages.account.reports.ledger.index', $data);
    }

    public function dateLiesWithinFiscalYear($fiscalYear, $fromDate, $toDate)
    {
        if ($fiscalYear && ($fromDate < convertToEngDate($fiscalYear->start_date) || $toDate > convertToEngDate($fiscalYear->end_date))) {
            return false;
        }

        return true;
    }

    public function filter(LedgerDetailFilterRequest $request)
    {
        $fromDate = convertToEngDate($request->from_date);
        $toDate = convertToEngDate($request->to_date);

        $fiscalYear = FiscalYear::active()->first();
        if (!$this->dateLiesWithinFiscalYear($fiscalYear, $fromDate, $toDate)) {
            return response()->json([
                'message' => 'From Date and To Date must be within active fiscal year.'
            ], 403);
        }

        $ledgerAccountId = $request->ledger_account_id;
        $ledgerAccount = LedgerAccount::find($ledgerAccountId);
        $balanceType = collect(DEBIT_ACCOUNT_TYPES)->contains($ledgerAccount->accountCategory->type) ? 'debit' : 'credit';

        // Calculate previous balance based on filter start date
        $previousBalance = DB::table('general_ledgers as gl')
            ->join('ledger_accounts as la', 'gl.ledger_account_id', '=', 'la.id')
            ->join('vouchers as v', 'gl.voucher_id', '=', 'v.id')
            ->selectRaw('SUM(gl.debit_amount - gl.credit_amount) as balance')
            ->where([
                'v.approval_status' => array_search('Approved', APPROVAL_STATUS),
                'la.id' => $ledgerAccountId
            ])
            ->where('date', '<', $fromDate)
            ->groupBy('la.balance')
            ->first()?->balance;

        $previousBalance = $previousBalance ?? 0;

        // credit-debit for credit account types
        if ($balanceType === 'credit') {
            $previousBalance = -$previousBalance;
        }

        // TODO::sum closing balance of previous fiscal year instead of ledger opening balance ($ledgerAccount->balance)
        $data['previousBalance'] = $ledgerAccount->balance + $previousBalance;

        $data['transactions'] = Voucher::query()
            ->join('general_ledgers as gl', 'gl.voucher_id', '=', 'vouchers.id')
            ->join('ledger_accounts as la', 'gl.ledger_account_id', '=', 'la.id')
            ->select(
                'date',
                'voucher_number',
                'cheque_number',
                'description',
                DB::raw('SUM(gl.debit_amount) as debit_amount'),
                DB::raw('SUM(gl.credit_amount) as credit_amount'),
                DB::raw("COALESCE(SUM(
                    CASE 
                        WHEN '$balanceType' = 'debit' THEN gl.debit_amount - gl.credit_amount
                        WHEN '$balanceType' = 'credit' THEN gl.credit_amount - gl.debit_amount
                        ELSE 0
                    END
                ), 0) as balance"),
            )
            ->where([
                'approval_status' => 1,
                'la.id' => $ledgerAccountId
            ])
            ->whereBetween('date', [$fromDate, $toDate])
            ->groupBy('date', 'voucher_number', 'cheque_number', 'description')
            ->oldest('date')
            ->get();

        $data['balanceType'] = $balanceType;
        $data['isOpeningBalance'] = $fiscalYear && $fromDate === convertToEngDate($fiscalYear->start_date);

        return response()->json($data);
    }
}
