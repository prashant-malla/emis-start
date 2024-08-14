@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Program</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Academics</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Program</a></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12 col-xxl-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">{{isset($program) ? "Edit Program" : " Add Program"}}</h5>
                        </div>
                        <div class="card-body">
                            @include('includes.message')
                            <form action="
                                @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                            @if(auth()->guard('staff')->user()->role->name == 'Admin')
                            {{isset($program) ? route('admin.program.update', $program) : route('admin.program.store')}}
                            @endif
                            @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'superadmin')
                            {{isset($program) ? route('program.update', $program) : route('program.store')}}
                            @endif
                                " method="POST">
                                @csrf
                                @if(isset($program))
                                    @method('PATCH')
                                @endif
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Level</label><span style="color: red">&#42;</span>
                                        <select class="form-control select" name="level_id" id="level_id">
                                            <option value="">Select Level</option>
                                            @foreach ($levels as $level)
                                                <option value='{{ $level->id }}' @isset($program)@if($level->id == $program->level_id) selected @endif @endisset>{{$level->name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">@error('level_id'){{$message}}@enderror</span>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Faculty</label>
                                        <select class="form-control select" name="faculty_id" id="faculty_id">
                                            <option value="">Select Faculty</option>
                                            @foreach ($faculties as $faculty)
                                                <option value='{{ $faculty->id }}' @selected($faculty->id == @$program->faculty_id)>{{$faculty->name}}</option>
                                            @endforeach
                                        </select>
                                        <x-error key="faculty_id"/>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Program</label><span style="color: red">&#42;</span>

                                        <input
                                            type="text"
                                            class="form-control"
                                            name="name"
                                            placeholder="Program Name"
                                            value='{{old('name')?old('name'):(isset($program) ? $program->name : '')}}'
                                        >

                                        <span class="text-danger">@error('name'){{$message}}@enderror</span>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Program Type</label><span style="color: red">&#42;</span>
                                        <select class="form-control select" name="type" id="type">
                                            <option value="">Select Program Type</option>
                                            <option value="year" @isset($program)@if('year' == $program->type) selected @endif @endisset>Year</option>
                                            <option value="semester" @isset($program)@if('semester' == $program->type) selected @endif @endisset>Semester</option>
                                        </select>
                                        <span class="text-danger">@error('type'){{$message}}@enderror</span>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Admission Fee</label><span style="color: red">&#42;</span>
                                        <input
                                            type="nuber"
                                            class="form-control"
                                            name="admission_fee"
                                            value='{{old('admission_fee')?old('admission_fee'):(isset($program) ? $program->admission_fee : '')}}'
                                            placeholder="Admission Fee"
                                        >
                                        <span class="text-danger">@error('admission_fee'){{$message}}@enderror</span>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm- mt-2 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">{{isset($program) ? "Update" : "+ Add"}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


