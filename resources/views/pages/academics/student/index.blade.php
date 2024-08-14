@extends('layouts.master')
@php
    use SimpleSoftwareIO\QrCode\Facades\QrCode;
    use App\Enum\StudentStatusEnum;

    if (!function_exists('getStatusClass')) {
        function getStatusClass($status)
        {
            if ($status == StudentStatusEnum::ACTIVE) {
                return 'success';
            } elseif ($status == StudentStatusEnum::DROPPED) {
                return 'danger';
            } elseif ($status == StudentStatusEnum::ALUMNI) {
                return 'info';
            } elseif ($status == StudentStatusEnum::ON_HOLD) {
                return 'warning';
            } else {
                return 'secondary';
            }
        }
    }
@endphp

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Student</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Academics</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Student</a></li>
                    </ol>
                </div>
            </div>

            @if ($studentNotEnrolledCount > 0)
                <div class="card">
                    <div class="card-body">
                        <h5>Enroll Students</h5>
                        <p class="text-muted">
                            Some students have not yet been enrolled. Enrollment is necessary to maintain historical student
                            data. If you've set up student batch, academic years and year/semesters, you can click the
                            'Enroll'
                            button below to complete the enrollment process.
                        </p>
                        <a href="{{ route('student.enroll') }}" class="btn btn-primary">Enroll Students
                            ({{ $studentNotEnrolledCount }})</a>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-12">
                    <div class="row tab-content">
                        <div id="list-view" class="tab-pane fade active show col-lg-12">
                            @include('includes.message')
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Student List</h4>
                                    <div class="d-flex">
                                        <a href="{{ route('student.create') }}" class="btn btn-primary">+ Add new</a>
                                        {{-- <form action="{{ route('student.generate_qrcode') }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-warning" style="margin-left: 10px"
                                                id="generateQr">Generate Qr</button>
                                        </form> --}}
                                        <a href="#" class="btn btn-sm btn-success" data-toggle="modal"
                                            data-target="#exampleModal" style="margin-left: 10px">Import Data</a>
                                        <a href="{{ route('student.export', [
                                            'level_id' => $filters['level_id'],
                                            'program_id' => $filters['program_id'],
                                            'year_semester_id' => $filters['year_semester_id'],
                                            'section_id' => $filters['section_id'],
                                        ]) }}"
                                            class="btn btn-sm btn-danger" style="margin-left: 10px">Export Data</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            @include('pages.academics.student.partials.filter', [
                                                'filterAction' => route('student.index'),
                                            ])
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table id="example3" class="display" style="min-width: 845px">
                                            <thead>
                                                <tr>
                                                    <th>Profile Image</th>
                                                    <th>CRN</th>
                                                    {{-- @if (!empty($students[0]->qr_code))
                                                <th>Qr Code</th>
                                                @endif --}}
                                                    <th>Name</th>
                                                    {{-- <th>Email</th> --}}
                                                    {{-- <th>AdmissionNo</th> --}}
                                                    {{-- <th>Ethnicity</th> --}}
                                                    <th>Batch</th>
                                                    <th>Level</th>
                                                    <th>Program</th>
                                                    <th>Year/Semester</th>
                                                    <th>Group</th>
                                                    {{-- <th>Roll No.</th>
                                                    <th>Gender</th> --}}
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($students as $key => $student)
                                                    <tr>
                                                        <td>
                                                            <a href="{{ route('student.show', $student->id) }}">
                                                                <img class="student-image"
                                                                    data-src="{{ $student->profile_image ?? 'N/A' }}"
                                                                    alt="" style="height: 50px; width: 50px;">
                                                            </a>
                                                        </td>
                                                        {{-- @if ($student->qr_code != null)
                                                    <td style="position:relative;">
                                                        <img src="{{$student->qr_code}}" alt="" style="height: 50px"><a href="{{$student->qr_code}}" target="_blank" download style="position: absolute; top: 10px; left: 70px;"><img src="https://cdn-icons-png.flaticon.com/512/892/892303.png" alt="" style="height: 30px; width: 30px"></a>
                                                    </td>
                                                    @endif --}}
                                                        <td>{{ getFullCRN($student->crn ?? $student->id, $student->batch) }}
                                                        </td>
                                                        <td>
                                                            {{ $student->sname ?? 'N/A' }}
                                                        </td>
                                                        {{-- <td>{{$student->email ?? 'N/A'}}</td> --}}
                                                        {{-- <td>{{$student->admission ?? 'N/A'}}</td> --}}
                                                        {{-- <td>{{$student->ethnicity ?? 'N/A'}}</td> --}}
                                                        <td>{{ $student->batch->title ?? '' }}</td>
                                                        <td>{{ $student->level->name ?? 'N/A' }}</td>
                                                        <td>{{ $student->program->name ?? 'N/A' }}</td>
                                                        <td>{{ $student->yearsemester->name ?? 'N/A' }}</td>
                                                        <td>{{ $student->section->group_name ?? 'N/A' }}</td>
                                                        {{-- <td>{{ $student->roll ?? 'N/A' }}</td>
                                                        <td>{{ $student->gender }}</td> --}}
                                                        <td>{{ $student->email ?? 'N/A' }}</td>
                                                        <td>{{ $student->phone ?? 'N/A' }}</td>
                                                        <td>
                                                            <span
                                                                class="badge badge-{{ getStatusClass($student->status) }}">
                                                                {{ $student->status->name }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex">
                                                                <a href="{{ route('student.show', $student) }} "
                                                                    class="btn btn-sm btn-primary m-1"><i
                                                                        class="la la-eye"></i></a>
                                                                <span data-toggle="tooltip" title="Reset Password">
                                                                    <a href="#" data-toggle="modal"
                                                                        data-target="#resetPasswordModal"
                                                                        data-user-id="{{ $student->id }}"
                                                                        class="btn btn-sm btn-info m-1"><i
                                                                            class="la la-key"></i></a>
                                                                </span>
                                                                <a href="{{ route('student.edit', $student) }} "
                                                                    class="btn btn-sm btn-warning m-1"><i
                                                                        class="la la-pencil"></i></a>
                                                                <form action="{{ route('student.drop', $student) }}"
                                                                    method="post"
                                                                    onsubmit="return confirm('Are you sure you want to drop this student')">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-sm btn-danger m-1"
                                                                        data-toggle="tooltip" title="Drop Student"
                                                                        {{ $student->status == \App\Enum\StudentStatusEnum::DROPPED ? 'disabled' : '' }}
                                                                        @disabled($student->status->value == \App\Enum\StudentStatusEnum::DROPPED)>
                                                                        <i class="la la-minus"></i>
                                                                    </button>
                                                                </form>
                                                                {{-- <form method="post"
                                                                    action="{{ route('student.destroy', $student) }}"
                                                                    onsubmit="return confirm('Are you sure?')">
                                                                    @method('delete')
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-sm btn-danger m-1"
                                                                        data-toggle="modal" data-target="#deleteModal">
                                                                        <i class="la la-trash-o"></i>
                                                                    </button>
                                                                </form> --}}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Upload File To Import Data
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('student.import') }}" method="post"
                                                enctype="multipart/form-data">
                                                <div class="modal-body">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="message-text" class="col-form-label">
                                                            Attach Document:
                                                        </label>
                                                        <input class="form-control" type="file" name="file"
                                                            multiple="" accept=".xlsx,.xls,.csv" required>
                                                    </div>
                                                    <hr>
                                                    <a href="{{ asset('imports/students-import-sample.xlsx') }}"
                                                        class="btn btn-success">
                                                        <span class="material-icons">
                                                            description
                                                        </span>
                                                        Download Sample
                                                    </a>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                @include('common.modals.reset-password', [
                                    'formAction' => route('student.password.reset'),
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function lazyLoadImage(img) {
            const src = img.getAttribute('data-src');
            if (src) {
                img.setAttribute('src', src);
                img.removeAttribute('data-src');
            }
        }

        $(function() {
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

            $('#year_semester_id').change(async function() {
                const yearSemesterId = $(this).val();
                const targetSelect = $('#section_id');
                showSelectLoader(targetSelect);

                const options = await getSectionOptions(yearSemesterId);
                targetSelect.html(options);

                hideSelectLoader(targetSelect);
            });

            $('.form').validate({
                errorPlacement: function(e, a) {
                    return true
                }
            });

            $('.student-image').each(function() {
                lazyLoadImage(this);
            });

            // TODO::lazy load with datatable draw
            $(document).on('click', '.paginate_button', function(e) {
                $('.student-image').each(function() {
                    lazyLoadImage(this);
                });
            });
        });
    </script>
@endsection
