@extends('layouts.master')

@section('styles')
<link rel="stylesheet" href="{{asset('css/accounts/reports/trial-balance.css')}}">
@endsection

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Ledger Detail</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Account</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Ledger Detail</a></li>
                </ol>
            </div>
        </div>

        <div class="card print-content">
            <div class="card-header">
                <h4 class="card-title">Filter Data</h4>
            </div>

            <div class="card-body">
                <form id="filter-form" action="{{route('account.reports.mainledger.filter')}}" method="GET">
                    <div class="row">
                        <div class="col-md-4 col-lg-3">
                            <div class="form-group">
                                <label class="form-label">Leger Account</label>
                                <select name="ledger_account_id" class="select">
                                    <option value="">Select Account</option>
                                    @foreach ($ledgerAccounts as $ledgerAccount)
                                    <option value="{{$ledgerAccount->id}}">{{$ledgerAccount->account_name}}
                                        ({{$ledgerAccount->accountCategory->name}})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-3">
                            <div class="form-group">
                                <label class="form-label">From Date</label>
                                <input type="text" class="form-control system-datepicker" name="from_date"
                                    value="{{ $fiscalYear->start_date ?? getTodaySystemDate() }}">
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-3">
                            <div class="form-group">
                                <label class="form-label">To Date</label>
                                <input type="text" class="form-control system-datepicker" name="to_date"
                                    value="{{ $fiscalYear->end_date ?? getTodaySystemDate() }}">
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-3">
                            <div class="form-group mt-md-lh">
                                <button id="submit-button" type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div id="report-container" class="card" style="display: none">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-8">
                        <p class="mb-0">
                            For the period of
                            <span id="from-date" class="fw-bold"></span>
                            to
                            <span id="to-date" class="fw-bold"></span>
                        </p>
                    </div>
                    <div class="col-md-4 text-right d-print-none">
                        {{-- <a
                            href="{{route('account.reports.trialbalance.print', ['from_date' => $filters['from_date'], 'to_date' => $filters['to_date']])}}"
                            target="_blank" type="button" class="btn btn-warning btn-sm ml-2" data-toggle="tooltip"
                            title="Print">
                            <i class="material-icons">print</i>
                        </a> --}}
                    </div>
                </div>

                <table id="report-table" class="table table-bordered">
                    <thead>
                        <tr class="bg-dark text-white">
                            <th>Date</th>
                            <th>Voucher No.</th>
                            <th>Cheque No.</th>
                            <th>Description</th>
                            <th class="text-right" width="12%">Opening Balance ({{config('app.currency')}})</th>
                            <th class="text-right" width="12%">Debit ({{config('app.currency')}})</th>
                            <th class="text-right" width="12%">Credit ({{config('app.currency')}})</th>
                            <th class="text-right" width="12%" colspan="2">Balance ({{config('app.currency')}})</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{asset('js/accounts/reports/common.js')}}"></script>
<script src="{{asset('js/accounts/reports/ledger-detail.js')}}"></script>
<script>
    $(function(){
      $('#filter-form').submit(function(e){
          e.preventDefault();

          const ledgerAccountId = $('select[name="ledger_account_id"]', this).val();    
          if(!ledgerAccountId){
              hideButtonLoader('#submit-button');
              alertBox.showAlert(ALERT_TYPES.ERROR, 'Please select Ledger Account');
              return;
          }

          const fromDate = $('input[name="from_date"]', this).val();            
          const toDate = $('input[name="to_date"]', this).val();  
          
          if(!fromDate || !toDate){
              hideButtonLoader('#submit-button');
              alertBox.showAlert(ALERT_TYPES.ERROR, 'From date & To date are required!');
              return;
          }

          $('#report-container').hide();
          $('#report-view-toggle>label:first-child').trigger('click');
          showButtonLoader('#submit-button');

          const filterUrl = $(this).attr('action');
          filterLedgerDetail(filterUrl, {
            "ledger_account_id": ledgerAccountId,
            "from_date": fromDate,
            "to_date": toDate
          });
      });
  });
</script>
@endsection