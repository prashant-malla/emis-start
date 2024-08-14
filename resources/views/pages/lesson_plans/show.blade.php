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
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Lesson/Unit Plan View</a></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="member-card">
                        <div class="member-name pl-3">
                            <h4><strong>Topic: {{$lessonPlan->topic}}</strong></h4>
                        </div>
                        <div>
                            <table class="table mx-auto w-100">
                                <tr>
                                    <th>Department</th>
                                    <td>{{$lessonPlan->department ?? 'N/A'}}</td>
                                </tr>
                                <tr>
                                    <th>Subject</th>
                                    <td>{{$lessonPlan->subject->name ?? 'N/A'}}</td>
                                </tr>
                                <tr>
                                    <th>Lesson/Unit</th>
                                    <td>{{$lessonPlan->unit ?? 'N/A'}}</td>
                                </tr>
                                <tr>
                                    <th>Level</th>
                                    <td>{{$lessonPlan->level->name ?? 'N/A'}}</td>
                                </tr>
                                <tr>
                                    <th>Programme</th>
                                    <td>{{$lessonPlan->program->name ?? 'N/A'}}</td>
                                </tr>
                                <tr>
                                    <th>Year/Semester</th>
                                    <td>{{$lessonPlan->yearsemester->name ?? 'N/A'}}</td>
                                </tr>
                                {{-- <tr>
                                    <th>Section</th>
                                    <td>{{$lessonPlan->section->group_name ?? 'N/A'}}</td>
                                </tr> --}}
                                <tr>
                                    <th>Day of completion</th>
                                    <td>{{$lessonPlan->completion_days ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Learning Methods</th>
                                    <td>
                                        @php
                                        $learningMethod = json_decode($lessonPlan->learning_method);
                                        // required to handle old array data type
                                        $selectedLearningMethods = gettype($learningMethod) === 'array' ? $learningMethod : $learningMethod->methods;
                                        @endphp
                                        @foreach ($selectedLearningMethods as $method)
                                            <li>{{ ucfirst($method) }}</li>
                                        @endforeach
                                        @if (isset($learningMethod->other_method))
                                            <li>Other: {{ $learningMethod->other_method }}</li>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="member-card">
                        <div class="detail-header">
                            <h5><strong>Learning Objectives</strong></h5>
                        </div>
                        <hr>
                        <div>
                            <table class="table table-striped mx-auto w-100">
                                <tr>
                                    <td>{!!$lessonPlan->learning_objective!!}</td>
                                </tr>
                            </table>
                        </div>
                        <hr>
                        <div class="detail-header">
                            <h5><strong>Learning Tools/ Resources</strong></h5>
                            <table class="table table mx-auto w-100">
                                <tr>
                                    <td>{!!$lessonPlan->learning_tool!!}</td>
                                </tr>
                            </table>
                        </div>
                        <hr>                        
                        <div class="detail-header">
                            <h5><strong>Assignments</strong></h5>
                            <div>
                                @include('includes.ui.downloads', ['files' => $lessonPlan->files])
                            </div>
                        </div>
                        <hr>
                        <div class="detail-header">
                            <h5><strong>Evaluation Method</strong></h5>
                            <table class="table table-striped mx-auto w-100">
                                <tr>
                                    <td>{!! $lessonPlan->evaluation_method !!}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="detail-header">
                            <h5><strong>Learning Outcome</strong></h5>
                            <table class="table table-striped mx-auto w-100">
                                <tr>
                                    <td>{!!$lessonPlan->learning_outcome!!}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="float-right">
                            <h5><strong>Prepared By</strong></h5>
                                <div>
                                    <strong>Name:</strong>
                                    {{$lessonPlan->teacher->name}}
                                </div>
                            <div>
                                <strong>Date:</strong>
                                {{date('Y-F-d',strtotime($lessonPlan->created_at))}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


