@extends('layouts.master')
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('files/amsify.suggestags.css') }}">
    <style>
        span.fa.fa-times.amsify-remove-tag:hover {
            color: red;
        }
    </style>
@endsection
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Group</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Academics</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Group</a></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-6 col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">
                                {{ isset($section) ? 'Edit Group' : 'Add Group' }}
                            </h5>
                        </div>
                        <div class="card-body">
                            @include('includes.message')
                            @php($formAction = isset($section) ? route('section.update', $section) : route('section.store'))
                            <form class="validate" action="{{ $formAction }}" method="POST">
                                @csrf
                                @if (isset($section))
                                    @method('POST')
                                @endif
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="academic_year_id">Academic year<span
                                                    class="text-danger">*</span></label>
                                            <select name="academic_year_id" id="academic_year_id"
                                                class="form-control select" required>
                                                <option value="">Select</option>
                                                @foreach ($academicYears as $academicYear)
                                                    <option value="{{ $academicYear->id }}" @selected($academicYear->id == @$section->yearSemester->academic_year_id)>
                                                        {{ $academicYear->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <x-error key="academic_year_id" />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="batch_id">Batch<span class="text-danger">*</span></label>
                                            <select name="batch_id" id="batch_id" class="form-control select" required>
                                                <option value="">Select</option>
                                                @foreach ($batches as $batch)
                                                    <option value="{{ $batch->id }}" @selected($batch->id == @$section->yearSemester->batch_id)>
                                                        {{ $batch->title }}
                                                        @if ($batch->subtitle)
                                                            ({{ $batch->subtitle }})
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                            <x-error key="batch_id" />
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">Level<span class="text-danger">*</span></label>
                                            <select class="form-control select" name="level_id" id="level_id" required>
                                                <option value="">Select</option>
                                                @foreach ($levels as $level)
                                                    <option value='{{ $level->id }}' @selected($level->id == @$section->level_id)>
                                                        {{ $level->name }}</option>
                                                @endforeach
                                            </select>
                                            <x-error key="level_id" />
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">Program<span class="text-danger">*</span></label>
                                            <select class="form-control select" name="program_id" id="program_id" required>
                                                <option value="">Select</option>
                                                @foreach ($programs as $program)
                                                    <option value='{{ $program->id }}' @selected($program->id == @$section->program_id)>
                                                        {{ $program->name }}</option>
                                                @endforeach
                                            </select>
                                            <x-error key="program_id" />
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">Year/Semester<span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control select" name="year_semester_id"
                                                id="year_semester_id" required>
                                                <option value="">Select</option>
                                                @foreach ($yearSemesters as $yearSemester)
                                                    <option value='{{ $yearSemester->id }}' @selected($yearSemester->id == @$section->year_semester_id)>
                                                        {{ $yearSemester->name }}</option>
                                                @endforeach
                                            </select>
                                            <x-error key="year_semester_id" />
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Group Name<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="group_name" id="section_id"
                                                value='{{ old('group_name') ? old('group_name') : $section->group_name ?? '' }}'
                                                placeholder="Enter Group Name" required>
                                            <x-error key="group_name" />
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm- mt-2 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">
                                            {{ isset($section) ? 'Update' : '+ Add' }}
                                        </button>
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
    <script type="text/javascript">
        $('#level_id').change(async function() {
            const levelId = $(this).val();
            const targetSelect = $('#program_id');
            showSelectLoader(targetSelect);

            const options = await getProgramsOptions(levelId);
            targetSelect.html(options);

            hideSelectLoader(targetSelect);
            targetSelect.trigger('change');
        });

        $('#academic_year_id, #batch_id, #program_id').change(async function() {
            const programId = $('#program_id').val();
            const academicYearId = $('#academic_year_id').val();
            const batchId = $('#batch_id').val();
            const targetSelect = $('#year_semester_id');
            showSelectLoader(targetSelect);

            const options = await getProgramYearSemesterOptions(programId, {
                academicYearId,
                batchId,
            });
            targetSelect.html(options);

            hideSelectLoader(targetSelect);
            targetSelect.trigger('change');
        });
    </script>
@endsection
