@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Year/Semester</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Academics</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Year/Semester</a></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-6 col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Edit Year/Semester</h5>
                        </div>
                        <div class="card-body">
                            @include('includes.message')
                            <form class="validate" action="{{ route('year-semester.update', $yearSemester) }}"
                                method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="batch_id">Batch<span class="text-danger">*</span></label>
                                            <select name="batch_id" id="batch_id" class="form-control select" required>
                                                <option value="">Select</option>
                                                @foreach ($batches as $batch)
                                                    <option value="{{ $batch->id }}" @selected($batch->id == old('batch_id', $yearSemester->batch_id))>
                                                        {{ $batch->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <x-error key="batch_id" />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">Program<span class="text-danger">*</span></label>
                                            <select class="form-control select" name="program_id" id="program_id" required>
                                                <option value="">Select</option>
                                                @foreach ($programs as $program)
                                                    <option value='{{ $program->id }}' @selected($program->id == old('program_id', $yearSemester->program_id))>
                                                        {{ $program->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <x-error key="program_id" />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Year/Semester Name<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="name" id="year_semester"
                                                value='{{ old('name', $yearSemester->name) }}'
                                                placeholder="Enter Year/Semester Name" required>
                                            <x-error key="name" />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">Term Number<span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" name="term_number"
                                                value='{{ old('term_number', $yearSemester->term_number) }}'
                                                placeholder="eg. 1" required>
                                            <x-error key="term_number" />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">Start Date</label>
                                            <input type="text" class="form-control system-datepicker" name="start_date"
                                                value='{{ old('start_date', $yearSemester->start_date) }}'
                                                placeholder="Choose Start Date">
                                            <x-error key="start_date" />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">End Date</label>
                                            <input type="text" class="form-control system-datepicker" name="start_date"
                                                value='{{ old('end_date', $yearSemester->end_date) }}'
                                                placeholder="Choose Start Date">
                                            <x-error key="end_date" />
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <input id="is_active" type="checkbox" name="is_active" value="1"
                                                @checked(old('is_active', $yearSemester->is_active))>
                                            <label class="form-label" for="is_active">Is Active</label>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Update</button>
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
