@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Alumni</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Alumni</a></li>
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
                                    <h4 class="card-title">Alumni List</h4>
                                    <div class="d-flex">
                                        <a href="{{route('alumni.create')}}" class="btn btn-primary">+ Add new</a>
                                        <div>
                                            <a class="btn btn-success" href="{{ route('alumni.export') }}">Export data</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example3" class="display" style="min-width: 845px">
                                            <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($alumnis as $key => $alumni)
                                                <tr>
                                                    <td>{{$alumni->name}}</td>
                                                    <td>{{$alumni->email}}</td>
                                            {{--        <td>
                                                        <div class="d-flex">
                                                            <a href="
                                                            @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                                                            @if(auth()->guard('staff')->user()->role == 'admin')
                                                            {{route('admin.level.edit', $level)}}
                                                            @endif
                                                            @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'superadmin')
                                                            {{route('level.edit', $level)}}
                                                            @endif
                                                                " class="btn btn-sm btn-primary m-1"><i
                                                                    class="la la-pencil"></i></a>
                                                            <form action="
                                                            @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                                                            @if(auth()->guard('staff')->user()->role->name == 'Admin')
                                                            {{route('admin.level.destroy',$level)}}
                                                            @endif
                                                            @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'superadmin')
                                                            {{route('level.destroy',$level)}}
                                                            @endif
                                                                "
                                                                  method="post"
                                                                  onsubmit="return confirm('Are you sure?')">
                                                                @method('delete')
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-danger m-1"
                                                                        data-toggle="modal" data-target="#deleteModal">
                                                                    <i class="la la-trash-o"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>--}}
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
