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
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Assign Exam Schedules</a></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12 col-xxl-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Assign Exam Subjects: <span
                                    class="text-danger">{{ $exam->name }}({{ $exam->program->name }},
                                    {{ $exam->yearSemester->name }})</span></h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route($base_route . '.exam_subjects.store', $exam->id) }}" method="POST"
                                id="myForm">
                                @csrf
                                <input type="hidden" name="exam_id" value="{{ $exam->id }}">
                                <table class="table table-bordered" id="myTable">
                                    <thead>
                                        <tr>
                                            <th>Subject Name</th>
                                            {{-- <th width="150">Include</th> --}}
                                            <th>Subject Marks</th>
                                            <th>Exam Date<span class="text-danger">*</span></th>
                                            <th>Exam Time<span class="text-danger">*</span></th>
                                            <th>Total Hour<span class="text-danger">*</span></th>
                                            <th>Room Number</th>
                                            <th width="30"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($subjects) == 0)
                                            <td class="text-center" colspan="5">There are no subjects available to
                                                assign.</td>
                                        @endif
                                        @foreach ($subjects as $subject)
                                            @php($schedule = @$examSubjects[$subject->id])
                                            <tr>
                                                <td>
                                                    <input type="hidden" name="subject_id[]" value="{{ $subject->id }}">
                                                    <input type="hidden" name="subject_type[]"
                                                        value="{{ $subject->type }}">
                                                    {{ $subject->name }} ({{ $subject->code }})
                                                </td>

                                                {{-- <td>
                                                    @if ($subject->type === 'has_theory_practical')
                                                        <div class="form-group mb-0">
                                                            <label class="form-label">
                                                                <input class="include-theory" type="checkbox"
                                                                    name="include_theory[{{ $subject->id }}]"
                                                                    value="1" @checked(isset($schedule->include_theory) ? $schedule->include_theory : true)>
                                                                Theory
                                                            </label>
                                                        </div>
                                                        <div class="form-group mb-0">
                                                            <label class="form-label">
                                                                <input class="include-practical" type="checkbox"
                                                                    name="include_practical[{{ $subject->id }}]"
                                                                    value="1" @checked(isset($schedule->include_practical) ? $schedule->include_practical : true)>
                                                                Practical
                                                            </label>
                                                        </div>
                                                    @endif
                                                </td> --}}

                                                <td class="d-flex gap-1">
                                                    @if ($subject->type == \App\Enum\SubjectTypeEnum::THEORY_AND_PRACTICAL->value)
                                                        <div>
                                                            <span class="small text-muted">Theory(FM)</span>
                                                            <input type="text" name="theory_full_marks[]"
                                                                class="form-control"
                                                                value="{{ $schedule->theory_full_marks ?? $subject->theory_full_marks }}"
                                                                placeholder="Theory Full Marks">
                                                        </div>
                                                        <div>
                                                            <span class="small text-muted">Theory(PM)</span>
                                                            <input type="text" name="theory_pass_marks[]"
                                                                class="form-control"
                                                                value="{{ $schedule->theory_pass_marks ?? $subject->theory_pass_marks }}"
                                                                placeholder="Theory Pass Marks">
                                                        </div>
                                                        <div>
                                                            <span class="small text-muted">Practical(FM)</span>
                                                            <input type="text" name="practical_full_marks[]"
                                                                class="form-control"
                                                                value="{{ $schedule->practical_full_marks ?? $subject->practical_full_marks }}"
                                                                placeholder="Practical Full Marks">
                                                        </div>
                                                        <div>
                                                            <span class="small text-muted">Practical(PM)</span>
                                                            <input type="text" name="practical_pass_marks[]"
                                                                class="form-control"
                                                                value="{{ $schedule->practical_pass_marks ?? $subject->practical_pass_marks }}"
                                                                placeholder="Practical Pass Marks">
                                                        </div>
                                                    @elseif ($subject->type == \App\Enum\SubjectTypeEnum::THEORY_ONLY->value)
                                                        <div>
                                                            <span class="small text-muted">Theory(FM)</span>
                                                            <input type="text" name="theory_full_marks[]"
                                                                class="form-control"
                                                                value="{{ $schedule->theory_full_marks ?? $subject->theory_full_marks }}"
                                                                placeholder="Theory Full Marks">
                                                        </div>
                                                        <div>
                                                            <span class="small text-muted">Theory(PM)</span>
                                                            <input type="text" name="theory_pass_marks[]"
                                                                class="form-control"
                                                                value="{{ $schedule->theory_pass_marks ?? $subject->theory_pass_marks }}"
                                                                placeholder="Theory Pass Marks">
                                                        </div>
                                                        <input type="hidden" name="practical_full_marks[]">
                                                        <input type="hidden" name="practical_pass_marks[]">
                                                    @elseif ($subject->type == \App\Enum\SubjectTypeEnum::PRACTICAL_ONLY->value)
                                                        <input type="hidden" name="theory_full_marks[]">
                                                        <input type="hidden" name="theory_pass_marks[]">
                                                        <div>
                                                            <span class="small text-muted">Practical(FM)</span>
                                                            <input type="text" name="practical_full_marks[]"
                                                                class="form-control"
                                                                value="{{ $schedule->practical_full_marks ?? $subject->practical_full_marks }}"
                                                                placeholder="Practical Full Marks">
                                                        </div>
                                                        <div>
                                                            <span class="small text-muted">Practical(PM)</span>
                                                            <input type="text" name="practical_pass_marks[]"
                                                                class="form-control"
                                                                value="{{ $schedule->practical_pass_marks ?? $subject->practical_pass_marks }}"
                                                                placeholder="Practical Pass Marks">
                                                        </div>
                                                    @endif
                                                </td>

                                                <td>
                                                    <input type="text" name="date[]"
                                                        class="form-control system-datepicker"
                                                        value="{{ @$schedule->date }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="time[]" class="form-control timepicker"
                                                        value="{{ @$schedule->time?->format('h:i A') }}">
                                                </td>
                                                <td>
                                                    <input type="number" min="0.1" step="any"
                                                        name="duration[]" class="form-control"
                                                        value="{{ @$schedule->duration }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="room_number[]" class="form-control"
                                                        value="{{ @$schedule->room_number }}">
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-danger m-1"
                                                        onclick="clearRow(this)"><i class="la la-refresh"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @if (count($subjects) > 0)
                                    <div class="text-right">
                                        <button type="submit"
                                            class="btn btn-primary">{{ count($examSubjects) > 0 ? 'Update' : '+ Add' }}</button>
                                    </div>
                                @endif
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
        $(function() {
            $('#myForm').validate({
                errorPlacement: function(e, a) {
                    return true
                }
            });

            $('.include-theory, .include-practical').change(function() {
                const isChecked = $(this).is(':checked');
                const isNoneChecked = $(this).closest('tr').find(
                    '.include-theory:checked, .include-practical:checked').length === 0;
                if (isNoneChecked) {
                    $(this).prop('checked', true);
                }
            })
        });
    </script>
@endsection
