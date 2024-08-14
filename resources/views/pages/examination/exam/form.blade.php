@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Examination</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Examination</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Add Exam</a></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8 col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Add Exam</h5>
                        </div>
                        <div class="card-body">
                            @include('includes.message')
                            <form class="validate"
                                action="{{ isset($data) ? route($base_route . '.update', $data->id) : route($base_route . '.store') }}"
                                method="POST">
                                @csrf

                                @isset($data)
                                    @method('PATCH')
                                @endisset

                                <input id="level_id" type="hidden" name="level_id" value="{{ @$data->level_id }}">
                                <x-error key="level_id" />

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="name">Exam Name<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ @$data->name }}" required>
                                            <x-error key="name" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label">
                                                Academic Year <span class="required">*</span>
                                            </label>
                                            <select name="academic_year_id" id="academic_year_id"
                                                class="form-control select" required>
                                                @php
                                                    $selectedId =
                                                        $data->yearSemester->academic_year_id ??
                                                        $academicYears->where('is_active', 1)->first()?->id;
                                                @endphp
                                                @foreach ($academicYears as $academicYear)
                                                    <option value="{{ $academicYear->id }}" @selected($academicYear->id == $selectedId)>
                                                        {{ $academicYear->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label">Batch</label>
                                            <select name="batch_id" id="batch_id" class="form-control select">
                                                <option value="">Select</option>
                                                @foreach ($batches as $b)
                                                    <option value="{{ $b->id }}" @selected($b->id == @$data->yearSemester->batch_id)>
                                                        {{ $b->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="form-group">
                                            <label for="program_id">Program<span class="text-danger">*</span></label>
                                            <select name="program_id" id="program_id" class="form-control select" required>
                                                <option value="">Select</option>
                                                @isset($programs)
                                                    @foreach ($programs as $program)
                                                        <option value="{{ $program->id }}"
                                                            {{ @$data->program_id === $program->id ? 'selected' : '' }}
                                                            data-level-id="{{ $program->level_id }}">
                                                            {{ $program->name }}</option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                            <x-error key="program_id" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="form-group">
                                            <label for="year_semester_id">Year/Semester<span
                                                    class="text-danger">*</span></label>
                                            <select name="year_semester_id" id="year_semester_id"
                                                class="form-control select" required>
                                                <option value="">Select</option>
                                                @isset($yearSemesters)
                                                    @foreach ($yearSemesters as $yearSemester)
                                                        <option value="{{ $yearSemester->id }}"
                                                            {{ @$data->year_semester_id === $yearSemester->id ? 'selected' : '' }}>
                                                            {{ $yearSemester->name }}</option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                            <x-error key="year_semester_id" />
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-lg-4">
                                        <div class="form-group">
                                            <label for="attempt">Attempt</label>
                                            <select name="attempt" id="attempt" class="form-control select" required>
                                                @foreach (EXAM_ATTEMPTS as $key => $attempt)
                                                    <option value="{{ $key }}" @selected(@$data->attempt === $key)>
                                                        {{ $attempt }}</option>
                                                @endforeach
                                            </select>
                                            <x-error key="attempt" />
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label" for="description">Description</label>
                                            <textarea id="description" class="form-control" name="description" maxlength="255" rows="3">{{ @$data->description }}</textarea>
                                            <x-error key="description" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="form-group">
                                            <label for="exam_type_id">Exam Type<span class="text-danger">*</span></label>
                                            <select name="exam_type_id" id="exam_type_id" class="form-select" required>
                                                @foreach ($examTypes as $id => $typeName)
                                                    <option value="{{ $id }}"
                                                        {{ @$data->exam_type_id === $id ? 'selected' : '' }}>
                                                        {{ $typeName }}</option>
                                                @endforeach
                                            </select>
                                            <x-error key="exam_type_id" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="form-group">
                                            <label for="result_date">Result Date</label>
                                            <input type="text" class="form-control system-datepicker"
                                                name="result_date" value="{{ @$data->result_date }}">
                                            <x-error key="result_date" />
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label" for="description">Status</label><br />
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="status"
                                                    name="status" value="1"
                                                    {{ !isset($data) || $data->status ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="status">Active</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button type="submit"
                                        class="btn btn-primary">{{ isset($data) ? 'Update' : '+ Add' }}</button>
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
    <script>
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
        });

        $('#program_id').change(async function() {
            $('#level_id').val($(this).find(':selected').attr('data-level-id'));
        });
    </script>
@endsection
