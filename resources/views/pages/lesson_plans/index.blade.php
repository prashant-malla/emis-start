@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Lesson/Unit Plan</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Lesson/Unit Plan</a></li>
                    </ol>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Select Criteria</h4>
                </div>
                <div class="card-body">
                    @include('pages.teacher_assign.partials.filter', [
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
                                    <h4 class="card-title">Lesson/Unit Plan List</h4>

                                    <div>
                                        @if($isSuperAdmin)
                                            <a
                                                class="btn btn-primary"
                                                href="{{ route('lesson-plan.export.excel') }}"
                                                target="_blank"
                                            >
                                                Export Excel
                                            </a>

                                            <a
                                                class="btn btn-secondary"
                                                href="{{ route('lesson-plan.export.pdf') }}"
                                                target="_blank"
                                            >
                                                Export PDF
                                            </a>
                                        @endif
                                            
                                        @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                                            @if(auth()->guard('staff')->user()->role->role == 'Teacher')
                                                <a href="{{route('teacher_lesson-plan.create')}}" class="btn btn-primary">+ Add new</a>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example3" class="display" style="min-width: 845px">
                                            <thead>
                                            <tr>
                                                <th>Teacher's Name</th>
                                                <th>Subject Name</th>
                                                <th>Lesson/Unit</th>
                                                <th>Department</th>
                                                <th>Level</th>
                                                <th>Programme</th>
                                                <th>Year/Semester</th>
                                                {{-- <th>Section</th> --}}
                                                <th>Completion Days</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($lessonPlans as $key =>$lessonPlan)
                                                <tr>
                                                    <td>{{$lessonPlan->teacher->name ?? 'N/A'}}</td>
                                                    <td>{{$lessonPlan->subject->name ?? 'N/A'}}</td>
                                                    <td>{{$lessonPlan->unit ?? 'N/A'}}</td>
                                                    <td>{{$lessonPlan->department ?? 'N/A'}}</td>
                                                    <td>{{$lessonPlan->level->name ?? 'N/A'}}</td>
                                                    <td>{{$lessonPlan->program->name ?? 'N/A'}}</td>
                                                    <td>{{$lessonPlan->yearsemester->name ?? 'N/A'}}</td>
                                                    {{-- <td>{{$lessonPlan->section->group_name ?? 'N/A'}}</td> --}}
                                                    <td>{{$lessonPlan->completion_days ?? 'N/A'}}</td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <a href="
                                                            @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                                                            @if(auth()->guard('staff')->user()->role->role == 'Teacher')
                                                            {{route('teacher_lesson-plan.show', $lessonPlan['id'])}}
                                                            @endif
                                                            @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
                                                            {{ route('admin_lesson-plan.show', $lessonPlan['id']) }}
                                                            @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'superadmin')
                                                            {{route('lesson-plan.show', $lessonPlan['id'])}}
                                                            @endif
                                                                " class="btn btn-sm btn-warning m-1"><i
                                                                    class="la la-eye"></i></a>
                                                            @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                                                                @if(auth()->guard('staff')->user()->role->role == 'Teacher')
                                                            <a href="{{route('teacher_lesson-plan.edit', $lessonPlan['id'])}}" class="btn btn-sm btn-primary m-1"><i
                                                                    class="la la-pencil"></i></a>
                                                                @endif
                                                            @endif
                                                            @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                                                                @if(auth()->guard('staff')->user()->role->role == 'Teacher')
                                                                <form method="post"
                                                                      action="{{route('teacher_lesson-plan.destroy', $lessonPlan['id'])}}

                                                                          "onsubmit="return confirm('Are you sure?')">
                                                                    @method('delete')
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-sm btn-danger m-1"
                                                                            data-toggle="modal" data-target="#deleteModal">
                                                                        <i class="la la-trash-o"></i>
                                                                    </button>
                                                                </form>
                                                                @endif
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



