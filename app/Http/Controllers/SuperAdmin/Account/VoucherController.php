<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers\SuperAdmin\Account;

use App\Enum\VoucherTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\VoucherRequest;
use App\Models\FiscalYear;
use App\Models\Voucher;
use App\Services\LedgerAccountService;
use App\Services\SchoolSettingService;
use App\Services\VoucherService;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function __construct(
        protected VoucherService $voucher,
        protected LedgerAccountService $ledgerAccount
    ) {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $fiscalYear = FiscalYear::active()->first();

        $defaultFilters = [
            'from_date' => $fiscalYear->start_date ?? getTodaySystemDate(),
            'to_date' => getTodaySystemDate()
        ];
        $filters = array_merge($defaultFilters, $request->only('approval_status', 'from_date', 'to_date'));

        $vouchers = $this->voucher->getLatest($filters);

        return view('pages.account.voucher.index', [
            'fiscalYear' => $fiscalYear,
            'filters' => $filters,
            'rows' => $vouchers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ledgerAccounts = $this->ledgerAccount->getOldest();
        $ledgerAccounts->load('accountCategory');

        return view('pages.account.voucher.form', [
            // 'voucherTypes' => VoucherTypeEnum::cases(),
            'voucherTypes' => VOUCHER_TYPES,
            'ledgerAccounts' => $ledgerAccounts
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  VoucherRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VoucherRequest $request)
    {
        $this->voucher->create($request);

        return
            redirect(route('voucher.index'))
            ->withSuccess('Voucher created successfully');
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
     * @param  Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function edit(Voucher  $voucher)
    {
        $ledgerAccounts = $this->ledgerAccount->getOldest();
        $ledgerAccounts->load('accountCategory');

        $voucher->load('generalLedgers');

        return view('pages.account.voucher.form', [
            // 'voucherTypes' => VoucherTypeEnum::cases(),
            'voucherTypes' => VOUCHER_TYPES,
            'ledgerAccounts' => $ledgerAccounts,
            'data' => $voucher
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  VoucherRequest  $request
     * @param  Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function update(VoucherRequest $request, Voucher  $voucher)
    {
        $this->voucher->update($voucher, $request);

        return
            redirect(route('voucher.index'))
            ->withSuccess('Voucher created successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Voucher  $voucher)
    {
        $this->voucher->delete($voucher);

        return
            redirect(route('voucher.index'))
            ->withSuccess('Voucher deleted successfully');
    }

    /**
     * Approve voucher.
     *
     * @param  Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function approve(Voucher $voucher)
    {
        $this->voucher->approve($voucher->id);

        return
            redirect(route('voucher.index'))
            ->withSuccess('Voucher approved successfully');
    }

    /**
     * Disapprove voucher.
     *
     * @param  Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function disapprove(Voucher $voucher)
    {
        $this->voucher->disapprove($voucher->id);

        return
            redirect(route('voucher.index'))
            ->withSuccess('Voucher disapproved successfully');
    }

    /**
     * Print voucher.
     *
     * @param  Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function print(Voucher $voucher, SchoolSettingService $schoolSetting)
    {
        $setting = $schoolSetting->getSetting();

        return view('pages.account.voucher.print', [
            'voucher' => $voucher,
            'setting' => $setting,
        ]);
    }
}
