@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
    <style>
        .info-group {
            border-bottom: 1px solid #f7f7f7;
            margin-bottom: 30px;
        }

        .info-group-heading>span {
            display: inline-flex;
            height: 24px;
            align-items: center;
            background-color: #6673fd;
            color: #fff;
            padding: 0 5px;
            border-radius: 0 12px 12px 0;
        }

        .form-control[disabled],
        .select2-container--disabled {
            background-color: #eee
        }
    </style>
@endsection

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Student</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Academics</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Student</a></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12 col-xxl-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Edit Student</h5>
                        </div>
                        <div class="card-body">

                            @include('includes.message')

                            <form class="validate"
                                action="{{ isset($student) ? route('student.update', $student) : route('student.store') }}"
                                method="POST" id="studentform" enctype="multipart/form-data">

                                @csrf

                                <div class="info-group">
                                    <h4 class="h6 info-group-heading">
                                        <span>Basic Information</span>
                                    </h4>
                                    @include('pages.academics.student.partials.basic-fields')
                                </div>

                                <div class="info-group">
                                    <h4 class="h6 info-group-heading">
                                        <span>Academic Information</span>
                                    </h4>
                                    @if (isset($student) && $promoted)
                                        <p class="text-muted small mb-0">Note: Some academic informations of student
                                            already
                                            promoted are restricted to edit.</p>
                                    @endif
                                    @include('pages.academics.student.partials.academic-fields')
                                </div>

                                <div class="info-group">
                                    <h4 class="h6 info-group-heading">
                                        <span>Address Information</span>
                                    </h4>
                                    @include('pages.academics.student.partials.address-fields')
                                </div>

                                <div class="info-group">
                                    <h4 class="h6 info-group-heading">
                                        <span>Parent Information</span>
                                    </h4>
                                    @include('pages.academics.student.partials.parent-fields')
                                </div>

                                <div class="info-group">
                                    <h4 class="h6 info-group-heading">
                                        <span>Documents</span>
                                    </h4>
                                    @include('pages.academics.student.partials.documents')
                                </div>

                                <div class="bg-light border rounded p-3 mb-3">
                                    <div class="row">
                                        <div class="col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <label class="form-label">Profile Image</label>
                                                <input name="profile_image" type="file" class="dropify" data-height="130"
                                                    accept="image/*" data-default-file="{{ @$student->profile_image }}" />
                                                <span class="text-danger">
                                                    @error('profile_image')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>
                                        @if (isset($student))
                                            <div class="col">
                                                @include('pages.academics.student.partials.status-fields')
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/academics/student.js') }}"></script>
    <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>
    <script>
        $('.dropify').dropify();
    </script>
@endsection
