@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
@endsection

@php
    $userRole = auth()->guard('staff')->user()->role->role;

    $routeMapping = [
        'Accountant' => 'accountant.',
        'Receptionist' => 'receptionist.',
    ];

    $routeAs = $routeMapping[$userRole] ?? null;
@endphp

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>New Students</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="{{ route('receptionist.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">
                            <a href="{{ isset($routeAs) ? route($routeAs . 'student-inquiries.index') : '#' }}">New Students</a>
                        </li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Edit</a></li>
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
                            <form action="{{ route('receptionist.student-inquiries.update', $student) }}" method="POST" id="studentform" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                               @include('pages.student-inquiries.includes.form')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>
    <script>
        $('.dropify').dropify();
    </script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#studentform').validate();
        });
    </script>
    <script src="http://code.jquery.com/jquery-3.4.1.js"></script>
    <script>
        $(document).ready(function () {
            $('#level_id').on('change', function () {
                let id = $(this).val();
                $('#program_id').empty();
                $('#program_id').append(`<option value="0" disabled selected>Processing...</option>`);
                $.ajax({
                    type: 'GET',
                    url: '/getPrograms/' + id,
                    success: function (response) {
                        var response = JSON.parse(response);

                        $('#program_id').empty();
                        $('#program_id').append(`<option value="0" disabled selected>Select Program</option>`);
                        response.forEach(element => {
                            $('#program_id').append(`<option value="${element['id']}">${element['name']}</option>`);
                        });
                    }
                });
            });
        });
    </script>
    
    <script>
        $('#program_id').on('change', function () {
            let id = $(this).val();
            $('#year_semester_id').empty();
            $('#year_semester_id').append(`<option value="0" disabled selected>Processing...</option>`);
            $.ajax({
                type: 'GET',
                url: '/year-semester/' + id,
                success: function (response) {
                    var response = JSON.parse(response);

                    $('#year_semester_id').empty();
                    $('#year_semester_id').append(`<option value="0" disabled selected>Select Year/Semester</option>`);
                    response.forEach(element => {
                        $('#year_semester_id').append(`<option value="${element['id']}">${element['name']}</option>`);
                    });
                }
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            $('#year_semester_id').on('change', function () {
                let id = $(this).val();
                $('#section_id').empty();
                $('#section_id').append(`<option value="0" disabled selected>Processing...</option>`);
                $.ajax({
                    type: 'GET',
                    url: '/getSections/' + id,
                    success: function (response) {
                        var response = JSON.parse(response);

                        $('#section_id').empty();
                        $('#section_id').append(`<option value="0" disabled selected>Select Section</option>`);
                        response.forEach(element => {
                            $('#section_id').append(`<option value="${element['id']}">${element['group_name']}</option>`);
                        });
                    }
                });
            });
        });
    </script>

@endsection
