@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Designation</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Human Resource</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Designation</a></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12 col-xxl-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Add Designation</h5>
                        </div>
                        <div class="card-body">
                            @include('includes.message')
                            <form action="
                                @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                            @if(auth()->guard('staff')->user()->role->name == 'Admin')
                            {{isset($designation) ? route('admin.designation.update', $designation) : route('admin.designation.store')}}
                            @endif
                            @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'superadmin')
                            {{isset($designation) ? route('designation.update', $designation) : route('designation.store')}}
                            @endif
                                " method="POST">
                                @csrf
                                @if(isset($designation))
                                    @method('PATCH')
                                @endif
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Department</label><span style="color: red">&#42;</span>
                                        <select class="form-control" name="department_id" id="department_id">
                                            <option value="0">Select Department</option>
                                            @foreach ($departments as $department)
                                                <option value='{{ $department->id }}' @isset($designation)@if($department->id == $designation->department->id) selected @endif @endisset>{{$department->department}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">@error('department_id'){{$message}}@enderror</span>
                                    </div>
                                    <div class="form-group" id="subDepartment">
                                        <label class="form-label">Sub Department</label>
                                        <select class="form-control" name="sub_department_id" id="sub_department_id">
                                            <option value="">Select Sub Department</option>
                                            @foreach ($subDepartments as $subDepartment)
                                                <option value='{{ $subDepartment->id }}' @isset($designation) @if($designation->sub_department_id != null)@if($subDepartment->id == $designation->sub_department->id) selected @endif @endisset @endisset>{{$subDepartment->name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">@error('sub_department_id'){{$message}}@enderror</span>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Title</label><span style="color: red">&#42;</span>
                                        <input type="text" class="form-control" name="title"
                                               value='{{old('title')?old('title'):(isset($designation) ? $designation->title : '')}}' placeholder="Title">
                                        <span class="text-danger">@error('title'){{$message}}@enderror</span>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm- mt-2 d-flex justify-content-end">
                                    <button type="submit"
                                            class="btn btn-primary">{{isset($designation) ? "Update" : "+ Add"}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            @isset($designation)
            let editDepartment = $("#department_id option:selected").text();
            if (editDepartment == "Faculty Member" || editDepartment == "Teaching"){
                $('#subDepartment').hide();
            }else {
                $('#subDepartment').show();
            }
            @endisset
            $('#department_id').change(function (){
                let selectedDepartment = $("#department_id option:selected").text();
                if (selectedDepartment == "Faculty Member" || selectedDepartment == "Teaching"){
                    $('#subDepartment').hide();
                }else {
                    $('#subDepartment').show();
                }
            })

        })
    </script>
@endsection



