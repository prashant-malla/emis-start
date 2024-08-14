@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Assignment Submissions</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('student.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Assignment</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Assignment Submissions</a></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="text-primary mb-4">Assignment Detail</h4>
                            <div class="row">
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label class="form-label fw-bold">Level : </label>
                                        <label class="form-label">{{($homework->level->name)}}</label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label class="form-label fw-bold">Program : </label>
                                        <label class="form-label">{{($homework->program->name)}}</label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label class="form-label fw-bold">Year/Semester : </label>
                                        <label class="form-label">{{($homework->yearsemester->name)}}</label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label class="form-label fw-bold">Subject : </label>
                                        <label class="form-label">{{($homework->subject->name)}} ({{($homework->subject->code)}})</label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label class="form-label fw-bold">Assigned Date : </label>
                                        <label class="form-label">{{($homework->assign)}}</label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label class="form-label fw-bold">Submission Date : </label>

                                        <label class="form-label">{{($homework->submission)}}</label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label class="form-label fw-bold">Submission Time : </label>

                                        <label class="form-label">{{ date('g:i A', strtotime($homework->submission_time)) }}</label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label class="form-label fw-bold">Teacher : </label>
                                        <label class="form-label">{{($homework->teacher->name)}}</label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label class="form-label fw-bold">Files : </label>
                                        <label class="form-label">
                                            @include('includes.ui.downloads', ['files' => $homework->files])
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label fw-bold">Description</label>
                                        <br>
                                        <label class="form-label">{!! $homework->description !!}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="text-primary mb-4">Submission List</h4>
                            <div class="table-responsive">
                                <table id="example3" class="display">
                                    <thead>
                                    <tr>
                                        <th>Submitted By</th>
                                        <th>Submitted Date</th>
                                        <th>Submitted Time</th>
                                        <th>Files</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($homework->homeworksubmission as $submission)
                                        <tr>
                                            <td>{{(ucfirst($submission->student->sname))}}</td>
                                            <td>{{($submission->created_at->format('Y-m-d'))}} [{{($submission->created_at->format('l'))}}]</td>
                                            <td>{{($submission->created_at->format('H:i A'))}}</td>
                                            <td>
                                                @include('includes.ui.downloads', ['files' => $submission->files])
                                            </td>
                                            <td>
                                                @if($submission->isLate)
                                                <span class="badge badge-danger">Late</span>
                                                @else
                                                <span class="badge badge-success">On Time</span>
                                                @endif
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
@endsection
