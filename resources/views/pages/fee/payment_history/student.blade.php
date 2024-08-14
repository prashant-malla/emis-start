@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Payment Histories : {{$student->sname}}</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Payment Histories</a></li>
                    </ol>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Filter By Date</h4>
                </div>
                <div class="card-body">
                    <form action="{{route('payment_history.student', $student)}}" method="GET">
                        <div class="row">
                          <div class="col-md-4 col-lg-3">
                            <div class="form-group">
                              <label class="form-label">From Date</label>
                              <input type="text" class="form-control system-datepicker" name="from_date"
                                value="{{$filters['from_date'] ?? getTodaySystemDate()}}">
                            </div>
                          </div>
                          <div class="col-md-4 col-lg-3">
                            <div class="form-group">
                              <label class="form-label">To Date</label>
                              <input type="text" class="form-control system-datepicker" name="to_date"
                                value="{{$filters['to_date'] ?? getTodaySystemDate()}}">
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

            <h4 class="text-center">Total Collection: {{config('app.currency')}} {{convertToMoney($paymentHistories->sum('paid_amount'))}}</h4>

            <div class="row">
                <div class="col-lg-12">
                    <div class="row tab-content">
                        <div id="list-view" class="tab-pane fade active show col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    @include('includes.message')
                                    <div class="table-responsive">
                                        <table id="example3" class="display" style="min-width: 845px">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Bill Number</th>
                                                    <th>Student</th>
                                                    <th>Payment Mode</th>
                                                    <th>Due Amount</th>
                                                    <th>Old Balance</th>
                                                    <th>Paid Amount</th>
                                                    {{-- <th>Balance</th>
                                                    <th>Advance</th> --}}
                                                    {{-- <th>Discount Amount</th>
                                                    <th>Fine Amount</th> --}}
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {{-- @php
                                                    $totalDueAmount = 0;
                                                    $totalOldBalanceAmount = 0;
                                                    $totalPaidAmount = 0;
                                                @endphp --}}
                                                @foreach($paymentHistories as $key => $paymentHistory)
                                                    {{-- @php
                                                        $totalDueAmount += $paymentHistory->due_amount;
                                                        $totalOldBalanceAmount += $paymentHistory->old_balance;
                                                        $totalPaidAmount += $paymentHistory->paid_amount;
                                                    @endphp --}}
                                                    <tr>
                                                        <td>{{ $paymentHistory->date }}</td>
                                                        <td>{{ $paymentHistory->bill_number }}</td>
                                                        <td>{{ $paymentHistory->student?->sname }}</td>
                                                        <td>{{ $paymentHistory->payment_mode }}</td>
                                                        <td>{{ $paymentHistory->due_amount }}</td>
                                                        <td>{{ $paymentHistory->old_balance }}</td>
                                                        <td>{{ $paymentHistory->paid_amount }}</td>
                                                        {{-- <td>{{ $balance > 0 ? $balance : 0 }}</td>
                                                        <td>{{ $balance < 0 ? -$balance : 0}}</td> --}}
                                                        {{-- <td>{{ $paymentHistory->discount_amount }}</td>
                                                        <td>{{ $paymentHistory->fine_amount }}</td> --}}
                                                        <td>
                                                            <a href="{{route('payment.print', $paymentHistory)}}" target="_blank" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Print">
                                                                <i class="fa fa-print"></i>
                                                            </a>
                                                            @if($key == 0)
                                                                <x-actions.delete :route="route(
                                                                    'payment.destroy',
                                                                    $paymentHistory,
                                                                )" />
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            {{-- <tfoot>
                                                <tr>
                                                    <th colspan="3" class="text-center">Total</th>
                                                    <th>{{ $totalDueAmount }}</th>
                                                    <th>{{ $totalOldBalanceAmount }}</th>
                                                    <th>{{ $totalPaidAmount }}</th>
                                                </tr>
                                            </tfoot> --}}
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



