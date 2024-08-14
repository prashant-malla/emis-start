@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Purpose</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Front Office</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Setup Front Office</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Purpose</a></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12 col-xxl-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">{{isset($purpose) ? "Edit Purpose" : " Add Purpose"}}</h5>
                        </div>
                        <div class="card-body">
                            @include('includes.message')
                            <form action=
                                      "@if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                                      @if(auth()->guard('staff')->user()->role->name == 'Admin')
                                      {{isset($level) ? route('admin.purpose.update', $level) : route('admin.purpose.store')}}
                                      @endif
                                      @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'superadmin')
                                      {{isset($purpose) ? route('purpose.update', $purpose) : route('purpose.store')}}
                                      @endif"
                                  method="POST">
                                @csrf
                                @if(isset($purpose))
                                    @method('PATCH')
                                @endif
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Purpose</label>
                                            <span style="color: red">&#42;</span>
                                            <input type="text" class="form-control" name="purpose" value='{{old('purpose')?old('purpose'):(isset($purpose) ? $purpose->purpose : '')}}' placeholder="Enter Visitor's Purpose">
                                            <span class="text-danger">@error('purpose'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm- mt-2 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">{{isset($purpose) ? "Update" : "+ Add"}}</button>
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

