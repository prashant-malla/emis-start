@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Program</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Academics</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Program</a></li>
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
                                    <h4 class="card-title">Program List</h4>
                                    <a href="{{route('program.create')}}" class="btn btn-primary">+ Add new</a>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example3" class="display" style="min-width: 845px">
                                            <thead>
                                            <tr>
                                                <th>Level</th>
                                                <th>Program</th>
                                                <th>Program Type</th>
                                                <th>Admission Fee</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($programs as $program)
                                                <tr>
                                                    <td>{{$program->level->name ?? 'N/A'}}</td>
                                                    <td>
                                                        {{$program->name ?? 'N/A'}}
                                                        @if($program->faculty)
                                                            <div class="text-muted small font-italic">({{$program->faculty->name}})</div>
                                                        @endif
                                                    </td>
                                                    <td>{{ucfirst($program->type ) ?? 'N/A'}}</td>
                                                    <td>Rs. {{$program->admission_fee ?? 'N/A'}}</td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <a href="
                                                            @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                                                            @if(auth()->guard('staff')->user()->role == 'admin')
                                                            {{route('admin.program.edit', $program)}}
                                                            @endif
                                                            @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'superadmin')
                                                            {{route('program.edit', $program)}}
                                                            @endif
                                                                " class="btn btn-sm btn-primary m-1"><i
                                                                    class="la la-pencil"></i></a>
                                                            <form action="
                                                            @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                                                            @if(auth()->guard('staff')->user()->role->name == 'Admin')
                                                            {{route('admin.program.destroy',$program)}}
                                                            @endif
                                                            @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'superadmin')
                                                            {{route('program.destroy',$program)}}
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
