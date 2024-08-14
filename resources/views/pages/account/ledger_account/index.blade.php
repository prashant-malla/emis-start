@extends('layouts.master')
@section('content')
<div class="content-body">
  <div class="container-fluid">
    <div class="row page-titles mx-0">
      <div class="col-sm-6 p-md-0">
        <div class="welcome-text">
          <h4>Ledger Accounts</h4>
        </div>
      </div>
      <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
        <ol class="breadcrumb">
          <li class="breadcrumb-item active"><a href="javascript:void(0);">Account</a></li>
          <li class="breadcrumb-item active"><a href="javascript:void(0);">Ledger Accounts</a></li>
        </ol>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="row tab-content">
          <div id="list-view" class="tab-pane fade active show col-lg-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Ledger Accounts</h4>
                <div class="card-tools">
                  <a href="{{ route('ledger_account.create') }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-plus"></i>&nbsp;Add Account</a>
                </div>
              </div>
              <div class="card-body">
                @include('includes.message')
                <div class="table-responsive">
                  <table id="example3" class="display" style="min-width: 750px">
                    <thead>
                      <tr>
                        <th>S.N</th>
                        <th>Account Name</th>
                        <th>Account Group</th>
                        <th>Opening Balance(Rs.)</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($rows as $key =>$item)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->account_name }}</td>
                        <td>{{ $item->accountCategory->name }}</td>
                        <td>{{ $item->balance }}</td>
                        <td>
                          <x-actions.edit :route="route('ledger_account.edit', $item)" />
                          <x-actions.delete :route="route('ledger_account.destroy', $item)" />
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