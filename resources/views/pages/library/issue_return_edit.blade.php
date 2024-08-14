@extends('layouts.master')
@section('styles')
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/css/bootstrap-switch-button.min.css" rel="stylesheet">
@endsection
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Issue Return</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Issue Return</a></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12 col-xxl-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Edit IssueReturn</h5>
                        </div>
                        <div class="card-body">
                            @include('includes.message')
                            <form action="{{route('issue_return.update', [$libraryMember, $issueReturn])}}" method="post">
                                @method('PATCH')
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="issue_date">Issue Date</label>
                                            <input type="date" class="form-control input-date system-datepicker" id="issue_date" name="issue_date"
                                                   value="{{$issueReturn->issue_date}}" style="position: relative;"/>
                                            <span class="text-danger">@error('issue_date'){{$message}}@enderror</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="duration">Duration</label>
                                            <input type="number" class="form-control" id="duration" name="duration"
                                                value="{{old('duration')?old('duration'):$issueReturn->duration}}" style="position: relative;"/>

                                        <span class="text-danger">
                                                @error('duration'){{$message}}@enderror
                                            </span>
                                        </div>
                                    </div>
                                    @isset($issueReturn->return_date)
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="return_date">Returned Date</label>
                                                <input type="date" class="form-control input-date system-datepicker" id="return_date" name="return_date"
                                                       value="{{$issueReturn->return_date}}" style="position: relative;"/>
                                                <span class="text-danger">@error('return_date'){{$message}}@enderror</span>
                                            </div>
                                        </div>
                                    @endisset
                                    @isset($issueReturn->status)
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="issue_date">Return Status</label>
                                                <input type="hidden" name="status" value="late">
                                                <input type="checkbox" name="status" value="on_time" id="statusCheckBox" data-toggle="switchbutton"
                                                       @if($issueReturn->status == "on_time")
                                                           checked
                                                       @endif
                                                       data-onlabel="On Time" data-offlabel="Late" data-onstyle="success" data-offstyle="danger" style="padding-right: 20px;">

                                                <span class="text-danger">@error('status'){{$message}}@enderror</span>
                                            </div>
                                        </div>
                                    @endisset
                                    <div class="col-lg-12 col-md-12 col-sm- mt-2 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Update</button>
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
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/dist/bootstrap-switch-button.min.js"></script>



