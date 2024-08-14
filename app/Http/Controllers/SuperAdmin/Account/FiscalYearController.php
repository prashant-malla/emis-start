<?php

namespace App\Http\Controllers\SuperAdmin\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\FiscalYearRequest;
use App\Models\FiscalYear;
use Illuminate\Http\Request;

class FiscalYearController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['rows'] = FiscalYear::latest('start_date')->get();
        return view('pages.account.setup.fiscal_year.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.account.setup.fiscal_year.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  FiscalYearRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(FiscalYearRequest $request)
    {
        $data = $request->validated();

        if ($data['is_active']) {
            FiscalYear::query()->update(['is_active' => 0]);
        }

        FiscalYear::create($data);

        return
            redirect(route('fiscal_year.index'))
            ->withSuccess('Fiscal Year created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  FiscalYear $fiscalYear
     * @return \Illuminate\Http\Response
     */
    public function edit(FiscalYear $fiscalYear)
    {
        return view('pages.account.setup.fiscal_year.form', ['data' => $fiscalYear]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  FiscalYearRequest $request
     * @param  FiscalYear $fiscalYear
     * @return \Illuminate\Http\Response
     */
    public function update(FiscalYearRequest $request, FiscalYear $fiscalYear)
    {
        $data = $request->validated();

        if ($data['is_active'] && !$fiscalYear->is_active) {
            FiscalYear::query()->update(['is_active' => 0]);
        }

        $fiscalYear->update($data);

        return
            redirect(route('fiscal_year.index'))
            ->withSuccess('Fiscal Year updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  FiscalYear $fiscalYear
     * @return \Illuminate\Http\Response
     */
    public function destroy(FiscalYear $fiscalYear)
    {
        $fiscalYear->delete();

        return
            redirect(route('fiscal_year.index'))
            ->withSuccess('Fiscal Year deleted successfully');
    }
}
