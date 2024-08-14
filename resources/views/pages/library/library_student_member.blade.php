@extends('layouts.master')

@section('styles')
    <style>
        .manage-syllabus-switch input[type="checkbox"]:after {
            display: none;
        }

        /*.closeLibraryCard {*/
        /*    margin-right: 335px;*/
        /*}*/
    </style>
@endsection

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Student List</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Library</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Add Library Student Member</a></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12 col-xxl-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Select required fields</h5>
                        </div>
                        <div class="card-body">
                            @if (session()->get('success'))
                                @include('dashboard.include.message')
                            @endif
                            <form
                                action="
                                @if (\Illuminate\Support\Facades\Auth::guard('staff')->check()) @if (auth()->guard('staff')->user()->role->role == 'Librarian')
                                        {{ route('librarian_get_students.search') }} @endif
                                @endif
                                    "
                                method="get">
                                <div class="row">
                                    <div class="col-md-4 col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label">
                                                Academic Year <span class="required">*</span>
                                            </label>
                                            <select name="academic_year_id" id="academic_year_id" class="form-control select" required>
                                                @foreach ($academicYears as $academicYear)
                                                    <option value="{{ $academicYear->id }}" @selected($academicYear->id == request('academic_year_id'))>
                                                        {{ $academicYear->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label">Batch</label>
                                            <select name="batch_id" id="batch_id" class="form-control select">
                                                <option value="">Select</option>
                                                @foreach ($batches as $b)
                                                    <option value="{{ $b->id }}" @selected($b->id == request('batch_id'))>{{ $b->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label">Program</label>
                                            <span style="color: red">&#42;</span>
                                            <select class="form-control select" name="program_id" id="program_id" required
                                                style="width: 100%">
                                                <option value="">Select Program</option>
                                                @foreach ($programs as $program)
                                                    <option value='{{ $program->id }}' @selected($program->id == request('program_id'))>
                                                        {{ $program->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">
                                                @error('program_id')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label">Year/Semester</label>
                                            <span style="color: red">&#42;</span>
                                            <select class="form-control" name="year_semester_id" id="year_semester_id">
                                                <option value="">Please select program at first</option>
                                            </select>
                                            <span class="text-danger">
                                                @error('year_semester_id')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label">Group</label><span style="color: red">&#42;</span>
                                            <select class="form-control" name="section_id" id="section_id">
                                                <option value="">Please select year/semester at first</option>
                                            </select>
                                            <span class="text-danger">
                                                @error('section_id')
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
            </div>

            <div class="row">
                @isset($searchedStudents)
                    <div class="col-lg-12">
                        <div class="row tab-content">
                            <div id="list-view" class="tab-pane fade active show col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="example3" class="display" style="min-width: 845px">
                                                <thead>
                                                    <tr>
                                                        <th>Student Name</th>
                                                        <th>Gender</th>
                                                        <th>QrCode</th>
                                                        <th>Library Card Number</th>
                                                        <th>Reason</th>
                                                        <th>Removed Date</th>
                                                        <th>Removed By</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($searchedStudents as $student)
                                                        <tr>
                                                            <td>{{ $student->sname }}</td>
                                                            <td>{{ $student->gender }}</td>
                                                            <td style="position:relative;">
                                                                @if (isset($student->libraryMember) && $student->libraryMember->status == 1)
                                                                    <img src="{{ $student->libraryMember->qr_code }}"
                                                                        alt="" style="height: 50px"><a
                                                                        href="{{ $student->libraryMember->qr_code }}"
                                                                        target="_blank" download
                                                                        style="position: absolute; top: 0; left: 70px;"><img
                                                                            src="https://cdn-icons-png.flaticon.com/512/892/892303.png"
                                                                            alt=""
                                                                            style="height: 30px; width: 30px"></a>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if (isset($student->libraryMember) && $student->libraryMember->status == 1)
                                                                    {{ $student->libraryMember->library_card_number }}
                                                                @endif
                                                            </td>
                                                            <td style="color: red">
                                                                @if (isset($student->libraryMember) && $student->libraryMember->status == 0)
                                                                    {!! $student->libraryMember->reason !!}
                                                                @endif
                                                            </td>
                                                            <td style="color: red">
                                                                @if (isset($student->libraryMember) && $student->libraryMember->status == 0)
                                                                    {{ $student->libraryMember->removed_date }}
                                                                @endif
                                                            </td>
                                                            <td style="color: red">
                                                                @if (isset($student->libraryMember) && $student->libraryMember->status == 0)
                                                                    {{ $student->libraryMember->staffDirectory->name ?? '' }}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <div class="form-check form-switch manage-syllabus-switch">
                                                                    @if (isset($student->libraryMember) && $student->libraryMember->status == 1)
                                                                        <input class="form-check-input" type="radio"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#removeLibraryCardModel"
                                                                            data-id="{{ $student->libraryMember->id }}"
                                                                            checked>
                                                                    @else
                                                                        <input class="form-check-input submitLibraryCard"
                                                                            type="radio" name="student_id"
                                                                            value="{{ $student->id }}"
                                                                            title="Library Membership Status"
                                                                            data-toggle="tooltip">
                                                                    @endif
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                    <div class="modal fade" id="removeLibraryCardModel" tabindex="-1"
                                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                                        <strong>Are you sure you want to remove
                                                                            membership?</strong>
                                                                    </h5>
                                                                    <button type="button" class="btn-close closeLibraryCard"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div>
                                                                        <strong>Reason</strong>
                                                                        <textarea id="reason" class="form-control" name="reason"></textarea>
                                                                        <span id="reason_error_msg"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button"
                                                                        class="btn btn-danger closeLibraryCard"
                                                                        data-bs-dismiss="modal">No
                                                                    </button>
                                                                    <button type="button" class="btn btn-primary"
                                                                        id="removeLibraryCard">Yes
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endisset
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

        $('#year_semester_id').change(async function() {
            const yearSemesterId = $(this).val();
            const targetSelect = $('#section_id');
            showSelectLoader(targetSelect);

            const options = await getSectionOptions(yearSemesterId);
            targetSelect.html(options);

            hideSelectLoader(targetSelect);
            targetSelect.trigger('change');
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.submitLibraryCard').change(function() {
                this.checked = !!this.checked;
                let id = $(this).val();
                const type = "Student"
                $.ajax({
                    type: 'GET',
                    url: '/librarian/add_library_member/' + id,
                    data: {
                        type: type
                    },
                    dataType: "json",
                    success: function(response) {
                        alert(response.success || DEFAULT_SUCCESS_MESSAGE);

                        window.location.reload();
                    },
                    error: function(err) {
                        alert(err?.responseJSON?.message || DEFAULT_ERROR_MESSAGE)
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            var myModalEl = document.getElementById('removeLibraryCardModel')
            myModalEl.addEventListener('shown.bs.modal', function(event) {
                const relatedTarget = $(event.relatedTarget);
                const id = relatedTarget.data('id');
                $('#removeLibraryCard').data('id', id);
                // $('.closeLibraryCard').click(function (){
                //     window.location.reload();
                // })
            });

            $('#removeLibraryCard').click(function() {
                const id = $(this).data('id');
                let reason = $('#reason').val();
                if (!reason) {
                    $('#reason_error_msg').append(
                        `<span class="text-danger">Please write the reason.</span>`)
                    return;
                }
                $.ajax({
                    type: 'GET',
                    url: '/librarian/remove_member/' + id,
                    dataType: "json",
                    data: {
                        reason: reason
                    },
                    success: function(response) {
                        window.location.reload();
                    }
                });
            });
        });
    </script>
@endsection
