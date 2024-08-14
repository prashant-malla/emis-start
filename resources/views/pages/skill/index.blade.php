@extends('layouts.master')

@php
    if (auth('staff')->check()) {
        $userRole = auth()->guard('staff')->user()->role->role;
    }

    $routeMapping = [
        'Teacher' => 'teacher_.',
        'Receptionist' => 'receptionist.',
    ];

    $routeAs = $routeMapping[$userRole ?? ''] ?? null;
@endphp

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Skill Gap Feedback</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Skill Gap Feedback</a></li>
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
                                    <h4 class="card-title">Skill Gap Feedback List</h4>

                                    <div>
                                        @if($isSuperAdmin)
                                        <a
                                            class="btn btn-primary"
                                            href="{{ route('skill.export.excel') }}"
                                            target="_blank"
                                        >
                                            Export Excel
                                        </a>

                                        <a
                                            class="btn btn-secondary"
                                            href="{{ route('skill.export.pdf') }}"
                                            target="_blank"
                                        >
                                            Export PDF
                                        </a>
                                        @endif

                                        @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                                            @if($userRole == 'Teacher' || $userRole == 'Receptionist')
                                                <a href="{{ isset($routeAs) ? route($routeAs . 'skill.create') : '#' }}" class="btn btn-primary">+ Add new</a>
                                            @endif
                                        @elseif(\Illuminate\Support\Facades\Auth::guard('student')->check())
                                            <a href="{{route('student.skill.create')}}" class="btn btn-primary">+ Add new</a>
                                        @elseif(\Illuminate\Support\Facades\Auth::user()->role == "superadmin")
                                            <a href="{{route('skill.create')}}" class="btn btn-primary">+ Add new</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example3" class="display" style="min-width: 845px">
                                            <thead>
                                            <tr>
                                                <th>administration and education/label</th>
                                                <th>academic staff</th>
                                                <th>employees</th>
                                                <th>advice</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($skills as $skill)
                                                <tr>

                                                    <td>{{$skill->organize}}</td>
                                                    <td>{!! $skill->staff!!}</td>
                                                    <td>{!!$skill->employees!!}</td>
                                                    <td>{!! $skill->objective !!}</td>
                                                    <td>
                                                        <div class="d-flex">
                                                            @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                                                                @if($userRole == 'Teacher' || $userRole == 'Receptionist')
                                                                    <a href="{{ isset($routeAs) ? route($routeAs . 'skill.edit',$skill['id']) : '#' }}" class="btn btn-sm btn-primary m-1"><i class="la la-pencil"></i></a>
                                                                @endif
                                                            @elseif(\Illuminate\Support\Facades\Auth::guard('student')->check())
                                                                <a href="{{route('student.skill.edit',$skill['id']) }}" class="btn btn-sm btn-primary m-1"><i class="la la-pencil"></i></a>
                                                            @elseif(\Illuminate\Support\Facades\Auth::user()->role == "superadmin")
                                                                <a href="{{route('skill.edit',$skill['id']) }}" class="btn btn-sm btn-primary m-1"><i class="la la-pencil"></i></a>
                                                            @endif
                                                            <form method="post" action="
                                                            @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                                                                @if($userRole == 'Teacher' || $userRole == 'Receptionist')
                                                                    {{ isset($routeAs) ? route($routeAs . 'skill.destroy' ,$skill->id) : '#' }}
                                                                @endif
                                                            @elseif(\Illuminate\Support\Facades\Auth::guard('student')->check())
                                                                {{route('student.skill.destroy',$skill->id)}}
                                                            @elseif(\Illuminate\Support\Facades\Auth::user()->role == "superadmin")
                                                                {{ route('skill.destroy',$skill->id) }}
                                                            @endif
                                                            "
                                                            onsubmit="return confirmDelete()"
                                                            >
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



