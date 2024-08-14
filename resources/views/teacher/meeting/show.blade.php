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

            <div class="row">
                <div class="col-xl-12 col-xxl-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">eClass View</h5>
                        </div>
                        <div class="card-body">
                            <form action="" method="POST" enctype="multipart/form-data" id="categoryform">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Level: {{$meeting->level->name ?? 'N/A'}}</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Program: {{$meeting->program->name ?? 'N/A'}}</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Program: {{$meeting->yearsemester->name ?? 'N/A'}}</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Group : {{$meeting->section->group_name ?? 'N/A'}}</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Teacher: {{$meeting->teacher->name ?? 'N/A'}}</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Meeting Date: {{$meeting->meeting_date ?? 'N/A'}}</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Meeting Time: {{$meeting->meeting_time ?? 'N/A'}}</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">File Attached:
                                                @if(json_decode(($meeting->document))>0)
                                                @foreach(json_decode($meeting->document, true) as $key => $media_gallery)
                                                    <a href="{{ url('/upload/files/meeting/'.$media_gallery) }}" target="_blank" data-toggle="lightbox" data-title="Package Media Gallery" data-gallery="gallery">
                                                        <i class="fa fa-file"></i>
                                                    </a>
                                                @endforeach
                                                @endif
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Note : {!! $meeting->note ?? 'N/A'!!}</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Link : <a href="{{$meeting->link }}" target="_blank">
                                                <div class="media d-flex align-items-center">
                                                    <div class="media-body">
                                                        <p class="mb-0 fs--1">{!! $meeting->link !!}</p>
                                                    </div>
                                                </div>
                                            </a>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


