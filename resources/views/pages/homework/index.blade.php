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

            {{-- <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Select Criteria</h4>
                </div>
                <div class="card-body">
                  
                </div>
            </div> --}}

            <div class="row">
                <div class="col-lg-12">
                    <div class="row tab-content">
                        <div id="list-view" class="tab-pane fade active show col-lg-12">
                            @include('includes.message')
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Assignment List</h4>
                                    <div>
                                        @if($isSuperAdmin)
                                            <a
                                                    class="btn btn-primary"
                                                    href="{{ route('homework.export.excel') }}"
                                                    target="_blank"
                                            >
                                                Export Excel
                                            </a>

                                            <a
                                                    class="btn btn-secondary"
                                                    href="{{ route('homework.export.pdf') }}"
                                                    target="_blank"
                                            >
                                                Export PDF
                                            </a>
                                        @endif
                                        <a href="{{route($routename_prefix.'homework.create')}}" class="btn btn-primary">+ Add new</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @include('pages.homework.partials.filter', [
                                        'filterAction' => ''
                                    ])
                                    <div class="table-responsive">
                                        <table id="example3" class="display" style="min-width: 845px">
                                            <thead>
                                            <tr>
                                                <th>Level</th>
                                                <th>Program</th>
                                                <th>Group</th>
                                                <th>Subject</th>
                                                <th>Assigned Date</th>
                                                <th>Submission Date</th>
                                                <th>Submission Time</th>
                                                <th>Assign By</th>
                                                <th>File</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($homework as $key =>$data)
                                                <tr>
                                                    <td>{{$data->level->name ?? 'N/A'}}</td>
                                                    <td>{{$data->program->name ?? 'N/A'}}</td>
                                                    <td>{{$data->section->group_name ?? 'N/A'}}</td>
                                                    <td>{{$data->subject->name}}</td>
                                                    <td>{{$data->assign}}</td>
                                                    <td>{{$data->submission}}</td>
                                                    <td>{{ \Carbon\Carbon::parse($data->submission_time)->format('h:i A')}}</td>
                                                    <td>{{$data->teacher->name}}</td>
                                                    <td>
                                                        @include('includes.ui.downloads', ['files' => $data->files])
                                                    </td>
                                                    <td>
                                                        @include('includes.ui.actions', [
                                                            'viewAction' => [
                                                                'url' => $data->homeworksubmission_count > 0 ? route($routename_prefix.'homework.view', $data->id) : '',
                                                                'title' => 'View Submission'
                                                            ],
                                                            'editAction' => [
                                                                'url' => route($routename_prefix.'homework.edit', $data->id),
                                                            ],
                                                            'deleteAction' => [
                                                                'url' => route($routename_prefix.'homework.destroy', $data->id),
                                                            ]
                                                        ])
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
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#homeworkform').validate();
        });
    </script>
    <script src="http://code.jquery.com/jquery-3.4.1.js"></script>

    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'description' );
    </script>
@endsection
