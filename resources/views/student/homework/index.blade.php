@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Assignment</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Assignment</a></li>
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
                                    <h4 class="card-title">Assignment List</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example3" class="display" style="min-width: 845px">
                                            <thead>
                                            <tr>                                               
                                                <th>Subject</th>
                                                <th>Assigned Date</th>
                                                <th>Submission Date</th>
                                                <th>Submission Time</th>
                                                <th>Assign By</th>
                                                <th>File</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($homework as $key =>$data)
                                                <tr>                                            
                                                    <td>{{$data->subject->name}}</td>
                                                    <td>{{$data->assign}}</td>
                                                    <td>{{$data->submission}}</td>
                                                    <td>{{ \Carbon\Carbon::parse($data->submission_time)->format('h:i A')}}</td>
                                                    <td>{{$data->teacher->name}}</td>
                                                    <td>
                                                        @include('includes.ui.downloads', ['files' => $data->files])
                                                    </td>
                                                    <td>
                                                        @if($data->homework_submission_count > 0)
                                                        <span class="badge badge-success">Submitted</span>
                                                        @else
                                                        <span class="badge badge-default">Not Submitted</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <a href="{{route('student.homework.show', $data->id) }}" class='btn btn-sm btn-primary m-1' data-toggle="tooltip" title="Homework Detail">
                                                                <i class="la la-eye"></i>
                                                            </a>
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
