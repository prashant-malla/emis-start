@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Feedback Type</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Front Office</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Setup Front Office</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Feedback Type</a></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12 col-xxl-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Add Feedback Type</h5>
                        </div>
                        <div class="card-body">
                            @include('includes.message')
                            <form action="
                                 {{-- @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                                    @if(auth()->guard('staff')->user()->role->name == 'Admin')
                                        {{ route('admin.complain-type/add') }}
                                    @elseif(auth()->guard('staff')->user()->role->name == 'Receptionist')
                                        {{ route('receptionist.complain-type/add') }}
                                    @elseif(auth()->guard('staff')->user()->role->name == 'Accountant')
                                        {{ route('accountant.complain-type/add') }}
                                    @endif
                                 @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'SuperAdmin')
                                    {{ route('complain-type.store') }}
                                 @endif --}}
                                {{ route('complain-type.store')}}
                                " method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label" >Feedback Type</label>
                                            <span style="color: red">&#42;</span>
                                            <input type="text" class="form-control" name="complain_type" value='{{ old('complain_type')}}' placeholder="Enter Feedback Type">
                                            <span class="text-danger">@error('complain_type'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm- mt-2 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">+ Add</button>
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

