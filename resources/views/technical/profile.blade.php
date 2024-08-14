@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Profile</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Profile</a></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-3 col-xxl-4 col-lg-4">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="text-center p-3 overlay-box"
                                     style="background-image: url('{{ asset('template/images/big/img1.jpg')}}');">
                                    <div class="profile-photo">
                                        <img src="{{$technical->profile_image}}" width="100"
                                             class="img-fluid rounded-circle" alt="">
                                    </div>
                                    <h3 class="mt-3 mb-1 text-white">{{$technical->name}}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h2 class="card-title">about me</h2>
                                </div>
                                <div class="card-body pb-0">
                                    <p>{!! $technical->note !!}</p>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex px-0 justify-content-between">
                                            <strong>Staff ID</strong>
                                            <span class="mb-0">{{$technical->staff_id}}</span>
                                        </li>
                                        <li class="list-group-item d-flex px-0 justify-content-between">
                                            <strong>Education</strong>
                                            <span class="mb-0">{{$technical->qualification}}</span>
                                        </li>
                                        <li class="list-group-item d-flex px-0 justify-content-between">
                                            <strong>Department</strong>
                                            <span class="mb-0">{{$technical->department->department ?? 'N/A'}}</span>
                                        </li>
                                        <li class="list-group-item d-flex px-0 justify-content-between">
                                            <strong>Sub Department</strong>
                                            <span class="mb-0">{{$technical->sub_department->name ?? 'N/A'}}</span>
                                        </li>
                                        <li class="list-group-item d-flex px-0 justify-content-between">
                                            <strong>Designation</strong>
                                            <span class="mb-0">{{$technical->designation->title ?? 'N/A'}}</span>
                                        </li>
                                        <li class="list-group-item d-flex px-0 justify-content-between">
                                            <strong>Work Shift</strong>
                                            <span class="mb-0">{{$technical->work_shift ?? 'N/A'}}</span>
                                        </li>
                                        <li class="list-group-item d-flex px-0 justify-content-between">
                                            <strong>Work Experience</strong>
                                            <span class="mb-0">{{$technical->work_experience ?? 0}}</span>
                                        </li>
                                        <li class="list-group-item d-flex px-0 justify-content-between">
                                            <strong>Service Type</strong>
                                            <span class="mb-0">{{$technical->service_type ?? 'N/A'}}</span>
                                        </li>
                                        <li class="list-group-item d-flex px-0 justify-content-between">
                                            <strong>Contract Type</strong>
                                            <span class="mb-0">{{$technical->contract_type ?? 'N/A'}}</span>
                                        </li>
                                        <li class="list-group-item d-flex px-0 justify-content-between">
                                            <strong>Date of Joining</strong>
                                            <span
                                                class="mb-0">{{date('j F, Y', strtotime($technical->date_of_joining)) ?? 'N/A'}}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
{{--                        <div class="col-lg-12">--}}
{{--                            <div class="card">--}}
{{--                                <div class="card-header d-block">--}}
{{--                                    <h4 class="card-title">Address </h4>--}}
{{--                                </div>--}}
{{--                                <div class="card-body">--}}
{{--                                    <p class="mb-0">{{$technical->current_address}}</p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
                </div>
                <div class="col-xl-9 col-xxl-8 col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="profile-tab">
                                <div class="custom-tab-1">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item"><a href="#about-me" data-toggle="tab"
                                                                class="nav-link active show">About Me</a></li>
                                        {{--<li class="nav-item"><a href="#my-posts" data-toggle="tab" class="nav-link">Posts</a></li>--}}
                                    </ul>
                                    <div class="tab-content">
                                        <div id="about-me" class="tab-pane fade active show">
                                            <div class="profile-personal-info pt-4">
                                                <h4 class="text-primary mb-4">Personal Information</h4>
                                                <div class="row mb-4">
                                                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                                                        <h5 class="f-w-500">Email<span class="pull-right">:</span>
                                                        </h5>
                                                    </div>
                                                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                                                        <span>{{$technical->email}}</span>
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                                                        <h5 class="f-w-500">Gender<span class="pull-right">:</span>
                                                        </h5>
                                                    </div>
                                                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                                                        <span>{{$technical->gender}}</span>
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                                                        <h5 class="f-w-500">Date of Birth<span class="pull-right">:</span>
                                                        </h5>
                                                    </div>
                                                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                                                        <span>{{date('j F, Y', strtotime($technical->dob)) ?? 'N/A'}}</span>
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                                                        <h5 class="f-w-500">Phone Number<span
                                                                class="pull-right">:</span>
                                                        </h5>
                                                    </div>
                                                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                                                        <span>{{$technical->phone}}</span>
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                                                        <h5 class="f-w-500">Marital Status<span
                                                                class="pull-right">:</span>
                                                        </h5>
                                                    </div>
                                                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                                                        <span>{{$technical->marital_status}}</span>
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                                                        <h5 class="f-w-500">Permanent Address<span
                                                                class="pull-right">:</span>
                                                        </h5>
                                                    </div>
                                                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                                                        <span>{{$technical->permanent_address}}</span>
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                                                        <h5 class="f-w-500">Current Address<span
                                                                class="pull-right">:</span>
                                                        </h5>
                                                    </div>
                                                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                                                        <span>{{$technical->current_address}}</span>
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                                                        <h5 class="f-w-500">Father's Name<span
                                                                class="pull-right">:</span>
                                                        </h5>
                                                    </div>
                                                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                                                        <span>{{$technical->father_name ?? 'N/A'}}</span>
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                                                        <h5 class="f-w-500">Mother Name<span
                                                                class="pull-right">:</span>
                                                        </h5>
                                                    </div>
                                                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                                                        <span>{{$technical->mother_name}}</span>
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                                                        <h5 class="f-w-500">Emergency Contact Number<span
                                                                class="pull-right">:</span>
                                                        </h5>
                                                    </div>
                                                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                                                        <span>{{$technical->emergency_phone}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{--     <div id="my-posts" class="tab-pane fade">
                                                 <div class="my-post-content pt-3">
                                                     <div class="post-input">
                                                         <textarea name="textarea" id="textarea" cols="30" rows="5" class="form-control bg-transparent" placeholder="Please type what you want...."></textarea> <a href="javascript:void()"><i class="ti-clip"></i> </a>
                                                         <a href="javascript:void()"><i class="ti-camera"></i> </a><a href="javascript:void()" class="btn btn-primary">Post</a>
                                                     </div>
                                                     <div class="profile-uoloaded-post border-bottom-1 pb-5">
                                                         <img src="images/profile/8.jpg" alt="" class="img-fluid">
                                                         <a class="post-title" href="javascript:void()">
                                                             <h4>Collection of textile samples lay spread</h4>
                                                         </a>
                                                         <p>A wonderful serenity has take possession of my entire soul like these sweet morning of spare which enjoy whole heart.A wonderful serenity has take possession of my entire soul like these sweet morning
                                                             of spare which enjoy whole heart.</p>
                                                         <button class="btn btn-primary mr-3"><span class="mr-3"><i class="fa fa-heart"></i></span>Like</button>
                                                         <button class="btn btn-secondary"><span class="mr-3"><i class="fa fa-reply"></i></span>Reply</button>
                                                     </div>
                                                     <div class="profile-uoloaded-post border-bottom-1 pb-5">
                                                         <img src="images/profile/9.jpg" alt="" class="img-fluid">
                                                         <a class="post-title" href="javascript:void()">
                                                             <h4>Collection of textile samples lay spread</h4>
                                                         </a>
                                                         <p>A wonderful serenity has take possession of my entire soul like these sweet morning of spare which enjoy whole heart.A wonderful serenity has take possession of my entire soul like these sweet morning
                                                             of spare which enjoy whole heart.</p>
                                                         <button class="btn btn-primary mr-3"><span class="mr-3"><i class="fa fa-heart"></i></span>Like</button>
                                                         <button class="btn btn-secondary"><span class="mr-3"><i class="fa fa-reply"></i></span>Reply</button>
                                                     </div>
                                                     <div class="profile-uoloaded-post pb-5">
                                                         <img src="images/profile/8.jpg" alt="" class="img-fluid">
                                                         <a class="post-title" href="javascript:void()">
                                                             <h4>Collection of textile samples lay spread</h4>
                                                         </a>
                                                         <p>A wonderful serenity has take possession of my entire soul like these sweet morning of spare which enjoy whole heart.A wonderful serenity has take possession of my entire soul like these sweet morning
                                                             of spare which enjoy whole heart.</p>
                                                         <button class="btn btn-primary mr-3"><span class="mr-3"><i class="fa fa-heart"></i></span>Like</button>
                                                         <button class="btn btn-secondary"><span class="mr-3"><i class="fa fa-reply"></i></span>Reply</button>
                                                     </div>
                                                     <div class="text-center mb-2"><a href="javascript:void()" class="btn btn-primary">Load More</a>
                                                     </div>
                                                 </div>
                                             </div>--}}
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
