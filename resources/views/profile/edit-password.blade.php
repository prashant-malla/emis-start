@extends('layouts.master')
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

        <form class="form" action="{{ route('profile.password.update') }}" method="POST">

            @csrf
            @method('PATCH')

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Old Password</label>
                                        <input type="password" class="form-control" name="old_password" required>
                                        <x-error key="old_password" />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">New Password</label>
                                        <input id="password" type="password" class="form-control" name="password"
                                            aria-describedby="passwordHelpBlock" required>
                                        <x-error key="password" />
                                        <div id="passwordHelpBlock" class="form-text">
                                            Your password must be at least 8 characters.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Confirm New Password</label>
                                        <input type="password" class="form-control" name="password_confirmation">
                                    </div>
                                </div>
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
<script>
    $(function(){
        $('.form').validate({
            rules: {
                password: {
                    minlength: 8,
                },
                password_confirmation: {
                    minlength: 8,
                    equalTo: "#password"
                }
            },
            errorPlacement: function(e, a) {
                return true
            } 
        });
    });
</script>
@endsection