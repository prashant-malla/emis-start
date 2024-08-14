@extends('layouts.master')

@section('styles')
<link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
<style>
    .detail-header {
        background-color: #e7f1ff;
        padding: 10px;
        color: #0c63e4;
        border-radius: 5px;
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

        @include('includes.message')

        <form class="form" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">

            @csrf
            @method('PATCH')

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">

                                @includeWhen($isSuperAdmin, 'profile.partials.form_fields._admin_fields')

                                @includeWhen($isStaff, 'profile.partials.form_fields._staff_fields')

                                @includeWhen($isStudent, 'profile.partials.form_fields._student_fields')

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card h-auto">
                        <div class="card-body">
                            <div class="form-group">
                                <label class="form-label">Profile Image</label>
                                <input type="file" name="profile_image" class="dropify" accept="image/*"
                                    data-height="100"
                                    data-default-file="{{$profile->profile_image ?? asset('template/images/icons/user-icon.jpg')}}">
                                <x-error key="profile_image" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>
<script>
    $(function(){
        $('.dropify').dropify();

        $('.form').validate({
            errorPlacement: function(e, a) {
                return true
            } 
        });
    });
</script>
@endsection