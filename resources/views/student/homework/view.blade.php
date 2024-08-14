@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Assignment Detail</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Academics</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Assignment Detail</a></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
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
                                        <label class="form-label">{{($homework->submission_time)}}</label>
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
                            @include('includes.message')

                            @if(count($homework->homeworksubmission) > 0)                       
                            <h4 class="text-primary mb-4">Your Submission</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Submitted Date</th>
                                        <th>Submitted Time</th>
                                        <th>Files</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($homework->homeworksubmission as $submission)
                                        <tr>
                                            <td>{{($submission->created_at->format('Y-m-d'))}} [{{($submission->created_at->format('l'))}}]</td>
                                            <td>{{($submission->created_at->format('h:i A'))}}</td>
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
                                            <td>
                                                <form action="{{route('student.homework-submission.destroy', $homework->id)}}" method="POST" onsubmit="return confirmDelete()">                                              
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class='btn btn-sm btn-primary m-1'><i class="la la-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <h4 class="text-primary mb-4">Upload Submission</h4>
                            <form action="{{route('student.homework-submission.upload', $homework->id)}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Attach Document <span style="color: red">&#42;</span></label>                                            
                                            <input class="form-control" type="file" name="file[]" multiple>
                                            <span class="text-danger">@error('file'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mt-lg-4 pt-1">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- <div class="row">
                <div class="col-xl-12 col-xxl-12 col-sm-12">
                    <hr />
                    <h4>Display Submitted Homework</h4>
                    @foreach($homework->homeworksubmission as $data)
                        <div class="card" style="height: auto">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm- mt-2 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary dropdown" data-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></button>
                                        <div class="dropdown-menu" style="padding-left: 50px;">
                                            <button type="submit" class="btn btn-sm btn-primary m-1"  data-toggle="modal" data-target="#deleteModal">
                                                <a href="
                                                    @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                                                        @if(auth()->guard('staff')->user()->role->name == 'Admin')
                                                            {{route('admin.homework-submission',$data['id']) }}
                                                        @endif
                                                    @elseif(\Illuminate\Support\Facades\Auth::guard('student')->check())
                                                        {{route('student.homework-submission',$data['id']) }}
                                                    @elseif(\Illuminate\Support\Facades\Auth::user()->user_type == 'superadmin')
                                                        {{route('homework-submission',$data['id']) }}
                                                    @endif
                                                    ">
                                                    <i class="la la-pencil"></i>
                                                    <span>Edit</span>
                                                </a>
                                            </button>
                                                <form method="post" action="
                                                    @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                                                        @if(auth()->guard('staff')->user()->role->name == 'Admin')
                                                            {{route('admin.homework-submission.destroy',$data->id)}}
                                                        @endif
                                                    @elseif(\Illuminate\Support\Facades\Auth::guard('student')->check())
                                                        {{route('student.homework-submission.destroy',$data->id)}}
                                                    @elseif(\Illuminate\Support\Facades\Auth::user()->user_type == 'superadmin')
                                                        {{route('homework-submission.destroy',$data->id)}}
                                                    @endif
                                                    ">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-danger m-1"  data-toggle="modal" data-target="#deleteModal">
                                                        <i class="la la-trash-o"></i>
                                                        <span>Delete</span>
                                                    </button>
                                                </form>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Submitted Date: </label>
                                            <label class="form-label">{{($data->created_at->format('Y M d'))}} [{{($data->created_at->format('l'))}}]</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Submitted Time: </label>
                                            <label class="form-label">{{($data->created_at->format('H:i:s'))}}</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Submitted by: </label>
                                            <label class="form-label">{{ucfirst($data->user->name)}}</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Submitted Document: <span><img style="height: 75px; width: 100px;" alt="img" src="{{url('/public/images/homeworkSubmission/'.$data->file,) }}" /></span></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <hr />
                </div>
            </div> --}}
        </div>
    </div>
@endsection
