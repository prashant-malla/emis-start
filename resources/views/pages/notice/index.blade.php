@extends('layouts.master')

@php
    if (auth('staff')->check()) {
        $userRole = auth()->guard('staff')->user()->role->role;
    
        $routeMapping = [
            'Receptionist' => 'receptionist.',
        ];
    
        $routeAs = $routeMapping[$userRole] ?? null;
    }
@endphp

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Notice</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Notice</a></li>
                    </ol>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Select Criteria</h4>
                </div>
                <div class="card-body">
                    @include('pages.notice.partials.filter', [
                        'filterAction' => '',
                    ])
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="row tab-content">
                        <div id="list-view" class="tab-pane fade active show col-lg-12">
                            @include('includes.message')
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Notice List</h4>
                                    @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                                        @if($userRole == 'Receptionist')
                                            <a href="{{ route('receptionist.notice.create') }}" class="btn btn-primary">Add Notice</a>
                                        @endif
                                    @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
                                        <a href="{{ route('admin_notice.create') }}" class="btn btn-primary">Add Notice</a>
                                    @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'superadmin')
                                        <a href="{{ route('notice.create') }}" class="btn btn-primary">Add Notice</a>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example3" class="display" style="min-width: 750px">
                                            <thead>
                                            <tr>
                                                <th class="d-none">SN</th>
                                                <th>Notice</th>
                                                <th>Notice Date</th>
                                                <th>Notice To</th>
                                                @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                                                    @if($userRole == 'Receptionist')
                                                        <th>Role</th>
                                                    @endif
                                                @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'admin' || \Illuminate\Support\Facades\Auth::user()->role == 'superadmin')
                                                    <th>Role</th>
                                                @endif

                                                @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                                                    @if($userRole == 'Receptionist')
                                                            <th>Level</th>
                                                            <th>Program</th>
                                                            <th>Year/Semester</th>
                                                            <th>Group</th>
                                                    @endif
                                                @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'admin' || \Illuminate\Support\Facades\Auth::user()->role == 'superadmin')
                                                    <th>Level</th>
                                                    <th>Program</th>
                                                    <th>Year/Semester</th>
                                                    <th>Group</th>
                                                @endif

                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($notices as $key =>$notice)
                                                <tr>
                                                    <td class="d-none">{{ $loop->iteration }}</td>
                                                    <td>{{ $notice->title ?? 'N/A'}}</td>
                                                    <td>{{ $notice->notice_date ?? 'N/A'}}</td>
                                                    <td>{{ $notice->notice_to ?? 'N/A'}}</td>
                                                    @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                                                        @if($userRole == 'Receptionist')
                                                            <td>
                                                                {{$notice->roles->pluck('role')->implode(',')}}
                                                            </td>
                                                        @endif
                                                    @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'admin' || \Illuminate\Support\Facades\Auth::user()->role == 'superadmin')
                                                        <td>
                                                            {{$notice->roles->pluck('role')->implode(',')}}
                                                        </td>
                                                    @endif
                                                    @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                                                        @if($userRole == 'Receptionist')
                                                            <td>
                                                                {{$notice->levels->pluck('name')->implode(',') ?? 'N/A'}}
                                                            </td>
                                                            <td>
                                                                {{$notice->programs->pluck('name')->implode(',') ?? 'N/A'}}
                                                            </td>
                                                            <td>
                                                                {{$notice->yearsemesters->pluck('name')->implode(',') ?? 'N/A'}}
                                                            </td>
                                                            <td>
                                                                {{$notice->sections->pluck('group_name')->implode(',') ?? 'N/A'}}
                                                            </td>
                                                        @endif
                                                    @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'admin' || \Illuminate\Support\Facades\Auth::user()->role == 'superadmin')
                                                        <td>
                                                            {{$notice->levels->pluck('name')->implode(',') ?? 'N/A'}}
                                                        </td>
                                                        <td>
                                                            {{$notice->programs->pluck('name')->implode(',') ?? 'N/A'}}
                                                        </td>
                                                        <td>
                                                            {{$notice->yearsemesters->pluck('name')->implode(',') ?? 'N/A'}}
                                                        </td>
                                                        <td>
                                                            {{$notice->sections->pluck('group_name')->implode(',') ?? 'N/A'}}
                                                        </td>
                                                    @endif
                                                    <td>
                                                        <div class="d-flex">
                                                            @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                                                                @if($userRole == 'Receptionist')
                                                                    <a href="{{route('receptionist.notice.show',$notice) }} " class='btn btn-sm btn-primary m-1'>
                                                                        <i class="la la-eye"></i></a>
                                                                    <a href="{{route('receptionist.notice.edit',$notice) }} " class='btn btn-sm btn-warning m-1'>
                                                                        <i class="la la-pencil"></i></a>
                                                                    <form method="POST" action=" {{route('receptionist.notice.destroy',$notice)}}" onsubmit="return confirm('Are you sure?')">
                                                                        @method('delete')
                                                                        @csrf
                                                                        <button type="submit" class="btn btn-sm btn-danger m-1"  data-toggle="modal" data-target="#deleteModal">
                                                                            <i class="la la-trash-o"></i>
                                                                        </button>
                                                                    </form>
                                                                @elseif(auth()->guard('staff')->user()->role->role == 'Teacher')
                                                                    <a href="{{route('teacher_notice.show',$notice) }} " class='btn btn-sm btn-primary m-1'>
                                                                        <i class="la la-eye"></i></a>
                                                                @elseif(auth()->guard('staff')->user()->role->role == 'Librarian')
                                                                    <a href="{{route('librarian_notice.show',$notice) }} " class='btn btn-sm btn-primary m-1'>
                                                                        <i class="la la-eye"></i></a>
                                                                @elseif(auth()->guard('staff')->user()->role->role == 'Accountant')
                                                                    <a href="{{route('accountant_notice.show',$notice) }} " class='btn btn-sm btn-primary m-1'>
                                                                        <i class="la la-eye"></i></a>
                                                                @elseif(auth()->guard('staff')->user()->role->role == 'Technical')
                                                                    <a href="{{route('technical_notice.show',$notice) }} " class='btn btn-sm btn-primary m-1'>
                                                                        <i class="la la-eye"></i></a>
                                                                @elseif(auth()->guard('staff')->user()->role->role == 'Non-Technical')
                                                                    <a href="{{route('nontechnical_notice.show',$notice) }} " class='btn btn-sm btn-primary m-1'>
                                                                        <i class="la la-eye"></i></a>
                                                                @elseif(auth()->guard('staff')->user()->role->role == 'Administrative')
                                                                    <a href="{{route('administrative_notice.show',$notice) }} " class='btn btn-sm btn-primary m-1'>
                                                                        <i class="la la-eye"></i></a>
                                                                @endif
                                                            @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
                                                                <a href="{{route('admin_notice.show',$notice) }} " class='btn btn-sm btn-primary m-1'>
                                                                    <i class="la la-show"></i></a>
                                                                <a href="{{route('admin_notice.edit',$notice) }} " class='btn btn-sm btn-warning m-1'>
                                                                    <i class="la la-pencil"></i></a>
                                                                <form method="POST" action=" {{route('admin_notice.destroy',$notice)}}" onsubmit="return confirm('Are you sure?')">
                                                                    @method('delete')
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-sm btn-danger m-1"  data-toggle="modal" data-target="#deleteModal">
                                                                        <i class="la la-trash-o"></i>
                                                                    </button>
                                                                </form>
                                                            @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'superadmin')
                                                                <a href="{{route('notice.show',$notice) }} " class='btn btn-sm btn-primary m-1'>
                                                                    <i class="la la-eye"></i></a>
                                                                <a href="{{route('notice.edit',$notice) }} " class='btn btn-sm btn-warning m-1'>
                                                                    <i class="la la-pencil"></i></a>
                                                                <form method="POST" action=" {{route('notice.destroy',$notice)}}" onsubmit="return confirm('Are you sure?')">
                                                                    @method('delete')
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-sm btn-danger m-1"  data-toggle="modal" data-target="#deleteModal">
                                                                        <i class="la la-trash-o"></i>
                                                                    </button>
                                                                </form>
                                                            @endif
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
