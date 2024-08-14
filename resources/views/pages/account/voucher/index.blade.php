@extends('layouts.master')
@section('content')
<div class="content-body">
  <div class="container-fluid">
    <div class="row page-titles mx-0">
      <div class="col-sm-6 p-md-0">
        <div class="welcome-text">
          <h4>Voucher</h4>
        </div>
      </div>
      <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
        <ol class="breadcrumb">
          <li class="breadcrumb-item active"><a href="javascript:void(0);">Account</a></li>
          <li class="breadcrumb-item active"><a href="javascript:void(0);">Voucher</a></li>
        </ol>
      </div>
    </div>

    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Filter Voucher</h4>
      </div>
      <div class="card-body">
        <form action="{{route('voucher.index')}}" method="GET">
          <div class="row">
            <div class="col-md-4 col-lg-3">
              <div class="form-group">
                <label class="form-label">Approval Status</label>
                <select name="approval_status" class="form-control select">
                  <option value="" @selected(@$filters['approval_status']=='' )>All</option>
                  @foreach(APPROVAL_STATUS as $statusId => $status)
                  <option value="{{$statusId}}" @selected(@$filters['approval_status']==$statusId )>{{$status}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-4 col-lg-3">
              <div class="form-group">
                <label class="form-label">From Date</label>
                <input type="text" class="form-control system-datepicker" name="from_date"
                  value="{{$filters['from_date']}}">
              </div>
            </div>
            <div class="col-md-4 col-lg-3">
              <div class="form-group">
                <label class="form-label">To Date</label>
                <input type="text" class="form-control system-datepicker" name="to_date"
                  value="{{$filters['to_date']}}">
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

    <div class="row">
      <div class="col-lg-12">
        <div class="row tab-content">
          <div id="list-view" class="tab-pane fade active show col-lg-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Voucher List</h4>
                <div class="card-tools">
                  <a href="{{ route('voucher.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus me-1"></i> Add Voucher</a>
                </div>
              </div>
              <div class="card-body">
                @include('includes.message')
                <div class="table-responsive">
                  <table id="example3" class="display" style="min-width: 750px">
                    <thead>
                      <tr>
                        <th>S.N</th>
                        <th>Voucher Number</th>
                        <th>Voucher Date</th>
                        <th>Amount(Rs.)</th>
                        <th>Voucher Type</th>
                        <th>Narration</th>
                        <th>Approval Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($rows as $key =>$item)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->voucher_number }}</td>
                        <td>{{ $item->date }}</td>
                        <td>{{ $item->amount }}</td>
                        <td>{{ $item->type }}</td>
                        <td>{{ $item->description }}</td>
                        <td>
                          <x-account.approval_status :statusId="$item->approval_status" />
                        </td>
                        <td>
                          @if($item->approval_status !== 2)
                          <x-actions.edit :route="route('voucher.edit', $item)" />
                          <x-actions.print :route="route('voucher.print', $item)" target="_blank" />
                          @endif

                          @if($item->approval_status === 3)
                          <x-actions.approve :route="route('voucher.approve', $item)" />
                          <x-actions.disapprove :route="route('voucher.disapprove', $item)" />
                          @endif

                          <x-actions.delete :route="route('voucher.destroy', $item)" />
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
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