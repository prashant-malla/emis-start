@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Lesson/Unit Plan</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Lesson/Unit Plan</a></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12 col-xxl-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Edit Lesson/Unit Plan</h5>
                        </div>
                        <div class="card-body">
                            @include('includes.message')
                            <form
                                action="
                            @if (\Illuminate\Support\Facades\Auth::guard('staff')->check()) @if (auth()->guard('staff')->user()->role->role == 'Teacher')
                            {{ route('teacher_lesson-plan.update') }} @endif
{{--                            @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'admin') --}}
{{--                            {{ route('admin_lesson-plan.update') }} --}}
{{--                            @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'superadmin') --}}
{{--                            {{ route('lesson-plan.update') }} --}}
                            @endif
                                "
                                method="POST" enctype="multipart/form-data">
                                <input type="hidden" name='id' value={{ $lessonPlan['id'] }}>
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Lesson/Unit</label>
                                            <span style="color: red">&#42;</span>
                                            <input type="text" class="form-control" name="unit"
                                                value='{{ $lessonPlan->unit }}' placeholder="Enter Lesson/Unit">
                                            <span class="text-danger">
                                                @error('unit')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Department</label>
                                            <input type="text" class="department form-control" name="department"
                                                value='{{ $lessonPlan->department }}' placeholder="Enter Department">
                                            <span class="text-danger">
                                                @error('department')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Topic/Content</label>
                                            <span style="color: red">&#42;</span>
                                            <input type="text" class="form-control" name="topic"
                                                value='{{ $lessonPlan->topic }}' placeholder="Enter Topic/Content">
                                            <span class="text-danger">
                                                @error('topic')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12" id="academic_year">
                                        <div class="form-group">
                                            <label class="form-label">Academic Year</label>
                                            <span style="color: red">&#42;</span>
                                            <select class="form-control select" name="academic_year_id"
                                                id="academic_year_id" required>
                                                <option value="">Select Academic Year</option>
                                                @foreach ($academicYears as $academicYear)
                                                    <option value="{{ $academicYear->id }}" @selected($academicYear->id == @$lessonPlan->yearSemester->academic_year_id)>
                                                        {{ $academicYear->title }}</option>
                                                @endforeach
                                            </select>
                                            <x-error key="academic_year_id" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12" id="batch">
                                        <div class="form-group">
                                            <label class="form-label">Batch</label>
                                            <span style="color: red">&#42;</span>
                                            <select class="form-control select" name="batch_id" id="batch_id" required>
                                                <option value="">Select Batch</option>
                                                @foreach ($batches as $data)
                                                    <option value="{{ $data->id }}"
                                                        {{ collect(@$lessonPlan->yearSemester->batch_id)->contains($data->id) ? 'selected' : '' }}>
                                                        {{ $data->title }}</option>
                                                @endforeach
                                            </select>
                                            <x-error key="batch_id" />
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Level</label>
                                            <span style="color: red">&#42;</span>
                                            <select class="form-control" name="level_id" id="level_id">
                                                <option value="">Select Level</option>
                                                @foreach ($levels as $row)
                                                    <option value='{{ $row->id }}' @selected($row->id === $lessonPlan->level_id)>
                                                        {{ $row->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">
                                                @error('level_id')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Programme</label>
                                            <span style="color: red">&#42;</span>
                                            <select class="form-control" name="program_id" id="program_id"
                                                data-selected={{ $lessonPlan->program_id }}>
                                                <option value="">Please select level at first</option>
                                            </select>
                                            <span class="text-danger">
                                                @error('program_id')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Year/Semester</label>
                                            <span style="color: red">&#42;</span>
                                            <select class="form-control" name="year_semester_id" id="year_semester_id"
                                                data-selected={{ $lessonPlan->year_semester_id }}>
                                                <option value="">Please select program at first</option>
                                            </select>
                                            <span class="text-danger">
                                                @error('year_semester_id')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    {{-- <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Section</label>
                                            <span style="color: red">&#42;</span>
                                            <select class="form-control" name="section_id" id="section_id">
                                                <option value="">Please select year/semester at first</option>
                                                @foreach ($sections as $row)
                                                    <option value='{{ $row->id }}'{{ (collect($lessonPlan->section_id)->contains($row->id)) ? 'selected':'' }}>{{$row->group_name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">@error('section_id') {{ $message }}@enderror</span>
                                        </div>
                                    </div> --}}
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Subject</label>
                                            <span style="color: red">&#42;</span>
                                            <select class="form-control" name="subject_id" id="subject_id"
                                                data-selected={{ $lessonPlan->subject_id }}>
                                                <option value="">Please select Year/Semester at first</option>
                                            </select>
                                            <span class="text-danger">
                                                @error('subject_id')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Day of Completion</label>
                                            <span style="color: red">&#42;</span>
                                            <input type="text" class="form-control" name="completion_days"
                                                value='{{ $lessonPlan->completion_days }}'
                                                placeholder="Enter Day of Completion">
                                            <span class="text-danger">
                                                @error('completion_days')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Teaching Learning Methods</label>
                                            <span style="color: red">&#42;</span>
                                            <div>
                                                @php
                                                    $learningMethod = json_decode($lessonPlan->learning_method);
                                                    // required to handle old array data type
                                                    $selectedLearningMethods =
                                                        gettype($learningMethod) === 'array'
                                                            ? $learningMethod
                                                            : $learningMethod->methods;
                                                @endphp
                                                @foreach ($methods as $method)
                                                    <input name="methods[]" type="checkbox" value="{{ $method }}"
                                                        @if (in_array($method, $selectedLearningMethods)) checked @endif>
                                                    <label for="{{ $method }}">{{ ucfirst($method) }}</label>
                                                    <br>
                                                @endforeach
                                                <label>
                                                    Other:
                                                    <input type="text" name="other_method"
                                                        value="{{ isset($learningMethod->other_method) ? $learningMethod->other_method : old('other_method') }}">
                                                </label>
                                            </div>
                                            <span class="text-danger">
                                                @error('learning_method')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Learning Objectives</label>
                                            <span style="color: red">&#42;</span>
                                            <textarea class="form-control" name="learning_objective">{!! $lessonPlan->learning_objective !!}</textarea>
                                            <span class="text-danger">
                                                @error('learning_objective')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Learning Tools/ Resources</label>
                                            <span style="color: red">&#42;</span>
                                            <textarea class="form-control" name="learning_tool">{!! $lessonPlan->learning_tool !!}</textarea>
                                            <span class="text-danger">
                                                @error('learning_tool')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">Assignment</label>

                                            <div class="mb-2">
                                                <x-edit-file-list :files='$lessonPlan->files' />
                                            </div>

                                            <input name="files[]" type="file" class="custom-upload" multiple />
                                            <x-error key='files' />
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Evaluation Method</label>
                                            <span style="color: red">&#42;</span>
                                            <textarea class="form-control" name="evaluation_method">{!! $lessonPlan->evaluation_method !!}</textarea>
                                            <span class="text-danger">
                                                @error('evaluation_method')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Learning Outcomes</label>
                                            <span style="color: red">&#42;</span>
                                            <textarea class="form-control" name="learning_outcome">{!! $lessonPlan->learning_outcome !!}</textarea>
                                            <span class="text-danger">
                                                @error('learning_outcome')
                                                    {{ $message }}
                                                @enderror
                                            </span>
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
    @include('includes.plugins.file-upload', [
        'fileDeleteUrl' => route($routename_prefix . 'lesson-plan.remove-file', $lessonPlan),
    ])

    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script src="{{ asset('js/lesson-plan/lesson-plan.js') }}"></script>
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
    </script>
@endsection
