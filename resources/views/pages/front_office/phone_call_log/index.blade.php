@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Phone Call Log</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Front Office</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Phone Call Log</a></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="row tab-content">
                        <div id="list-view" class="tab-pane fade active show col-lg-12">
                            @include('includes.message')
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Phone Call Log List</h4>
                                    <a href="{{route('phone-call-log.create')}}" class="btn btn-primary">+ Add new</a>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example3" class="display" style="min-width: 750px">
                                            <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Phone</th>
                                                <th>Date</th>
                                                <th>Next Follow Up Date</th>
                                                <th>Call Type</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($phoneCallLog as $key =>$item)
                                                <tr>
                                                    <td>{{ucfirst($item->name) ?? 'N/A'}}</td>
                                                    <td>{{$item->phone ?? 'N/A'}}</td>
                                                    <td>{{$item->date ?? 'N/A'}}</td>
                                                    <td>{{$item->follow_up_date ?? 'N/A'}}</td>
                                                    <td>{{ucfirst($item->call_type) ?? 'N/A'}}</td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <a href="
                                                                @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                                                                    @if(auth()->guard('staff')->user()->role->name == 'Admin')
                                                                        {{route('admin.phone-call-log.edit',$item['id']) }}
                                                                    @elseif(auth()->guard('staff')->user()->role->name == 'Receptionist')
                                                                        {{route('receptionist.phone-call-log.edit',$item['id']) }}
                                                                    @elseif(auth()->guard('staff')->user()->role->name == 'Accountant')
                                                                        {{route('accountant.phone-call-log.edit',$item['id']) }}
                                                                    @endif
                                                                 @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'superadmin')
                                                                    {{route('phone-call-log.edit',$item['id']) }}
                                                                @endif
                                                                " class='btn btn-sm btn-primary m-1'>
                                                                <i class="la la-pencil"></i></a>
                                                            <form method="POST" action="
                                                                @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                                                                @if(auth()->guard('staff')->user()->role->name == 'Admin')
                                                                    {{route('admin.phone-call-log.destroy',$item->id)}}
                                                                @elseif(auth()->guard('staff')->user()->role->name == 'Receptionist')
                                                                    {{route('receptionist.phone-call-log.destroy',$item->id)}}
                                                                @elseif(auth()->guard('staff')->user()->role->name == 'Accountant')
                                                                    {{route('accountant.phone-call-log.destroy',$item->id)}}
                                                                @endif
                                                                 @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'superadmin')
                                                                    {{route('phone-call-log.destroy',$item->id)}}
                                                                @endif
                                                                "
                                                                  onsubmit="return confirm('Are you sure?')">
                                                                @method('delete')
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-danger m-1"  data-toggle="modal" data-target="#deleteModal">
                                                                    <i class="la la-trash-o"></i>
                                                                </button>
                                                            </form>
                                                        </div>
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
