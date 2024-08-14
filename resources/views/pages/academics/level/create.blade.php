@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Level</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Academics</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Level</a></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12 col-xxl-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">{{isset($level) ? "Edit Level" : " Add Level"}}</h5>
                        </div>
                        <div class="card-body">
                            @include('includes.message')
                            <form action="
                                @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                            @if(auth()->guard('staff')->user()->role->name == 'Admin')
                            {{isset($level) ? route('admin.level.update', $level) : route('admin.level.store')}}
                            @endif
                            @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'superadmin')
                            {{isset($level) ? route('level.update', $level) : route('level.store')}}
                            @endif
                                " method="POST">
                                @csrf
                                @if(isset($level))
                                    @method('PATCH')
                                @endif
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Level Name</label><span style="color: red">&#42;</span>
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="name"
                                            value='{{old('name')?old('name'):(isset($level) ? $level->name : '')}}'
                                            placeholder="Level Name"
                                        >
                                        <span class="text-danger">@error('name'){{$message}}@enderror</span>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm- mt-2 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">{{isset($level) ? "Update" : "+ Add"}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


