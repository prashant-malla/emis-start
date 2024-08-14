@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Purpose</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Front Office</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Setup Front Office</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Purpose</a></li>
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
                                    <h4 class="card-title">Purpose List</h4>
                                    <a href="{{route('purpose.create')}}" class="btn btn-primary">+ Add new</a>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example3" class="display" style="min-width: 750px">
                                            <thead>
                                            <tr>
                                                <th>Purpose</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($purposes as $key =>$purpose)
                                                <tr>
                                                    <td>{{$purpose->purpose ?? 'N/A'}}</td>
                                                    <td>
                                                        <div class="d-flex">
                                                   {{--         <a href="
                                                                @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                                                                    @if(auth()->guard('staff')->user()->role->name == 'Admin')
                                                                        {{route('admin.purpose.edit',$item['id']) }}
                                                                    @elseif(auth()->guard('staff')->user()->role->name == 'Receptionist')
                                                                        {{route('receptionist.purpose.edit',$item['id']) }}
                                                                    @elseif(auth()->guard('staff')->user()->role->name == 'Accountant')
                                                                        {{route('accountant.purpose.edit',$item['id']) }}
                                                                    @endif
                                                                @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'Admin')
                                                                    {{route('purpose.edit',$item['id']) }}
                                                                @endif
                                                                "
                                                               class='btn btn-sm btn-primary m-1'><i class="la la-pencil"></i>
                                                            </a>--}}
                                                            <a href="{{route('purpose.edit', $purpose)}}" class='btn btn-sm btn-primary m-1'>
                                                                <i class="la la-pencil"></i></a>
                                                       {{--     <form method="POST"
                                                                  action="
                                                                       @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                                                                            @if(auth()->guard('staff')->user()->role->name == 'Admin')
                                                                                {{route('admin.purpose.destroy',$item->id)}}
                                                                            @elseif(auth()->guard('staff')->user()->role->name == 'Receptionist')
                                                                                {{route('receptionist.purpose.destroy',$item->id)}}
                                                                            @elseif(auth()->guard('staff')->user()->role->name == 'Accountant')
                                                                                {{route('accountant.purpose.destroy',$item->id)}}
                                                                            @endif
                                                                       @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'Admin')
                                                                            {{route('purpose.destroy',$item->id)}}
                                                                       @endif
                                                                       " onsubmit="return confirm('Are you sure?')">--}}
                                                            <form action="{{route('purpose.destroy',$purpose)}}" method="POST" onsubmit="return confirm('Are you sure?')">
                                                                @method('delete')
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-danger m-1"
                                                                        data-toggle="modal" data-target="#deleteModal">
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

