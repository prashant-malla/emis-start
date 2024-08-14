@extends('layouts.master')

@section('styles')
<style>
  .total-row,
  .category-row,
  .grand-total-row {
    margin-top: 5px
  }

  .total-row .right-col {
    border-top: 1px solid #000;
  }

  .grand-total-row .right-col {
    border-top: 1px solid #000;
    border-bottom: 4px double #000;
  }
</style>
@endsection

@section('content')
<div class="content-body">
  <div class="container-fluid">
    <div class="row page-titles mx-0">
      <div class="col-sm-6 p-md-0">
        <div class="welcome-text">
          <h4>Profit & Loss</h4>
        </div>
      </div>
      <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
        <ol class="breadcrumb">
          <li class="breadcrumb-item active"><a href="javascript:void(0);">Account</a></li>
          <li class="breadcrumb-item active"><a href="javascript:void(0);">Profit & Loss</a></li>
        </ol>
      </div>
    </div>

    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Filter Data</h4>
      </div>
      <div class="card-body">
        <form action="{{route('account.reports.profitloss')}}" method="GET">
          <div class="row">
            <div class="col-md-4 col-lg-3">
              <div class="form-group">
                <label class="form-label">From Date</label>
                <input type="text" class="form-control system-datepicker" name="from_date"
                  value="{{$filters['from_date'] ?? getTodaySystemDate()}}">
                <x-error key='from_date' />
              </div>
            </div>
            <div class="col-md-4 col-lg-3">
              <div class="form-group">
                <label class="form-label">To Date</label>
                <input type="text" class="form-control system-datepicker" name="to_date"
                  value="{{$filters['to_date'] ?? getTodaySystemDate()}}">
                <x-error key='to_date' />
              </div>
            </div>
            <div class="col-md-4 col-lg-3">
              <div class="form-group mt-md-lh">
                <button type="submit" class="btn btn-primary">Search</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>

    @if(count($transactions) > 0)
    <div class="row">
      <div class="col-lg-12">
        <div class="row tab-content">
          <div id="list-view" class="tab-pane fade active show col-lg-12">
            <div class="card">
              <div class="card-body">
                <p>
                  For the period of
                  <span class="fw-bold">{{$filters['from_date'] ?? getTodaySystemDate()}}</span>
                  to
                  <span class="fw-bold">{{$filters['to_date'] ?? getTodaySystemDate()}}</span>
                </p>

                <div class="statement-data">

                  <div class="row heading-row">
                    <div class="col-7 left-col"></div>
                    <div class="col-5 right-col">
                      <div class="row">
                        <div class="col-6 fw-bold">Amount({{config('app.currency')}})</div>
                        <div class="col-6 fw-bold">Percent</div>
                      </div>
                    </div>
                  </div>

                  {{-- Income --}}
                  <div class="row category-row">
                    <div class="col-7 left-col">
                      <div class="text-uppercase fw-bold">Income</div>
                    </div>
                    <div class="col-5 right-col"></div>
                  </div>

                  @foreach($transactions->where('type', 'Income')->groupBy('category') as $categoryName =>
                  $incomeTransactions)
                  <div class="row category-row">
                    <div class="col-7 left-col">
                      <div class="pl-4 fw-bold">{{ $categoryName }}</div>
                    </div>
                    <div class="col-5 right-col"></div>
                  </div>
                  @foreach($incomeTransactions as $transaction)
                  <div class="row">
                    <div class="col-7 left-col">
                      <div class="pl-4">
                        <div class="pl-4">{{$transaction->account_name}}</div>
                      </div>
                    </div>
                    <div class="col-5 right-col">
                      <div class="row">
                        <div class="col-6">{{$transaction->total_credit}}</div>
                        <div class="col-6">{{round(($transaction->total_credit / $totalRevenue) * 100, 2)}} %</div>
                      </div>
                    </div>
                  </div>
                  @endforeach
                  @endforeach

                  <div class="row total-row">
                    <div class="col-7 left-col">
                      <div class="text-uppercase fw-bold pl-4">Total Income</div>
                    </div>
                    <div class="col-5 right-col">
                      <div class="row">
                        <div class="col-6 fw-bold">{{convertToMoney($totalRevenue)}}</div>
                        <div class="col-6 fw-bold">{{round(($totalRevenue / ($totalRevenue + $totalExpense)) * 100,
                          2)}}%</div>
                      </div>
                    </div>
                  </div>

                  {{-- Expense --}}
                  <div class="row category-row">
                    <div class="col-7 left-col">
                      <div class="text-uppercase fw-bold">Expenditure</div>
                    </div>
                    <div class="col-5 right-col"></div>
                  </div>

                  @foreach($transactions->where('type', 'Expenses')->groupBy('category') as $categoryName =>
                  $expenseTransactions)
                  <div class="row category-row">
                    <div class="col-7 left-col">
                      <div class="pl-4 fw-bold">{{ $categoryName }}</div>
                    </div>
                    <div class="col-5 right-col"></div>
                  </div>
                  @foreach($expenseTransactions as $transaction)
                  <div class="row">
                    <div class="col-7 left-col">
                      <div class="pl-4">
                        <div class="pl-4">{{$transaction->account_name}}</div>
                      </div>
                    </div>
                    <div class="col-5 right-col">
                      <div class="row">
                        <div class="col-6">{{$transaction->total_debit}}</div>
                        <div class="col-6">{{round(($transaction->total_debit / $totalExpense) * 100, 2)}} %</div>
                      </div>
                    </div>
                  </div>
                  @endforeach
                  @endforeach

                  <div class="row total-row">
                    <div class="col-7 left-col">
                      <div class="text-uppercase fw-bold pl-4">Total Expenditure</div>
                    </div>
                    <div class="col-5 right-col">
                      <div class="row">
                        <div class="col-6 fw-bold">{{convertToMoney($totalExpense)}}</div>
                        <div class="col-6 fw-bold">{{round(($totalExpense / ($totalRevenue + $totalExpense)) *
                          100, 2)}}%</div>
                      </div>
                    </div>
                  </div>

                  <div class="row grand-total-row">
                    <div class="col-7 left-col">
                      <div class="text-uppercase fw-bold">Net Profit</div>
                    </div>
                    <div class="col-5 right-col">
                      <div class="row">
                        <div @class(['col-6 fw-bold', 'text-success' => $netIncome > 0, 'text-danger' => $netIncome < 0])>{{convertToMoney($netIncome)}}</div>
                        <div @class(['col-6 fw-bold', 'text-success' => $netIncome > 0, 'text-danger' => $netIncome < 0])>
                          {{round(($netIncome / ($totalRevenue + $totalExpense)) * 100, 2)}}%
                          </div>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endif
  </div>
</div>
@endsection