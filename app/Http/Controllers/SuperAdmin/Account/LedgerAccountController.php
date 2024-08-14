<?php

namespace App\Http\Controllers\SuperAdmin\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\LedgerAccountRequest;
use App\Models\AccountCategory;
use App\Models\LedgerAccount;
use App\Services\LedgerAccountService;

class LedgerAccountController extends Controller
{
    public function __construct(
        protected LedgerAccountService $ledgerAccount
    ) {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ledgerAccounts = $this->ledgerAccount->getLatest();

        $ledgerAccounts->load('accountCategory');

        return view('pages.account.ledger_account.index', [
            'rows' => $ledgerAccounts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $accountCategories = AccountCategory::whereNull('parent_id')->get();

        return view('pages.account.ledger_account.form', [
            'accountCategories' => $accountCategories
        ]);
    }

    /**
     * 
     * 
     * Store a newly created resource in storage.
     *
     * @param  LedgerAccountRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LedgerAccountRequest $request)
    {
        $this->ledgerAccount->create($request);

        return
            redirect(route('ledger_account.index'))
            ->withSuccess('Ledger Account created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param LedgerAccount $ledgerAccount
     * @return \Illuminate\Http\Response
     */
    public function edit(LedgerAccount $ledgerAccount)
    {
        $accountCategories = AccountCategory::whereNull('parent_id')->get();

        return view('pages.account.ledger_account.form', [
            'accountCategories' => $accountCategories,
            'data' => $ledgerAccount
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  LedgerAccountRequest  $request
     * @param  LedgerAccount $ledgerAccount
     * @return \Illuminate\Http\Response
     */
    public function update(LedgerAccountRequest $request, LedgerAccount $ledgerAccount)
    {
        $this->ledgerAccount->updateById($ledgerAccount->id, $request);

        return
            redirect(route('ledger_account.index'))
            ->withSuccess('Ledger Account updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  LedgerAccount $ledgerAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy(LedgerAccount $ledgerAccount)
    {
        $this->ledgerAccount->deleteById($ledgerAccount->id);

        return
            redirect(route('ledger_account.index'))
            ->withSuccess('Ledger Account deleted successfully');
    }
}
