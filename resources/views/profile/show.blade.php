@extends('layouts.master')

@section('styles')
<style>
    .profile-photo img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        object-position: center;
    }
</style>
@endsection

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>{{$title}}</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">{{$title}}</a></li>
                </ol>
            </div>
        </div>

        <div class="text-right mb-3">
            <a href="{{route('profile.edit')}}" class="btn btn-primary"><i class="fa fa-edit"></i> Edit {{$title}}</a>
        </div>

        @include('includes.message')

        <div class="row">
            <div class="col-xl-3 col-xxl-4 col-lg-4">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="text-center p-3 overlay-box"
                                style="background-image: url('{{ asset('images/student2.jpg')}}');">
                                <div class="profile-photo">
                                    <img src="{{$profile->profile_image ?? asset('template/images/icons/user-icon.jpg')}}"
                                        width="100" class="img-fluid rounded-circle" alt="">
                                </div>
                                <h3 class="mt-3 mb-1 text-white">{{$isStudent ? $profile->sname : $profile->name}}</h3>
                                <p class="text-white mb-0">{{$isStudent ? 'Student' : ($isStaff ? $profile->role->role :
                                    $profile?->role)}}</p>
                            </div>
                        </div>
                    </div>
                    @if(!$isSuperAdmin)
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">

                                        @includeWhen($isStaff, 'profile.partials.list._staff_list')

                                        @includeWhen($isStudent, 'profile.partials.list._student_list')

                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-xl-9 col-xxl-8 col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="profile-tab">

                            @includeWhen($isSuperAdmin, 'profile.partials.tabs._admin_tabs')

                            @includeWhen($isStaff, 'profile.partials.tabs._staff_tabs')

                            @includeWhen($isStudent, 'profile.partials.tabs._student_tabs')

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection