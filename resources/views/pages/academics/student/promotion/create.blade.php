@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>{{ $title }}</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Academics</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Session</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">{{ $title }}</a></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card h-auto">
                        <div class="card-body">
                            @include('includes.message')
                            <form class="validate-basic" action="{{ route('student.promote') }}" method="GET" novalidate>
                                <div class="row align-items-end">
                                    <div class="col-md-4 col-lg-3 col-xl-2">
                                        <div class="form-group">
                                            <label class="form-label">Academic Year<span
                                                    class="text-danger">*</span></label>
                                            <select name="academic_year_id" id="academic_year_id"
                                                class="form-control select" required>
                                                <option value="">Select</option>
                                                @foreach ($academicYears as $academicYear)
                                                    <option value="{{ $academicYear->id }}" @selected($academicYear->id == $filters['academic_year_id'])>
                                                        {{ $academicYear->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-3 col-xl-2">
                                        <div class="form-group">
                                            <label for="batch_id">Batch<span class="text-danger">*</span></label>
                                            <select name="batch_id" id="batch_id" class="form-select select" required>
                                                <option value="">Select</option>
                                                @foreach ($batches as $batch)
                                                    <option value="{{ $batch->id }}" @selected($batch->id == $filters['batch_id'])>
                                                        {{ $batch->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-3 col-xl-2">
                                        <div class="form-group">
                                            <label for="program_id">Program<span class="text-danger">*</span></label>
                                            <select name="program_id" id="program_id" class="form-select select" required>
                                                <option value="">Select</option>
                                                @foreach ($programs as $program)
                                                    <option value="{{ $program->id }}" @selected($program->id == $filters['program_id'])>
                                                        {{ $program->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-3 col-xl-2">
                                        <div class="form-group">
                                            <label for="year_semester_id">Year/Semester<span
                                                    class="text-danger">*</span></label>
                                            <select name="year_semester_id" id="year_semester_id" class="form-select select"
                                                required>
                                                <option value="">Select</option>
                                                @foreach ($yearSemesters as $yearSemester)
                                                    <option value="{{ $yearSemester->id }}" @selected($yearSemester->id == $filters['year_semester_id'])>
                                                        {{ $yearSemester->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-3 col-xl-2">
                                        <div class="form-group">
                                            <label for="section_id">Group</label>
                                            <select name="section_id" id="section_id" class="form-control select">
                                                <option value="">All</option>
                                                @foreach ($sections as $section)
                                                    <option value="{{ $section->id }}" @selected($section->id == $filters['section_id'])>
                                                        {{ $section->group_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-3 col-xl-2">
                                        <div class="form-group">
                                            <label for="action">Action<span class="text-danger">*</span></label>
                                            <select name="action" id="action" class="form-control select">
                                                <option value="promote" @selected(request('action') == 'promote')>PROMOTE</option>
                                                <option value="update_status" @selected(request('action') == 'update_status')>UPDATE STATUS
                                                </option>
                                            </select>
                                            <x-error key="status" />
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">Filter Students</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    @isset($students)
                        <div class="card h-auto">
                            <div class="card-body">
                                @if ($students->count() === 0)
                                    <div class="alert alert-warning">
                                        There are no students or students has not been enrolled yet.
                                    </div>
                                @endif

                                <form class="validate-basic" action="{{ route('student.promote.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="action" value="{{ request('action') }}">

                                    @if (request('action') == 'promote')
                                        <p class="fw-bold mb-2">Promote To:</p>

                                        <input type="hidden" name="from_year_semester_id"
                                            value="{{ $filters['year_semester_id'] }}">
                                        <input type="hidden" name="to_batch_id" value="{{ $filters['batch_id'] }}">
                                        <input type="hidden" name="to_program_id" value="{{ $filters['program_id'] }}">

                                        <div class="mb-3">
                                            <div class="row align-items-end">
                                                <div class="col-md-4 col-lg-3 col-xl-2">
                                                    <div class="form-group mb-0">
                                                        <label class="form-label" for="to_academic_year_id">Academic Year<span
                                                                class="text-danger">*</span></label>
                                                        <select name="to_academic_year_id" id="to_academic_year_id"
                                                            class="form-control select" required>
                                                            <option value="">Select</option>
                                                            @foreach ($academicYears as $academicYear)
                                                                <option value="{{ $academicYear->id }}"
                                                                    @selected($academicYear->id == 0)>
                                                                    {{ $academicYear->title }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <x-error key="to_academic_year_id" />
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-lg-3 col-xl-2">
                                                    <div class="form-group mb-0">
                                                        <label for="to_program_id">Program<span
                                                                class="text-danger">*</span></label>
                                                        <select name="to_program_id" id="to_program_id"
                                                            class="form-select select" required disabled>
                                                            <option value="">Select</option>
                                                            @foreach ($programs as $program)
                                                                <option value="{{ $program->id }}"
                                                                    @selected($program->id == request('program_id'))>
                                                                    {{ $program->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <x-error key="to_program_id" />
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-lg-3 col-xl-2">
                                                    <div class="form-group mb-0">
                                                        <label for="to_year_semester_id">Year/Semester<span
                                                                class="text-danger">*</span></label>
                                                        <select name="to_year_semester_id" id="to_year_semester_id"
                                                            class="form-select select" required>
                                                            <option value="">Select</option>
                                                        </select>
                                                        <x-error key="to_year_semester_id" />
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-lg-3 col-xl-2">
                                                    <div class="form-group mb-0">
                                                        <label for="date">Date<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control system-datepicker"
                                                            name="date" value="{{ getTodaySystemDate() }}" required>
                                                        <x-error key="date" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="mb-3">
                                            <div class="row">
                                                <div class="col-md-4 col-lg-3 col-xl-2">
                                                    <div class="form-group mb-0">
                                                        <label for="status">Status<span class="text-danger">*</span></label>
                                                        <select name="status" id="status" class="form-control select"
                                                            required>
                                                            <option value="">Select</option>
                                                            @foreach (App\Enum\StudentStatusEnum::cases() as $case)
                                                                <option value="{{ $case->value }}">
                                                                    {{ $case->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <x-error key="status" />
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-lg-3 col-xl-2">
                                                    <div class="form-group mb-0">
                                                        <label for="date">Date<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control system-datepicker"
                                                            name="date" value="{{ getTodaySystemDate() }}" required>
                                                        <x-error key="date" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <x-error key="student_id" />
                                    <x-error key="from_year_semester_id" />
                                    <x-error key="to_batch_id" />
                                    <x-error key="to_section_id" />
                                    <x-error key="to_roll" />

                                    <div class="table-responsive table-scroll mb-3" style="max-height: 400px">
                                        <table class="table table-bordered table-sm">
                                            <thead>
                                                <tr class="bg-light">
                                                    <th width="50">
                                                        <input type="checkbox" id="checkAll">
                                                    </th>
                                                    <th width="60">S.N.</th>
                                                    <th>Student Name</th>
                                                    <th>Roll No.(CURRENT)</th>
                                                    <th>Gender</th>
                                                    @if (request('action') == 'promote')
                                                        <th width="15%" class="bg-info">
                                                            <div>Group</div>
                                                            <div>
                                                                <select id="master-student-section-select"
                                                                    class="student-section-select">
                                                                    <option value="">Select</option>
                                                                </select>
                                                            </div>
                                                        </th>
                                                        <th width="15%" class="bg-info">Roll No.(NEW)</th>
                                                    @else
                                                        <th width="15%">Remarks</th>
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($students as $student)
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" name="student_id[]"
                                                                value="{{ $student->id }}">
                                                        </td>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $student->sname }}</td>
                                                        <td>{{ $student->roll }}</td>
                                                        <td>{{ $student->gender }}</td>
                                                        @if (request('action') == 'promote')
                                                            <td class="bg-info">
                                                                <div>
                                                                    <select name="to_section_id[{{ $student->id }}]"
                                                                        class="student-section-select form-select"
                                                                        data-default="{{ $student->section_id }}">
                                                                        <option value="">Select</option>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td class="bg-info">
                                                                <input type="text" name="to_roll[{{ $student->id }}]"
                                                                    class="form-control" value="{{ $student->roll }}">
                                                            </td>
                                                        @else
                                                            <td>
                                                                <textarea class="form-control" name="remarks[{{ $student->id }}]"></textarea>
                                                            </td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="fw-bold">Total Students: {{ $students->count() }}</div>
                                        @if (!$students->isEmpty())
                                            <button id="promote-button" type="button" class="btn btn-primary">Update
                                                Students</button>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endisset
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/academics/promote-student.js') }}"></script>
@endsection
