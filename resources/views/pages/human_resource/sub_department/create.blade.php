@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Sub Department</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Human Resource</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Sub Department</a></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12 col-xxl-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Add Sub Department</h5>
                        </div>
                        <div class="card-body">
                            @include('includes.message')
                            <form action="
                                @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                            @if(auth()->guard('staff')->user()->role->name == 'Admin')
                            {{isset($subDepartment) ? route('admin.sub_department.update', $subDepartment) : route('admin.sub_department.store')}}
                            @endif
                            @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'superadmin')
                            {{isset($subDepartment) ? route('sub_department.update', $subDepartment) : route('sub_department.store')}}
                            @endif
                                " method="POST">
                                @csrf
                                @if(isset($subDepartment))
                                    @method('PATCH')
                                @endif
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Department</label><span
                                            style="color: red">&#42;</span>
                                        <select class="form-control" name="department_id" id="department_id">
                                            <option value="">Select Department</option>
                                            @foreach ($departments as $department)
                                                <option value='{{ $department->id }}'
                                                        @isset($subDepartment)@if($department->id == $subDepartment->department->id) selected @endif @endisset>{{$department->department}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">@error('department_id'){{$message}}@enderror</span>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Name</label><span style="color: red">&#42;</span>
                                        <input type="text" class="form-control" name="name"
                                               value='{{old('name')?old('name'):(isset($subDepartment) ? $subDepartment->name : '')}}' placeholder="Name">
                                        <span class="text-danger">@error('name'){{$message}}@enderror</span>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm- mt-2 d-flex justify-content-end">
                                    <button type="submit"
                                            class="btn btn-primary">{{isset($subDepartment) ? "Update" : "+ Add"}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--**********************************
        Content body end
    ***********************************-->
@endsection


