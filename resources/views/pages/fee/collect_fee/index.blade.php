@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Collect Fees</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Fee</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Collect Fee</a></li>
                    </ol>
                </div>
            </div>

            @if (!isset($searchedStudents))
                <div class="row">
                    <div class="col-xl-12 col-xxl-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Select required fields</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('student_name.search') }}" method="get">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <label class="form-label">Student</label>
                                                <span style="color: red">&#42;</span>
                                                <select class="form-control select" name="student_id" id="student_id"
                                                    required style="width: 100%">
                                                    <option value="">Select Student</option>
                                                    @foreach ($students as $student)
                                                        <option value='{{ $student->id }}'
                                                            {{ collect(old('student_id'))->contains($student->id) ? 'selected' : '' }}>
                                                            {{ $student->sname }}
                                                            ({{ $student->program->name }},
                                                            {{ $student->yearsemester->name }},
                                                            {{ $student->section->group_name }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger">
                                                    @error('student_id')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm- mt-2 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-xxl-12 col-sm-12">
                        <p>
                            <a class="btn-link" data-toggle="collapse" href="#collapseExample" role="button"
                                aria-expanded="false" aria-controls="collapseExample">
                                <u>+ Advance Search</u>
                            </a>
                        </p>
                        <div class="collapse" id="collapseExample">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Filter Students By</h5>
                                </div>
                                <div class="card-body">
                                    <form class="validate-basic" action="{{ route('collect_fee_students.search') }}"
                                        method="GET">
                                        <div class="row align-items-end">
                                            <div class="col-md-4 col-lg">
                                                <x-filter.program :items="$programs" :required="true" :selectedId="request('program_id')" />
                                            </div>
                                            <div class="col-md-4 col-lg">
                                                <x-filter.batch :items="$batches" :required="true" :selectedId="request('batch_id')" />
                                            </div>
                                            <div class="col-md-4 col-lg">
                                                <x-filter.year_semester :items="$yearSemesters ?? []" :required="true"
                                                    :selectedId="request('year_semester_id')" />
                                            </div>
                                            <div class="col-md-4 col-lg">
                                                <x-filter.section :items="$sections ?? []" :required="true" :selectedId="request('section_id')" />
                                            </div>
                                            <div class="col-md-4 col-lg mb-3">
                                                <button type="submit" class="btn btn-primary">Search</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-12">
                    @include('includes.message')
                    @isset($searchedStudents)
                        <div class="row tab-content">
                            <div id="list-view" class="tab-pane fade active show col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Collect Fee List</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="example3" class="display" style="min-width: 845px">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">S.N</th>
                                                        <th scope="col">Student's Name</th>
                                                        <th scope="col">Program</th>
                                                        <th scope="col">Year/Semester</th>
                                                        <th scope="col">Section</th>
                                                        <th scope="col">Admission Number</th>
                                                        <th scope="col">Date of Birth</th>
                                                        <th scope="col">Phone Number</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $i = 1;
                                                    @endphp
                                                    @foreach ($searchedStudents as $student)
                                                        <tr>
                                                            <td>{{ $i++ }}</td>
                                                            <td>{{ $student->sname }}</td>
                                                            <td>{{ $student->program->name }}</td>
                                                            <td>{{ $student->yearSemester->name }}</td>
                                                            <td>{{ $student->section->group_name }}</td>
                                                            <td>{{ $student->admission }}</td>
                                                            <td>{{ $student->dob ?? '-' }}</td>
                                                            <td>{{ $student->phone ?? '-' }}</td>
                                                            <td>
                                                                <a href="{{ route('student.collect_fee', $student->id) }}">
                                                                    <span class="shadow-none badge badge-primary"
                                                                        style="cursor: pointer">Collect</span>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endisset
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        const activeAcademicYearId = {{ activeAcademicYear()?->id }};

        $('#program_id, #batch_id').change(async function() {
            const programId = $('#program_id').val();
            const batchId = $('#batch_id').val();

            const targetSelect = $('#year_semester_id');
            showSelectLoader(targetSelect);

            const options = await getProgramYearSemesterOptions(programId, {
                batchId: batchId,
                academicYearId: activeAcademicYearId
            });
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
        });
    </script>
@endsection
