@extends('layouts.master')

@section('styles')
<style>
  .form-control.disabled {
    pointer-events: none;
  }

  #voucher-entry-table tbody td:not(.action-td) {
    vertical-align: top;
  }

  #voucher-entry-table tbody input {
    min-width: 100px;
  }
</style>
@endsection

@section('content')
<div class="content-body">
  <div class="container-fluid">
    <div class="row page-titles mx-0">
      <div class="col-sm-6 p-md-0">
        <div class="welcome-text">
          <h4>Voucher Entry</h4>
        </div>
      </div>
      <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="javascript:void(0);">Account</a></li>
          <li class="breadcrumb-item"><a href="javascript:void(0);">{{isset($data) ? 'Edit' : 'Add'}} Voucher</a>
          </li>
        </ol>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="row tab-content">
          <div id="list-view" class="tab-pane fade active show col-lg-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">{{isset($data) ? 'Edit' : 'Add'}} Voucher Entry</h4>
              </div>
              <div class="card-body">

                @php($formAction = isset($data) ? route('voucher.update', $data) : route('voucher.store'))

                <form class="validate" action="{{ $formAction }}" method="POST"
                  onsubmit="return isValidVoucherEntry(this)">

                  @csrf
                  @isset($data)
                  @method('put')
                  @endisset

                  <div class="row">
                    <div class="col-md-6 col-lg-3">
                      <div class="form-group">
                        <label class="form-label">Voucher Type <span class="text-danger">*</span></label>
                        <select name="type" id="voucher-type" class="form-control select" required>
                          @foreach($voucherTypes as $voucherType)
                          @php($selected = isset($data) ? $voucherType === $data->type : $voucherType ===
                          request()->type)
                          <option value="{{$voucherType}}" @selected($selected)>{{$voucherType}}</option>
                          @endforeach
                        </select>
                        <x-error key="type" />
                      </div>
                    </div>

                    <div class="col-md-6 col-lg-3 col-payment-method" @style(['display: none'=> !isset($data) ||
                      $data->type === 'Journal'])>
                      <div class="form-group">
                        <label class="form-label">Payment Method</label>
                        <select name="payment_method" id="payment-method" class="form-control select" required>
                          <option value="">Select Payment Method</option>
                          @foreach(PAYMENT_METHODS as $paymentMethod)
                          @php($selected = isset($data) ? $paymentMethod === $data->payment_method : $paymentMethod ===
                          request()->payment_method)
                          <option value="{{$paymentMethod}}" @selected($selected)>{{$paymentMethod}}</option>
                          @endforeach
                        </select>
                        <x-error key="payment_method" />
                      </div>
                    </div>

                    <div class="col-md-6 col-lg-3 col-cheque-number" @style(['display: none'=> !isset($data) ||
                      $data->payment_method !== 'Bank'])>
                      <div class="form-group">
                        <label class="form-label">Cheque Number <span class="text-danger">*</span></label>
                        <input type="text" name="cheque_number" placeholder="Enter Cheque Number"
                          value="{{ @$data->cheque_number }}" class="form-control" maxlength="15" required>
                        <x-error key="cheque_number" />
                      </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                      <div class="form-group">
                        <label class="form-label">Entry Date <span class="text-danger">*</span></label>
                        <input type="text" name="date" placeholder="Enter Entry Date"
                          value="{{ $data->date ?? getTodaySystemDate()}}" class="form-control system-datepicker"
                          required>
                        <x-error key="date" />
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="form-label">Narration <span class="text-danger">*</span></label>
                        <input type="text" name="description" placeholder="Enter Voucher description"
                          value="{{ @$data->description }}" class="form-control" required>
                        <x-error key="description" />
                      </div>
                    </div>
                  </div>

                  <div class="mb-2 text-right">
                    <button type="button" class="btn btn-info btn-sm" onclick="addNewRows()">+ Add New</button>
                  </div>

                  <div class="table-responsive">
                    <table id="voucher-entry-table" class="table table-borderd">
                      <thead>
                        <tr class="bg-light">
                          <th width="20%">Ledger Account</th>
                          <th>Opening Balance</th>
                          <th>Debit</th>
                          <th>Credit</th>
                          <th width="24%">Remarks</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @isset($data->generalLedgers)
                          @foreach($data->generalLedgers as $idx => $d)
                            @include('pages.account.voucher.partials._table-row', ['rowData' => $d, 'idx' => $idx])
                          @endforeach
                        @else
                          @include('pages.account.voucher.partials._table-row', ['idx' => 0])
                        @endisset
                      </tbody>
                      <tfoot>
                        <tr class="bg-light">
                          <th colspan="2" class="text-center align-middle">Total</th>
                          <th>
                            <input type="number" id="debit-amount-total" class="form-control bg-light font-weight-bold text-right"
                              name="total_debit_amount" placeholder="0.00" value="{{@$data->amount}}" readonly>
                          </th>
                          <th>
                            <input type=" number" id="credit-amount-total"
                              class="form-control bg-light font-weight-bold text-right" name="total_credit_amount"
                              placeholder="0.00" value="{{@$data->amount}}" readonly>
                          </th>
                          <th colspan=" 2">
                          </th>
                        </tr>
                      </tfoot>
                    </table>
                    <x-error key="ledger_account_id.*" />
                    <x-error key="total_debit_amount" />
                  </div>

                  <div class="text-right">
                    <button type="submit" class="btn btn-primary">{{isset($data) ? 'Update' : 'Save'}}</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="{{asset('js/voucher/voucher.js')}}"></script>
<script>
  $(function () {
    toggleRemoveButton();
  });
</script>
@endsection