@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>StakeHolder</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">StakeHolder</a></li>
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
                                    <h4 class="card-title">StakeHolder List</h4>

                                    <div>
                                        @if($isSuperAdmin)
                                        <a
                                            class="btn btn-primary"
                                            href="{{ route('stake.export.excel') }}"
                                            target="_blank"
                                        >
                                            Export Excel
                                        </a>

                                        <a
                                            class="btn btn-secondary"
                                            href="{{ route('stake.export.pdf') }}"
                                            target="_blank"
                                        >
                                            Export PDF
                                        </a>
                                        @endif

                                        <a href="{{route($routenamePrefix.'stake.create')}}" class="btn btn-primary">+ Add new</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example3" class="display" style="min-width: 845px">
                                            <thead>
                                            <tr>
                                                <th>Name</th>
                                                @if(auth()->guard('student')->check())
                                                    <th>Program</th>
                                                    <th>Year/Semester</th>
                                                    <th>Section</th>
                                                @endif
                                                <th>Association</th>
                                                <th>Areas of suggestion</th>
                                                <th>Feedback</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($stakes as $stake)
                                                <tr>
                                                    <td>
                                                        @if($stake->staff_id != null)
                                                            {{$stake->staff->name}}
                                                        @elseif($stake->user_id != null)
                                                            {{$stake->user->name}}
                                                        @elseif($stake->student_id != null)
                                                            {{$stake->student->sname}}
                                                        @endif
                                                    </td>
                                                    @if(auth()->guard('student')->check())
                                                        <td>{{$stake->student->program->name}}</td>
                                                        <td>{{$stake->student->yearsemester->name}}</td>
                                                        <td>{{$stake->student->section->group_name}}</td>
                                                    @endif
                                                    <td>{{$stake->status ?? 'N/A'}}</td>
                                                    <td>{{implode(', ', $stake->area)}}</td>
                                                    <td>{{$stake->objective ?? 'N/A'}}</td>
                                                    <td>
                                                        <div class="d-flex">
                                                            @if(!$isSuperAdmin || $isSuperAdmin && $authProfile->id == $stake->user_id)
                                                            <a href="{{route($routenamePrefix.'stake.edit', $stake->id)}}" class="btn btn-sm btn-primary m-1"><i class="la la-pencil"></i></a>
                                                            <form method="post" action="{{route($routenamePrefix.'stake.destroy', $stake->id)}}" onsubmit="return confirmDelete()">
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


