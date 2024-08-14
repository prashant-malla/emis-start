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
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Staff Detail View</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Human Resource</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Staff</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Staff Detail View</a></li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="member-card">
                        <div class="member-name">
                            <div class="member-image">
                                <img src="{{$staffDirectory->profile_image}}" alt="">
                            </div>
                            <strong><h5>{{$staffDirectory->name}}</h5></strong>
                        </div>
                        <div>
                            <table class="table mx-auto w-100">
                                <tr>
                                    <th>Staff ID</th>
                                    <td>{{$staffDirectory->staff_id}}</td>
                                </tr>
                                <tr>
                                    <th>Gender</th>
                                    <td>{{$staffDirectory->gender}}</td>
                                </tr>
                                <tr>
                                    <th>Ethnicity</th>
                                    <td>{{$staffDirectory->ethnicity}}</td>
                                </tr>
                                <tr>
                                    <th>Type of Service</th>
                                    <td>{{$staffDirectory->service_type}}</td>
                                </tr>
                                <tr>
                                    <th>Role</th>
                                    <td>{{$staffDirectory->role->role}}</td>
                                </tr>
                                <tr>
                                    <th>Department</th>
                                    <td>{{$staffDirectory->department->department}}</td>
                                </tr>
                                @if($staffDirectory->department->department != 'Faculty Member' && $staffDirectory->department->department != 'Teaching')
                                    <tr>
                                        <th>Sub Department</th>
                                        <td>{{$staffDirectory->sub_department->name ?? ''}}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <th>Designation</th>
                                    <td>{{$staffDirectory->designation->title}}</td>
                                </tr>
                                <tr>
                                    <th>Phone Number</th>
                                    <td>{{$staffDirectory->phone}}</td>
                                </tr>
                                <tr>
                                    <th>Date of Birth</th>
                                    <td>{{$staffDirectory->dob}}</td>
                                </tr>
                                @if($staffDirectory->department->department == 'Faculty Member' || $staffDirectory->department->department == 'Teaching')
                                    <tr>
                                        <th>Level</th>
                                        <td>
                                        <!-- {{$staffDirectory->level->name ?? 'N/A'}} -->
                                        @foreach($levels as $level)
                                            {{$level->level->name}},
                                        @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Program</th>
                                        <td>
                                            <!-- {{$staffDirectory->program->name ?? 'N/A'}} -->
                                            @foreach($programs as $program)
                                                {{$program->program->name}},
                                            @endforeach
                                        </td>
                                    </tr>
                                    <!-- <tr>
                                        <th>Year/Semester</th>
                                        <td>{{$staffDirectory->yearsemester->name ?? 'N/A'}}</td>
                                    </tr>
                                    <tr>
                                        <th>Group</th>
                                        <td>{{$staffDirectory->section->group_name ?? 'N/A'}}</td>
                                    </tr> -->
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="member-card">
                        <div class="detail-header">
                            <h5><strong>Staff Details</strong></h5>
                        </div>
                        <hr>
                        <div>
                            <table class="table table-striped mx-auto w-100">
                                <tr>
                                    <th>Email</th>
                                    <td>{{$staffDirectory->email}}</td>
                                </tr>
                                <tr>
                                    <th>Permanent Address</th>
                                    <td>{{$staffDirectory->permanent_address}}</td>
                                </tr>
                                <tr>
                                    <th>Current Address</th>
                                    <td>{{$staffDirectory->current_address}}</td>
                                </tr>
                                <tr>
                                    <th>Qualification</th>
                                    <td>{{$staffDirectory->qualification}}</td>
                                </tr>
                                <tr>
                                    <th>Work Experience</th>
                                    <td>{{$staffDirectory->work_experience}}</td>
                                </tr>
                                <tr>
                                    <th>Marital Status</th>
                                    <td>{{$staffDirectory->marital_status}}</td>
                                </tr>
                                <tr>
                                    <th>Father's Name</th>
                                    <td>{{$staffDirectory->father_name}}</td>
                                </tr>
                                <tr>
                                    <th>Mother's Name</th>
                                    <td>{{$staffDirectory->mother_name}}</td>
                                </tr>
                                <tr>
                                    <th>Emergency Phone Number</th>
                                    <td>{{$staffDirectory->emergency_phone}}</td>
                                </tr>
                                <tr>
                                    <th>Date Of Joining</th>
                                    <td>{{$staffDirectory->date_of_joining}}</td>
                                </tr>
                            </table>
                        </div>
                        <hr>
                        <div class="detail-header">
                            <h5><strong>Payroll</strong></h5>
                            <table class="table table mx-auto w-100">
                                <tr>
                                    <th>Pan Number</th>
                                    <td>{{$staffDirectory->pan_number ?? 'N/A'}}</td>
                                </tr>
                                <tr>
                                    <th>Tenure</th>
                                    <td>
                                        @if($staffDirectory->contract_type )
                                            {{$staffDirectory->contract_type === 'full_time' ? 'Full Time': 'Part Time'}}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Basic Salary</th>
                                    <td>{{$staffDirectory->basic_salary ?? 'N/A'}}</td>
                                </tr>
                                <tr>
                                    <th>Work Shift</th>
                                    <td>{{$staffDirectory->work_shift ?? 'N/A'}}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="detail-header">
                            <h5><strong>Bank Account Details</strong></h5>
                            <table class="table table mx-auto w-100">
                                <tr>
                                    <th>Bank Name</th>
                                    <td>{{$staffDirectory->bank_name ?? 'N/A'}}</td>
                                </tr>
                                <tr>
                                    <th>Account Holder's Name</th>
                                    <td>{{$staffDirectory->bank_account_name ?? 'N/A'}}</td>
                                </tr>
                                <tr>
                                    <th>Bank Account Number</th>
                                    <td>{{$staffDirectory->bank_account_number ?? 'N/A'}}</td>
                                </tr>
                                <tr>
                                    <th>Bank Branch Name</th>
                                    <td>{{$staffDirectory->bank_branch_name ?? 'N/A'}}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="detail-header">
                            <h5><strong>Social Media Links</strong></h5>
                            <table class="table table mx-auto w-100">
                                <tr>
                                    <th>Facebook Link</th>
                                    <td>{{$staffDirectory->facebook_link ?? 'N/A'}}</td>
                                </tr>
                                <tr>
                                    <th>Instagram Link</th>
                                    <td>{{$staffDirectory->instagran_link ?? 'N/A'}}</td>
                                </tr>
                                <tr>
                                    <th>Twitter Link</th>
                                    <td>{{$staffDirectory->twitter_link ?? 'N/A'}}</td>
                                </tr>
                                <tr>
                                    <th>Linkedin Link</th>
                                    <td>{{$staffDirectory->linkedin_link ?? 'N/A'}}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="detail-header">
                            <h5><strong>Documents</strong></h5>
                            <table class="table table mx-auto w-100">
                                <tr>
                                    <th>Resume</th>
                                    <td>{{$staffDirectory->getMedia('resume')[0]->file_name ?? 'N/A'}} @if(!empty($staffDirectory->resume))<a href="{{$staffDirectory->resume}}" target="_blank"><img src="https://cdn-icons-png.flaticon.com/512/892/892303.png" alt="" style="height: 35px; width: 35px"></a>@endif</td>
                                </tr>
                                <tr>
                                    <th>Joining Letter</th>
                                    <td>{{$staffDirectory->getMedia('joining_letter')[0]->file_name ?? 'N/A'}} @if(!empty($staffDirectory->joining_letter))<a href="{{$staffDirectory->joining_letter}}" target="_blank"><img src="https://cdn-icons-png.flaticon.com/512/892/892303.png" alt="" style="height: 35px; width: 35px"></a>@endif</td>
                                </tr>
                                <tr>
                                    <th>Other Document</th>
                                    <td>{{$staffDirectory->getMedia('document')[0]->file_name ?? 'N/A'}} @if(!empty($staffDirectory->document))<a href="{{$staffDirectory->document}}" target="_blank"><img src="https://cdn-icons-png.flaticon.com/512/892/892303.png" alt="" style="height: 35px; width: 35px"></a>@endif</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



