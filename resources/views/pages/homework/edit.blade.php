@php
    $removeFileRoute = route($routename_prefix . 'homework.remove-file', $homework);
@endphp

@extends('layouts.master')
@section('styles')
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
@endsection
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Assignment</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Assignment</a></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12 col-xxl-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Edit Assignment</h5>
                        </div>
                        <div class="card-body">
                            @include('includes.message')
                            <form action="{{route($routename_prefix.'homework.update', $homework->id)}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Academic Year</label>
                                            <span style="color: red">&#42;</span>
                                            <select class="form-control select" name="academic_year_id"
                                                id="academic_year_id" required>
                                                <option value="">Select Academic Year</option>
                                                @foreach ($academicYears as $academicYear)
                                                    <option value="{{ $academicYear->id }}" @selected($academicYear->id == @$homework->yearSemester->academic_year_id)>
                                                        {{ $academicYear->title }}</option>
                                                @endforeach
                                            </select>
                                            <x-error key="academic_year_id" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Batch</label>
                                            <span style="color: red">&#42;</span>
                                            <select class="form-control select" name="batch_id" id="batch_id" required>
                                                <option value="">Select Batch</option>
                                                @foreach ($batches as $data)
                                                    <option value="{{ $data->id }}"
                                                        @selected($data->id == @$homework->yearSemester->batch_id)>
                                                        {{ $data->title }}</option>
                                                @endforeach
                                            </select>
                                            <x-error key="batch_id" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Level</label>
                                            <span style="color: red">&#42;</span>
                                            <select class="form-control" name="level_id" id="level_id">
                                                <option value="0">Select Program</option>
                                                @foreach ($level as $row)
                                                    <option
                                                        value='{{ $row->id }}'{{ (collect($homework->level_id)->contains($row->id)) ? 'selected':'' }}>{{$row->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">@error('level_id') {{ $message }}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Program</label>
                                            <span style="color: red">&#42;</span>
                                            <select class="form-control" name="program_id" id="program_id">
                                                <option value="">Select Program</option>
                                                @foreach ($program as $row)
                                                    <option value='{{ $row->id }}'{{ (collect($homework->program_id)->contains($row->id)) ? 'selected':'' }}>{{$row->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">@error('program_id') {{ $message }}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Year/Semester</label>
                                            <span style="color: red">&#42;</span>
                                            <select class="form-control" name="year_semester_id" id="year_semester_id">
                                                <option value="">Select Year/Semester</option>
                                                @foreach ($yearSemester as $row)
                                                    <option value='{{ $row->id }}'{{ (collect($homework->year_semester_id)->contains($row->id)) ? 'selected':'' }}>{{$row->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">@error('year_semester_id') {{ $message }}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Group</label>
                                            <span style="color: red">&#42;</span>
                                            <select class="form-control" name="section_id" id="section_id">
                                                <option value="">Select Group</option>
                                                @foreach ($section as $row)
                                                    <option value='{{ $row->id }}'{{ (collect($homework->section_id)->contains($row->id)) ? 'selected':'' }}>{{$row->group_name}}</option>
                                                @endforeach
                                            </select>
                                            <span
                                                class="text-danger">@error('section_id') {{ $message }}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Subject</label>
                                            <span style="color: red">&#42;</span>
                                            <select class="form-control" name="subject_id" id="subject_id">
                                                <option value="">Select Subject</option>
                                                @foreach ($subject as $row)
                                                    <option value='{{ $row->id }}' {{ (collect($homework->subject_id)->contains($row->id)) ? 'selected':'' }}>{{$row->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">@error('subject_id'){{ $message }}@enderror</span>
                                        </div>
                                    </div>
                                    @if($isSuperAdmin)
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Assigned By</label>
                                            <span style="color: red">&#42;</span>
                                            <select class="form-control" name="teacher_id" id="teacher_id">
                                                <option value="">Select Teacher</option>
                                                @foreach ($teacher as $row)
                                                    <option value='{{ $row->id }}' {{ (collect($homework->teacher_id)->contains($row->id)) ? 'selected':'' }}>{{$row->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">@error('teacher_id'){{ $message }}@enderror</span>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Assigned Date</label>
                                            <span style="color: red">&#42;</span>
                                            <input type="date" class="form-control system-datepicker" name="assign" value="{{($homework->assign)}}">
                                            <span class="text-danger">@error('assign'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Submission Date</label>
                                            <span style="color: red">&#42;</span>
                                            <input type="date" class="form-control system-datepicker" name="submission"
                                                   value="{{($homework->submission)}}">
                                            <span class="text-danger">@error('submission'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Submission Time</label>
                                            <span style="color: red">&#42;</span>
                                            <input type="time" class="form-control" name="submission_time"
                                                   value="{{$homework->submission_time}}">
                                            <span
                                                class="text-danger">@error('submission_time'){{$message}}@enderror</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Attach Document</label>
                                            <div class="mb-2">

                                                @foreach($homework->files as $key => $file)
                                                <div class="mb-2">
                                                    <div class="mb-2">
                                                        <a
                                                            href="{{ $file->getFullUrl() }}"
                                                            target="_blank"
                                                            class="btn btn-outline-dark btn-rounded px-4 my-3 my-sm-0 mr-3 m-b-10"
                                                        >
                                                            <i class="fa fa-download"></i> File {{ $key + 1 }}
                                                        </a>
                                                    </div>

                                                    <input
                                                        id="file{{ $key + 1 }}"
                                                        class="dropify"
                                                        type="file"
                                                        name="reports[]"
                                                        value='{{ old ('reports')}}'
                                                        multiple
                                                        data-default-file="{{ $file->getFullUrl() }}"
                                                    >
                                                    <span class="text-danger">@error('reports'){{$message}}@enderror</span>
                                                </div>
                                                @endforeach

                                                <input
                                                    class="dropify"
                                                    type="file"
                                                    name="report[]"
                                                    value='{{ old('report') }}'
                                                    multiple=""
                                                    accept="*/*"
                                                >
                                                <span class="text-danger">
                                                    @error('report')
                                                        {{$message}}
                                                    @enderror
                                                </span>

                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-xxl-12">
                                        <div class="form-group">
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control"
                                                      name="description">{{$homework->description}}</textarea>
                                            <span class="text-danger">@error('description'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm- mt-2 d-flex justify-content-end">
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
@section('scripts')
    <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>
    <script>
        var drHomework = $('.dropify').dropify();

        drHomework.on('dropify.beforeClear', function(event, element){
            if (confirm("Do you realy want to delete this file ?")) {
                $.ajax({
                    url: "{{ $removeFileRoute }}",
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}",
                        file: element.file.name
                    }
                }).done(function () {
                    location.reload()
                })
            }
        });
    </script>
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('description');
    </script>
    <script>
        $(document).ready(function () {
             $('#level_id').change(async function() {
                const levelId = $(this).val();
                const targetSelect = $('#program_id');
                showSelectLoader(targetSelect);

                const options = await getProgramsOptions(levelId);
                targetSelect.html(options);

                hideSelectLoader(targetSelect);
                targetSelect.trigger('change');
            });

            $('#program_id').change(async function() {
                const programId = $(this).val();
                const targetSelect = $('#year_semester_id');
                showSelectLoader(targetSelect);

                const options = await getYearSemesterOptions(programId);
                targetSelect.html(options);

                hideSelectLoader(targetSelect);
                targetSelect.trigger('change');
            });

            $('#year_semester_id').change(async function() {
                const yearSemesterId = $(this).val();
                const targetSelect = $('#section_id');
                showSelectLoader(targetSelect);

                const options = await getSectionOptions(yearSemesterId);
                targetSelect.html(options);

                hideSelectLoader(targetSelect);

                // to change subject
                 const subjectTargetSelect = $('#subject_id');
                showSelectLoader(subjectTargetSelect);

                const subjectOptions = await getSubjectOptions(yearSemesterId);
                subjectTargetSelect.html(subjectOptions);

                hideSelectLoader(subjectTargetSelect);
            });
        });
    </script>

    @if($isSuperAdmin)
        <script>
            $('#subject_id').change(async function() {
                const subjectId = $(this).val();
                const targetSelect = $('#teacher_id');
                showSelectLoader(targetSelect);

                const options = await getTeacherOptions(subjectId);
                targetSelect.html(options);

                hideSelectLoader(targetSelect);
            });
        </script>
    @endif
@endsection