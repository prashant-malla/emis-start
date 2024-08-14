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
                            <h5 class="card-title">Add Lesson/Unit Plan</h5>
                        </div>
                        <div class="card-body">
                            @include('includes.message')
                            <form action="
                                @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                                    @if(auth()->guard('staff')->user()->role->role == 'Teacher')
                                        {{route('teacher_lesson-plan.store')}}
                                    @endif
{{--                                @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'admin')--}}
{{--                                    {{ route('admin_lesson-plan.store') }}--}}
{{--                                @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'superadmin')--}}
{{--                                    {{ route('lesson-plan.store') }}--}}
                                @endif
                                " method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Lesson/Unit</label>
                                            <span style="color: red">&#42;</span>
                                            <input type="text" class="form-control" name="unit"
                                                   value='{{ old('unit') }}' placeholder="Enter Lesson/Unit" >
                                            <span class="text-danger">@error('unit'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Department</label> <span style="color: red">&#42;</span>
                                            <input type="text" class="department form-control" name="department"
                                                   value='{{ old('department') }}' placeholder="Enter Department" >
                                            <span class="text-danger">@error('department'){{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Topic/Content</label>
                                            <span style="color: red">&#42;</span>
                                            <input type="text" class="form-control" name="topic"
                                                   value='{{ old('topic') }}' placeholder="Enter Topic/Content" >
                                            <span class="text-danger">@error('topic'){{$message}}@enderror</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Academic Year</label>
                                            <span style="color: red">&#42;</span>
                                            <select class="form-control select" name="academic_year_id"
                                                id="academic_year_id" required>
                                                <option value="">Select Academic Year</option>
                                                @foreach ($academicYears as $academicYear)
                                                    <option value="{{ $academicYear->id }}">
                                                        {{ $academicYear->title }}
                                                    </option>
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
                                                @foreach ($batches as $batch)
                                                    <option value="{{ $batch->id }}">
                                                        {{ $batch->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <x-error key="batch_id" />
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Level</label>
                                            <span style="color: red">&#42;</span>
                                            <select class="form-control select" name="level_id" id="level_id">
                                                <option value="">Select Level</option>
                                                @foreach ($levels as $level)
                                                    <option value="{{ $level->id }}" @selected(old('level_id') === $level->id)>{{$level->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">@error('level_id') {{ $message }}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Programme</label>
                                            <span style="color: red">&#42;</span>
                                            <select class="form-control select" name="program_id" id="program_id">
                                                <option value="">Please select level at first</option>
                                            </select>
                                            <span class="text-danger">@error('program_id') {{ $message }}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Year/Semester</label>
                                            <span style="color: red">&#42;</span>
                                            <select class="form-control select" name="year_semester_id" id="year_semester_id">
                                                <option value="">Please select program at first</option>
                                            </select>
                                            <span class="text-danger">@error('year_semester_id') {{ $message }}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Subject</label>
                                            <span style="color: red">&#42;</span>
                                            <select class="form-control subject select" name="subject_id" id="subject_id">
                                                <option value="">Please select year/semester at first</option>
                                            </select>
                                            <span class="text-danger">@error('subject_id') {{ $message }}@enderror</span>
                                        </div>
                                    </div>
                                    {{-- <div class="col-12 multiple_template mb-2">
                                         <div class="clone_item">
                                            <div class="row align-items-end">
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Group</label><span style="color: red">&#42;</span>
                                                        <select class="form-control section" name="section_id[]" id="section_id">
                                                            <option value="">Please select year/semester at first</option>
                                                        </select>
                                                        <span class="text-danger">@error('section_id'){{$message}}@enderror</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Subject</label>
                                                        <span style="color: red">&#42;</span>
                                                        <select class="form-control subject" name="subject_id[]" id="subject_id">
                                                            <option value="">Please select section at first</option>
                                                        </select>
                                                        <span class="text-danger">@error('subject_id') {{ $message }}@enderror</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                                    <button type="button" class="btn btn-danger removeCard" style="display: none">Delete</button>
                                                    <button type="button" class="btn btn-primary addCard" style="display: none">Add</button>
                                                </div>
                                            </div>
                                         </div>
                                    </div> --}}
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Day of Completion</label>
                                            <span style="color: red">&#42;</span>
                                            <input type="text" class="form-control" name="completion_days"
                                                   value='{{ old('completion_days') }}' placeholder="Enter Day of Completion" >
                                            <span class="text-danger">@error('completion_days'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Teaching Learning Methods</label>
                                            <span style="color: red">&#42;</span>
                                            <div>
                                                <div>
                                                    @foreach ($methods as $method)
                                                        <label>
                                                            <input name="methods[]" type="checkbox"
                                                                   value="{{ $method }}"{{ old('methods[]') == '$method' ? 'checked' : '' }}>
                                                            {{ ucfirst($method) }}
                                                        </label>
                                                        <br/>
                                                    @endforeach
                                                    <label>
                                                        Other:
                                                        <input type="text" name="other_method"
                                                               value="{{ old('other_method') }}">
                                                    </label>
                                                </div>
                                            </div>
                                            <span class="text-danger">@error('methods'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Learning Objectives</label>
                                            <span style="color: red">&#42;</span>
                                            <textarea class="form-control"
                                                      name="learning_objective">{!! old('learning_objective') !!}</textarea>
                                            <span class="text-danger">@error('learning_objective'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Learning Tools/ Resources</label>
                                            <span style="color: red">&#42;</span>
                                            <textarea class="form-control"
                                                      name="learning_tool">{!!old('learning_tool')!!}</textarea>
                                            <span class="text-danger">@error('learning_tool'){{$message}}@enderror</span>
                                        </div>
                                    </div>                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Assignment</label>
                                            <input name="files[]" type="file" class="custom-upload" multiple/>
                                            <x-error key='files' />
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Evaluation Method</label>
                                            <span style="color: red">&#42;</span>
                                            <textarea class="form-control"
                                                      name="evaluation_method">{!! old('evaluation_method') !!}</textarea>
                                            <span class="text-danger">@error('evaluation_method'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Learning Outcomes</label>
                                            <span style="color: red">&#42;</span>
                                            <textarea class="form-control"
                                                      name="learning_outcome">{!! old('learning_outcome') !!}</textarea>
                                            <span class="text-danger">@error('learning_outcome'){{$message}}@enderror</span>
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
@section('scripts')
    @include('includes.plugins.file-upload')
    
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script src="{{ asset('js/lesson-plan/lesson-plan.js') }}"></script>
    <script>
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
        });
    </script>
@endsection
