@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>eClass</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">eClass</a></li>
                    </ol>
                </div>
            </div>
            <div class="card-body">
                @include('teacher/meeting/partials/filter', [
                    'filterAction' => '',
                ])
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="row tab-content">
                        <div id="list-view" class="tab-pane fade active show col-lg-12">
                            @include('includes.message')
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">eClass List</h4>
                                    <a href="{{route('teacher.meeting.create')}}" class="btn btn-primary">+ Add new</a>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example3" class="display" style="min-width: 845px">
                                            <thead>
                                            <tr>
                                                <th>Level</th>
                                                <th>Program</th>
                                                <th>Group</th>
                                                <th>Meeting Date</th>
                                                <th>Meeting Time</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($meeting as $key => $data)
                                                <tr>
                                                    <td>{{$data->level->name ?? 'N/A'}}</td>
                                                    <td>{{$data->program->name ?? 'N/A'}}</td>
                                                    <td>{{$data->section->group_name ?? 'N/A'}}</td>
                                                    <td>{{$data->meeting_date ?? 'N/A'}}</td>
                                                    <td>{{$data->meeting_time ?? 'N/A'}}</td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <a href="{{route('teacher.meeting.show',$data['id']) }} " class="btn btn-sm btn-warning m-1"><i class="la la-eye"></i></a>
                                                            <a href="{{route('teacher.meeting.edit',$data['id']) }} " class="btn btn-sm btn-primary m-1"><i class="la la-pencil"></i></a>
                                                            <form method="post" action="{{route('teacher.meeting.destroy',$data->id)}}" onsubmit="return confirm('Are you sure?')">
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

