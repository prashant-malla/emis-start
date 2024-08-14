@extends('layouts.master')
@section('styles')
    <style>
        #myTable .form-control {
            min-width: 80px
        }

        #myTable tbody tr.active {
            background: #0000000a;
        }
    </style>
@endsection

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
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Assign Exam Marks</a></li>
                    </ol>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Assign Exam Marks: <span
                            class="text-danger">{{ $exam->name }}({{ $exam->program->name }},
                            {{ $exam->yearSemester->name }})</span></h5>
                </div>
                <div class="card-body">
                    @include('includes.message')
                    <form action="">
                        <div class="row align-items-end">
                            <div class="col-md-3 col-lg-2">
                                <div class="form-group">
                                    <label for="section_id">Group</label>
                                    <select name="section_id" id="section_id" class="form-select select">
                                        <option value="All">All</option>
                                        @foreach ($sections as $section)
                                            <option value="{{ $section->id }}"
                                                {{ $section_id == $section->id ? 'selected' : '' }}>
                                                {{ $section->group_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-lg-2">
                                <div class="form-group">
                                    <label for="subject_id">Subject</label>
                                    <select name="subject_id" id="subject_id" class="form-select select">
                                        <option value="All">All</option>
                                        @foreach ($subjects as $subject)
                                            <option value="{{ $subject->subject->id }}"
                                                {{ $subject_id == $subject->subject->id ? 'selected' : '' }}>
                                                {{ $subject->subject->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-3 mb-3">
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @if ($section_id && count($examSubjects) == 0)
                <div class="alert alert-warning">Subjects has not been assigned for the given exam. Please assign subjects
                    first.
                </div>
            @endif

            @if ($section_id && count($examSubjects) > 0)
                <div class="card">
                    <div class="card-body">
                        <input type="text" class="form-control my-3"
                            placeholder="Enter Student Name or Roll No. to Search.." id="searchInput">
                        <form action="{{ route($base_route . '.exam_marks.store', $exam->id) }}" method="POST"
                            id="myForm">
                            @csrf
                            <input type="hidden" name="exam_id" value="{{ $exam->id }}">
                            <input type="hidden" name="section_id" value="{{ $section_id }}">
                            <div class="table-responsive table-scroll mb-3" style="max-height: calc(100vh - 200px)">
                                <table class="table table-bordered table-sm" id="myTable">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th width="30" rowspan="2">#</th>
                                            <th rowspan="2">Student</th>
                                            <th rowspan="2">Roll No.</th>
                                            @foreach ($examSubjects as $examSubject)
                                                <th rowspan="{{ $examSubject->subject->type == 'is_theory' ? 2 : 1 }}"
                                                    colspan="{{ $examSubject->subject->type == 'is_theory' ? 1 : 2 }}">
                                                    <input type="hidden" name="subject_id[]"
                                                        value="{{ $examSubject->subject->id }}">
                                                    {{ $examSubject->subject->name }} ({{ $examSubject->subject->code }})
                                                    @if ($examSubject->subject->type == 'is_theory')
                                                        <br />
                                                        ({{ $examSubject->theory_full_marks . '/' . $examSubject->theory_pass_marks }})
                                                    @endif
                                                </th>
                                            @endforeach
                                            <th width="30" rowspan="2"></th>
                                        </tr>
                                        <tr>
                                            @foreach ($examSubjects as $examSubject)
                                                @if ($examSubject->subject->type != 'is_theory')
                                                    <th>
                                                        Th<br />
                                                        ({{ $examSubject->theory_full_marks . '/' . $examSubject->theory_pass_marks }})
                                                    </th>
                                                    <th>
                                                        Pr<br />
                                                        ({{ $examSubject->practical_full_marks . '/' . $examSubject->practical_pass_marks }})
                                                    </th>
                                                @endif
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($students as $student)
                                            @php
                                                $studentExamMarks = $examMarks->get($student->id);
                                            @endphp
                                            <tr>
                                                <td>
                                                    @if (file_exists(public_path($student->profile_image)))
                                                        <img src="{{ $student->profile_image }}"
                                                            alt="{{ $student->sname }}" height="50px" width="50px">
                                                    @endif
                                                </td>
                                                <td>
                                                    <input type="hidden" name="student_id[]" value="{{ $student->id }}">
                                                    <div>
                                                        <a href="{{ route('student.show', $student->id) }}"
                                                            class="text-primary" target="_blank">{{ $student->sname }}</a>
                                                    </div>
                                                    <div>
                                                        ({{ $student->admission }})
                                                    </div>
                                                </td>
                                                <td>{{ $student->roll }}</td>
                                                @foreach ($examSubjects as $examSubject)
                                                    @php
                                                        $studentExamSubject =
                                                            !$examSubject->subject->is_optional ||
                                                            ($student->optionalSubjects->contains(
                                                                $examSubject->subject_id,
                                                            ) &&
                                                                $examSubject->subject->is_optional);
                                                        $marks = $studentExamMarks
                                                            ?->where('subject_id', $examSubject->subject_id)
                                                            ->first();
                                                    @endphp

                                                    @if (!$studentExamSubject)
                                                        @if ($examSubject->subject->type != 'is_theory')
                                                            <td></td>
                                                        @endif

                                                        @if ($examSubject->subject->type != 'is_practical')
                                                            <td></td>
                                                        @endif
                                                        @continue
                                                    @endif

                                                    @if ($examSubject->subject->type != 'is_practical')
                                                        <td>
                                                            <div class="d-flex">
                                                                <input type="number" min="0"
                                                                    max="{{ $examSubject->theory_full_marks }}"
                                                                    name="th[{{ $student->id }}][{{ $examSubject->subject_id }}]"
                                                                    class="form-control mark-input mr-2"
                                                                    value="{{ $marks?->theory_mark }}">
                                                            </div>

                                                            <label class="mb-0">
                                                                <input class="absent-check" type="checkbox"
                                                                    name="th_abs[{{ $student->id }}][{{ $examSubject->subject_id }}]"
                                                                    value="true" @checked($marks?->is_th_absent)> Absent
                                                            </label>
                                                        </td>
                                                    @endif

                                                    @if ($examSubject->subject->type != 'is_theory')
                                                        <td>
                                                            <div class="d-flex">
                                                                <input type="number" min="0"
                                                                    max="{{ $examSubject->practical_full_marks }}"
                                                                    name="pr[{{ $student->id }}][{{ $examSubject->subject_id }}]"
                                                                    class="form-control mark-input mr-2"
                                                                    value="{{ $marks?->practical_mark }}">
                                                            </div>

                                                            <label class="mb-0">
                                                                <input class="absent-check" type="checkbox"
                                                                    name="pr_abs[{{ $student->id }}][{{ $examSubject->subject_id }}]"
                                                                    value="true" @checked($marks?->is_pr_absent)> Absent
                                                            </label>
                                                        </td>
                                                    @endif
                                                @endforeach
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-danger m-1 btn-reset-row"
                                                        onclick="clearRow(this)"><i class="la la-refresh"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-right">
                                @if ($students->isNotEmpty())
                                    <button type="submit"
                                        class="btn btn-primary">{{ count(@$students) > 0 ? 'Update' : '+ Add' }}</button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function updateTdInputs(td, isChecked) {
            const markInput = td.find('input.mark-input');
            if (isChecked) {
                markInput.hide().val('');
            } else {
                markInput.show();
            }
        }

        $(function() {
            $('#myForm').validate({
                errorPlacement: function(e, a) {
                    return true
                }
            });

            $('.absent-check').change(function() {
                const td = $(this).closest('td');
                const isChecked = $(this).is(':checked');
                updateTdInputs(td, isChecked);
            });

            // init on load
            $('.absent-check').each(function() {
                const td = $(this).closest('td');
                const isChecked = $(this).is(':checked');
                updateTdInputs(td, isChecked);
            });

            // reset checkbox
            $('.btn-reset-row').click(function() {
                $(this).closest('tr').find('input[type="checkbox"]:checked')
                    ?.prop('checked', false).trigger('change');
            })

            // highlight tr
            $('#myTable tbody tr input').focus(function() {
                $('#myTable tbody tr').removeClass('active');
                $(this).closest('tr').addClass('active');
            });
        });
    </script>

    <script>
        // Get the input element
        const search = document.getElementById('searchInput');

        // Add event listener for input changes
        search.addEventListener('input', function() {
            const searchValue = this.value.toLowerCase(); // Get the search query in lowercase

            // Select all the rows inside tbody
            const rows = document.querySelectorAll('#myTable tbody tr');

            rows.forEach(function(row) {
                const nameData = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const rollData = row.querySelector('td:nth-child(3)').textContent.toLowerCase();

                // Show/hide the row based on matchFound
                if (searchValue === '' || nameData.includes(searchValue) || rollData.includes(
                        searchValue)) {
                    row.style.display =
                        'table-row'; // Show the row if the search is empty or a match is found
                } else {
                    row.style.display = 'none'; // Hide the row if no match is found
                }
            });
        });
    </script>
@endsection
