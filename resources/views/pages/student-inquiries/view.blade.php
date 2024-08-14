@extends('layouts.master')

@section('styles')
    <style>
        .member-image img {
            height: 100px;
            width: 100px;
            border-radius: 50%;
        }

        .member-card {
            padding-left: 20px;
            padding-right: 20px;
            padding-top: 30px;
            padding-bottom: 30px;
            background-color: #fff;
            box-shadow: 0 2px 12px #dedede;
        }

        .member-name {
            text-align: center;
            padding: 5px 5px;
        }

        hr {
            color: #dedede;
        }

        .detail-header h5 {
            background-color: #E7F1FF;
            padding: 30px 20px;
        }
    </style>
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
                        <h4>New Student Details</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a
                                href="{{ isset($routeAs) ? route($routeAs . 'dashboard') : '#' }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">
                            <a href="javascript:void(0);">New Students</a>
                        </li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Student Detail View</a></li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="member-card">
                        <div class="member-name">
                            <div class="member-image">
                                <img src="{{ $student->profile_image ?? 'N/A' }}" alt="">
                            </div>
                            <strong>
                                <h5>{{ $student->name ?? 'N/A' }}</h5>
                            </strong>
                        </div>
                        <div>
                            <table class="table mx-auto w-100">
                                <tr>
                                    <th>Level</th>
                                    <td>{{ $student->level->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Program</th>
                                    <td>{{ $student->program->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Gender</th>
                                    <td>{{ $student->gender }}</td>
                                </tr>
                                <tr>
                                    <th>Blood Group</th>
                                    <td>{{ $student->bloodgroup ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Phone Number</th>
                                    <td>{{ $student->phone ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Date of Birth</th>
                                    <td>{{ $student->dob ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Ethnicity</th>
                                    <td>{{ $student->ethnicity ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Caste</th>
                                    <td>{{ $student->caste ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Religion</th>
                                    <td>{{ $student->religion ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="member-card">
                        <div class="detail-header">
                            <h5><strong>Student Details</strong></h5>
                        </div>
                        <hr>
                        <div>
                            <table class="table table-striped mx-auto w-100">
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $student->email ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Permanent Address</th>
                                    <td>{{ $student->paddress ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Current Address</th>
                                    <td>{{ $student->caddress ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                        <hr>
                        <div class="detail-header">
                            <h5><strong>Parents/Guardian Details</strong></h5>
                        </div>
                        <hr>
                        <div>
                            <table class="table table-striped mx-auto w-100">
                                <tr>
                                    <th>Father's Name</th>
                                    <td>{{ $student->father_name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Father's Job</th>
                                    <td>{{ $student->father_job ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Father's Contact</th>
                                    <td>{{ $student->father_contact ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Mother's Name</th>
                                    <td>{{ $student->mother_name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Mother's Job</th>
                                    <td>{{ $student->mother_job ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Mother's Contact</th>
                                    <td>{{ $student->mother_contact ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                        <hr>
                        <div class="detail-header">
                            <h5><strong>Documents</strong></h5>
                            <table class="table table mx-auto w-100">
                                <tr>
                                    <th>School Leaving Certifcate</th>
                                    <td>
                                        {{ $student->getMedia('slc_certificate')[0]->file_name ?? 'N/A' }}
                                        @if (!empty($student->slc_certificate))
                                            <a href="{{ $student->slc_certificate }}" target="_blank">
                                                <img src="https://cdn-icons-png.flaticon.com/512/892/892303.png"
                                                    alt="" style="height: 35px; width: 35px">
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Transcipt</th>
                                    <td>
                                        {{ $student->getMedia('high_school_certificate')[0]->file_name ?? 'N/A' }}
                                        @if (!empty($student->high_school_certificate))
                                            <a href="{{ $student->high_school_certificate }}" target="_blank">
                                                <img src="https://cdn-icons-png.flaticon.com/512/892/892303.png"
                                                    alt="" style="height: 35px; width: 35px">
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Other Document</th>
                                    <td>
                                        {{ $student->getMedia('other_certificate')[0]->file_name ?? 'N/A' }}
                                        @if (!empty($student->other_certificate))
                                            <a href="{{ $student->other_certificate }}" target="_blank">
                                                <img src="https://cdn-icons-png.flaticon.com/512/892/892303.png"
                                                    alt="" style="height: 35px; width: 35px">
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
