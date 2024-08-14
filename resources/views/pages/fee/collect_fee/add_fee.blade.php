@extends('layouts.master')
@section('styles')
<style>
    .member-image img {
        height: 100px;
        width: 100px;
        border-radius: 50%;
    }

    .member-card {
        padding-left: 20px;
        padding-right: 20px;
        padding-top: 30px;
        padding-bottom: 30px;
        background-color: #fff;
    }

    .member-name {
        text-align: center;
        padding: 5px 5px;
    }

    hr {
        color: #dedede;
    }

    table input[readonly] {
        border-color: transparent
    }

    #fineModal td,
    #fineModal th {
        vertical-align: middle
    }

    .cursor-pointer {
        cursor: pointer;
    }
</style>
@endsection
@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Collect Student Fee</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Fee Collection</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Collect Fee</a></li>
                </ol>
            </div>
        </div>

        @include('includes.message')

        @include('pages.fee.collect_fee.partials.student-details')

        <form id="paidFeeForm" class="validate" action="{{route('paid_fee.store')}}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-8 order-1">
                    <div class="card">
                        <div class="card-body">
                            <h5>Fees List</h5>
                            <p>Select fees that should be paid.</p>
                            <div id="assign_fee_id_error_msg" class="clearable text-danger"></div>
                            <div class="table-responsive">
                                @include('pages.fee.collect_fee.partials.fee-list-table')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <input type="hidden" name="student_id" value="{{$student->id}}">
                            <input type="hidden" name="advance_amount" value="{{$advance}}">
                            <input type="hidden" name="old_balance" value="{{$oldBalance}}">
                            {{-- <input type="hidden" name="old_dues_id"
                                value="{{$partialFees->pluck('id')->join(',')}}"> --}}
                            <div class="card h-auto">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4 cursor-pointer" data-bs-toggle="modal"
                                            data-bs-target="#partialPaidFeeModal">
                                            <p class="mb-0 small text-muted">Old Dues
                                                {{-- <i class="fa fa-info-circle"></i> --}}
                                            </p>
                                            <h5>NPR {{convertToMoney($oldBalance)}}</h5>
                                        </div>
                                        <div class="col-4">
                                            <p class="mb-0 small text-muted">Final Due</p>
                                            <h5 class="text-danger">NPR <span
                                                    id="final-due-display">{{convertToMoney($studentFines->sum('amount')
                                                    + $oldBalance)}}</span></h5>
                                        </div>
                                        <div class="col-4">
                                            <p class="mb-0 small text-muted">Total Advance</p>
                                            <h5 class="text-success">NPR <span
                                                    id="advance-display">{{convertToMoney($advance)}}</span></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Payment Date</label><span
                                            style="color: red">&#42;</span>
                                        <input type="date" class="form-control system-datepicker" name="date"
                                            value="{{getTodaySystemDate()}}">
                                        <div id="date_error_msg" class="clearable text-danger"></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Payment Mode</label><span
                                            style="color: red">&#42;</span>
                                        <select class="form-control select" name="payment_mode" id="payment_mode"
                                            required>
                                            <option value='cash' selected>Cash</option>
                                            <option value='cheque'>Cheque</option>
                                            <option value='bank_transfer'>Bank Transfer</option>
                                            <option value='card'>Card</option>
                                        </select>
                                        <div id="payment_mode_error_msg" class="clearable text-danger"></div>
                                    </div>
                                </div>
                                {{-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Additional Fine Amount</label>
                                        <div class="btn-group">
                                            <input type="number" class="form-control" name="fine_amount"
                                                id="totalFineAmount" min="0" value="{{$studentFines->sum('amount')}}">
                                            <a href="#" class="btn btn-info" data-bs-toggle="modal"
                                                data-bs-target="#fineModal">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </div>
                                        <div id="fine_amount_error_msg" class="clearable text-danger"></div>
                                    </div>
                                </div> --}}
                                {{-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Discount Amount</label>
                                        <input type="number" class="form-control" name="discount_amount"
                                            id="totalDiscountAmount" min="0">
                                        <div id="discount_amount_error_msg" class="clearable text-danger"></div>
                                    </div>
                                </div> --}}
                                {{-- <div class="col-md-12">
                                    <div class="bg-light p-3 text-center mb-3">
                                        <label>
                                            <input type="checkbox" name="apply_advance"> Apply Advance
                                        </label>
                                        <table class="table">
                                            <tr>
                                                <td class="text-left">Receivable Amount</td>
                                                <th class="text-right">
                                                    NPR
                                                    <span id="receivable-amount">{{convertToMoney($oldBalance)}}</span>
                                                </th>
                                            </tr>
                                        </table>
                                    </div>
                                </div> --}}
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Received Amount</label>
                                        <input type="number" class="form-control" name="paid_amount"
                                            id="totalPaidAmount" min="{{$oldBalance}}">
                                        <p class="mb-0 small text-muted">Amount received more than due amount will be
                                            considered Advance.</p>
                                        <div id="paid_amount_error_msg" class="clearable text-danger"></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Note</label>
                                        <textarea name="note" class="form-control"
                                            placeholder=""></textarea>
                                        <div id="note_error_msg" class="clearable text-danger"></div>
                                    </div>
                                </div>
                            </div>
                            <span id="paid_amount_error_msg"></span>

                            <div class="row mx-n1">
                                <div class="col-6 px-1">
                                    <button type="submit" class="submit-button btn btn-success btn-block">Save
                                        Payment</button>
                                </div>
                                <div class="col-6 px-1">
                                    <button type="submit" class="submit-button btn btn-success btn-block" data-print="1">Save
                                        & Print</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        @include('pages.fee.collect_fee.partials.student-fines-modal')
        {{-- @include('pages.fee.collect_fee.partials.partial-paid-fee-modal') --}}
    </div>
</div>
@endsection
@section('scripts')
<script src="{{asset('js/fee_collection/fee-collection.js')}}"></script>
<script>
    const oldDue = "{{$oldBalance}}";
    const advance = "{{$advance}}";
</script>
@endsection