@extends('layouts.master')

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Mark Ledger</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Examination</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Mark Ledger</a></li>
                    </ol>
                </div>
            </div>
            @include('includes.message')
            <div class="card d-print-none">
                <div class="card-header">
                    <h4 class="card-title">Select Criteria</h4>
                </div>
                <div class="card-body">
                    @include('pages.examination.mark_ledger.partials.filter', [
                        'filterAction' => '',
                    ])
                </div>
            </div>

            @isset($examMarks)
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title d-flex justify-content-between align-items-end d-print-none">
                            <span>Mark Ledger</span>
                            <button type="button" id="printAll" class="btn btn-primary d-flex" onclick="window.print()">
                                <i class="material-icons mr-2">print</i> Print
                            </button>
                        </h4>

                        <table style="border-collapse: collapse; width: 100%; margin-bottom: 2rem;">
                            <tr>
                                <td colspan="3">&nbsp;</td>

                                <td colspan="6"
                                    style="text-align: center; padding-right: 1rem; display: flex; align-items: center; justify-content: center;">
                                    <div style="margin-right: 10px; width: 10%;">
                                        <img class="logo-abbr collapse-logo" style="width: 80%;"
                                            src="{{ $school_setting->logo_url }}" alt="{{ config('app.name') }}">
                                    </div>

                                    <div style="text-align: center;">
                                        <h5>Affiliated to Tribhuvan University</h5>
                                        <h3>{{ $school_setting->name }}</h3>
                                        {{ $school_setting->address }}
                                    </div>
                                </td>

                                <td colspan="3" style="text-align: center;">&nbsp;</td>
                            </tr>

                            <tr>
                                <td colspan="12" style="text-align: center; font-weight: bold; padding-top: 2rem;">
                                    @php
                                        $examStartDate = $exam->start_date;
                                    @endphp
                                    Examination Mark Ledger - {{ showYear($examStartDate) }}
                                    {{ $school_setting->calendar_type === 'en' ? 'A.D.' : 'B.S.' }}
                                </td>
                            </tr>
                        </table>

                        <table style="border-collapse: collapse; width: 100%; margin-bottom: 2rem;">
                            <tr>
                                <td colspan="2">
                                    <b>Level:</b>
                                    <span>{{ $exam->level->name }}</span>
                                </td>

                                <td colspan="2">
                                    <b>Programme:</b>
                                    <span>{{ $exam->program->name }}</span>
                                </td>

                                <td colspan="2">
                                    <b>Year/Semester:</b>
                                    <span>{{ $exam->yearSemester->name }}</span>
                                </td>

                                @if ($section_id)
                                    <td colspan="2">
                                        <b>Group:</b>
                                        <span>{{ $sections->find($section_id)?->group_name }}</span>
                                    </td>
                                @endif

                                <td colspan="2">
                                    <b>Examination:</b>
                                    <span>{{ $exam->name }}</span>
                                </td>
                            </tr>
                        </table>

                        @php
                            $colSpan = $examSubjects->sum(function ($examSubject) {
                                return $examSubject->subject->type == 'has_theory_practical' ? 2 : 1;
                            });
                        @endphp
                        <div class="table-responsive">
                            <table
                                style="border-collapse: collapse; width: 100%; margin-bottom: 2rem; font-size: 12px; text-align: center">
                                <tr>
                                    <th style="border: 1px solid black; padding: 8px;" colspan="1" width="3%"
                                        rowspan="3">S.N.</th>
                                    <th style="border: 1px solid black; padding: 8px;" colspan="1" width="12%"
                                        rowspan="3">Students' Name</th>
                                    <th style="border: 1px solid black; padding: 8px;" colspan="1" width="4%"
                                        rowspan="3">Roll No:</th>
                                    <th style="border: 1px solid black; padding: 8px;"colspan="{{ $colSpan }}"
                                        width="41%">Obtained Marks</th>
                                    <th style="border: 1px solid black; padding: 8px;" colspan="1" width="4%"
                                        rowspan="3">Total</th>
                                    <th style="border: 1px solid black; padding: 8px;" colspan="1" width="4%"
                                        rowspan="3">Percentage <br />(%)</th>
                                    <th style="border: 1px solid black; padding: 8px;" colspan="1" width="4%"
                                        rowspan="3">Result</th>
                                    <th style="border: 1px solid black; padding: 8px;" colspan="1" width="4%"
                                        rowspan="3">Division</th>
                                    <th style="border: 1px solid black; padding: 8px;" colspan="1" width="2%"
                                        rowspan="3">Ranks</th>
                                </tr>

                                <tr>
                                    @foreach ($examSubjects as $examSubject)
                                        @php
                                            $subject = $examSubject->subject;
                                        @endphp
                                        @if ($subject->type == 'has_theory_practical')
                                            <th width="5%" style="border: 1px solid black; padding: 8px;" colspan="2">
                                                {{ $subject->name }} ({{ $subject->code }})
                                            </th>
                                        @elseif($subject->type == 'is_theory')
                                            <th width="5%" style="border: 1px solid black; padding: 8px;" rowspan="2">
                                                {{ $subject->name }} ({{ $subject->code }})</br>
                                                ({{ $examSubject->theory_full_marks }}/{{ $examSubject->theory_pass_marks }})
                                            </th>
                                        @else
                                            <th width="5%" style="border: 1px solid black; padding: 8px;" rowspan="2">
                                                {{ $subject->name }} ({{ $subject->code }})</br>
                                                ({{ $examSubject->practical_full_marks }}/{{ $examSubject->practical_pass_marks }})
                                            </th>
                                        @endif
                                    @endforeach
                                </tr>

                                <tr>
                                    @foreach ($examSubjects as $examSubject)
                                        @if ($examSubject->subject->type == 'has_theory_practical')
                                            <th width="2.5%" style="border: 1px solid black; padding: 8px;">
                                                <span>Th</span>
                                                <span>({{ $examSubject->theory_full_marks }}/{{ $examSubject->theory_pass_marks }})</span>
                                            </th>
                                            <th width="2.5%" style="border: 1px solid black; padding: 8px;">
                                                <span>Pr</span>
                                                <span>({{ $examSubject->practical_full_marks }}/{{ $examSubject->practical_pass_marks }})</span>
                                            </th>
                                        @endif
                                    @endforeach
                                </tr>

                                @foreach ($studentList as $student)
                                    @php
                                        $studentEnrollment = $student->getEnrollment($exam->year_semester_id);
                                        $studentExamMarks = $examMarks->where('student_id', $student->id);
                                        $isFailed = false;
                                        $totalSubjectMarks = 0;
                                        $totalObtainedMarks = 0;
                                        $totalSubjectCount = 0;
                                        $absentSubjectCount = 0;
                                    @endphp

                                    <tr>
                                        <td style="border: 1px solid black; padding: 8px;">{{ $loop->iteration }}</td>
                                        <td style="border: 1px solid black; padding: 8px; text-align: left;">
                                            {{ $student->sname }}</td>
                                        <td style="border: 1px solid black; padding: 4px;">{{ $studentEnrollment?->roll }}</td>

                                        @foreach ($examSubjects as $examSub)
                                            @php
                                                $isStudentSubject =
                                                    !$examSub->subject->is_optional ||
                                                    ($examSub->subject->is_optional &&
                                                        $student->optionalSubjects->contains($examSub->subject_id));
                                            @endphp

                                            {{-- If subject is not taken by student, just display columns and skip --}}
                                            @if (!$isStudentSubject)
                                                @if ($examSub->subject->type != 'is_theory')
                                                    <th style="border: 1px solid black; padding: 8px;">-</th>
                                                @endif

                                                @if ($examSub->subject->type != 'is_practical')
                                                    <th style="border: 1px solid black; padding: 8px;">-</th>
                                                @endif

                                                @continue
                                            @endif

                                            @php
                                                $totalSubjectCount++;
                                                $subject = $examSub->subject;
                                                $marks = $studentExamMarks->where('subject_id', $subject->id)->first();
                                                $totalSubjectMarks +=
                                                    getMark($examSub->theory_full_marks) +
                                                    getMark($examSub->practical_full_marks);

                                                if ($marks) {
                                                    $obtainedSubjectMark = 0;

                                                    // Handled invalid data where marks exists even if th_absent or pr_absent
                                                    // Better to handle it within mark entry validation
                                                    if ($subject->type !== 'is_practical' && !$marks->is_th_absent) {
                                                        $obtainedSubjectMark += getMark($marks->theory_mark);
                                                    }

                                                    if ($subject->type !== 'is_theory' && !$marks->is_pr_absent) {
                                                        $obtainedSubjectMark += getMark($marks->practical_mark);
                                                    }

                                                    $totalObtainedMarks += $obtainedSubjectMark;
                                                    $isAbsent = $marks->is_th_absent || $marks->is_pr_absent;
                                                    if ($isAbsent) {
                                                        $absentSubjectCount++;
                                                    }

                                                    if (!$isFailed) {
                                                        $isFailed = $isAbsent || !isPassInSubject($examSub, $marks);
                                                    }
                                                }
                                            @endphp

                                            @switch(true)
                                                @case($subject->type === 'has_theory_practical')
                                                    <th style="border: 1px solid black; padding: 8px;">
                                                        {{ $marks ? ($marks->is_th_absent ? 'A' : $marks->theory_mark) : '' }}
                                                    </th>
                                                    <th style="border: 1px solid black; padding: 8px;">
                                                        {{ $marks ? ($marks->is_pr_absent ? 'A' : $marks->practical_mark) : '' }}
                                                    </th>
                                                @break

                                                @case($subject->type === 'is_theory')
                                                    <th style="border: 1px solid black; padding: 8px;">
                                                        {{ $marks ? ($marks->is_th_absent ? 'A' : $marks->theory_mark) : '' }}
                                                    </th>
                                                @break

                                                @case($subject->type === 'is_practical')
                                                    <th style="border: 1px solid black; padding: 8px;">
                                                        {{ $marks ? ($marks->is_pr_absent ? 'A' : $marks->practical_mark) : '' }}
                                                    </th>
                                                @break

                                                @default
                                            @endswitch
                                        @endforeach

                                        @php
                                            $percentage = number_format(
                                                ($totalObtainedMarks / $totalSubjectMarks) * 100,
                                                2,
                                            );
                                            $absentInAll = $absentSubjectCount === $totalSubjectCount;
                                        @endphp
                                        <th style="border: 1px solid black; padding: 4px;">
                                            {{ $totalObtainedMarks }}
                                        </th>
                                        <th style="border: 1px solid black; padding: 4px;">
                                            {{ $percentage }}%
                                        </th>
                                        <th style="border: 1px solid black; padding: 4px;">
                                            {{ $absentInAll ? 'Absent' : ($isFailed ? 'Fail' : 'Pass') }}
                                        </th>
                                        <th style="border: 1px solid black; padding: 4px;">
                                            {{ $isFailed ? '' : str_replace(' Division', '', check_division($percentage)) }}
                                        </th>
                                        <td style="border: 1px solid black; padding: 4px;">
                                            {{ $studentRanks[$student->id] ?? '' }}
                                        </td>
                                    </tr>
                                @endforeach

                                <tr>
                                    <th style="border: 1px solid black; padding: 8px; text-align: right;" colspan="3">Total
                                        Appeared</th>
                                    @foreach ($examSubjects as $examSubject)
                                        @php
                                            // NULL mark considered as not appeared
                                            $studentCountTh = $examMarks
                                                ->where('subject_id', $examSubject->subject_id)
                                                ->where('is_th_absent', false)
                                                ->whereNotNull('theory_mark')
                                                ->count();
                                            $studentCountPr = $examMarks
                                                ->where('subject_id', $examSubject->subject_id)
                                                ->where('is_pr_absent', false)
                                                ->whereNotNull('practical_mark')
                                                ->count();
                                        @endphp
                                        @if ($examSubject->subject->type != 'is_practical')
                                            <th style="border: 1px solid black; padding: 8px;">
                                                {{ $studentCountTh }}
                                            </th>
                                        @endif
                                        @if ($examSubject->subject->type != 'is_theory')
                                            <th style="border: 1px solid black; padding: 8px;">
                                                {{ $studentCountPr }}
                                            </th>
                                        @endif
                                    @endforeach

                                    <th style="border: 1px solid black; padding: 8px; background-color: lightgray"></th>
                                    <th style="border: 1px solid black; padding: 8px; background-color: lightgray"></th>
                                    <th style="border: 1px solid black; padding: 8px; background-color: lightgray"></th>
                                    <th style="border: 1px solid black; padding: 8px; background-color: lightgray"></th>
                                    <th style="border: 1px solid black; padding: 8px; background-color: lightgray"></th>
                                </tr>

                                <tr>
                                    <th style="border: 1px solid black; padding: 8px; text-align: right;" colspan="3">Total
                                        Passed</th>
                                    @foreach ($examSubjects as $examSubject)
                                        @php
                                            // NULL mark considered as not passed (when marks not entered)
                                            $totalPassedTh = $examMarks
                                                ->where('subject_id', $examSubject->subject_id)
                                                ->where(function ($examMark) use ($examSubject) {
                                                    return !$examMark->is_th_absent &&
                                                        !is_null($examMark->theory_mark) &&
                                                        isPassInSubject($examSubject, $examMark, 'theory');
                                                })
                                                ->count();
                                            $totalPassedPr = $examMarks
                                                ->where('subject_id', $examSubject->subject_id)
                                                ->where(function ($examMark) use ($examSubject) {
                                                    return !$examMark->is_pr_absent &&
                                                        !is_null($examMark->practical_mark) &&
                                                        isPassInSubject($examSubject, $examMark, 'practical');
                                                })
                                                ->count();
                                        @endphp
                                        @if ($examSubject->subject->type != 'is_practical')
                                            <th style="border: 1px solid black; padding: 8px;">
                                                {{ $totalPassedTh }}
                                            </th>
                                        @endif
                                        @if ($examSubject->subject->type != 'is_theory')
                                            <th style="border: 1px solid black; padding: 8px;">
                                                {{ $totalPassedPr }}
                                            </th>
                                        @endif
                                    @endforeach

                                    <th style="border: 1px solid black; padding: 8px; background-color: lightgray"></th>
                                    <th style="border: 1px solid black; padding: 8px; background-color: lightgray"></th>
                                    <th style="border: 1px solid black; padding: 8px; background-color: lightgray"></th>
                                    <th style="border: 1px solid black; padding: 8px; background-color: lightgray"></th>
                                    <th style="border: 1px solid black; padding: 8px; background-color: lightgray"></th>
                                </tr>

                                <tr>
                                    <th style="border: 1px solid black; padding: 8px; text-align: right;" colspan="3">Total
                                        Failed</th>
                                    @foreach ($examSubjects as $examSubject)
                                        @php
                                            // Null marks not counted in failed
                                            $totalFailedTh = $examMarks
                                                ->where('subject_id', $examSubject->subject_id)
                                                ->where('is_th_absent', false)
                                                ->whereNotNull('theory_mark')
                                                ->where(function ($examMark) use ($examSubject) {
                                                    return !isPassInSubject($examSubject, $examMark, 'theory');
                                                })
                                                ->count();
                                            $totalFailedPr = $examMarks
                                                ->where('subject_id', $examSubject->subject_id)
                                                ->where('is_pr_absent', false)
                                                ->whereNotNull('practical_mark')
                                                ->where(function ($examMark) use ($examSubject) {
                                                    return !isPassInSubject($examSubject, $examMark, 'practical');
                                                })
                                                ->count();
                                        @endphp
                                        @if ($examSubject->subject->type != 'is_practical')
                                            <th style="border: 1px solid black; padding: 8px;">
                                                {{ $totalFailedTh }}
                                            </th>
                                        @endif
                                        @if ($examSubject->subject->type != 'is_theory')
                                            <th style="border: 1px solid black; padding: 8px;">
                                                {{ $totalFailedPr }}
                                            </th>
                                        @endif
                                    @endforeach

                                    <th style="border: 1px solid black; padding: 8px; background-color: lightgray"></th>
                                    <th style="border: 1px solid black; padding: 8px; background-color: lightgray"></th>
                                    <th style="border: 1px solid black; padding: 8px; background-color: lightgray"></th>
                                    <th style="border: 1px solid black; padding: 8px; background-color: lightgray"></th>
                                    <th style="border: 1px solid black; padding: 8px; background-color: lightgray"></th>
                                </tr>

                                <tr>
                                    <th style="border: 1px solid black; padding: 8px; text-align: right;" colspan="3">Total
                                        Absent</th>
                                    @foreach ($examSubjects as $examSubject)
                                        @php
                                            $totalAbsentTh = $examMarks
                                                ->where('subject_id', $examSubject->subject_id)
                                                ->where('is_th_absent', true)
                                                ->count();
                                            $totalAbsentPr = $examMarks
                                                ->where('subject_id', $examSubject->subject_id)
                                                ->where('is_pr_absent', true)
                                                ->count();
                                        @endphp
                                        @if ($examSubject->subject->type != 'is_practical')
                                            <th style="border: 1px solid black; padding: 8px;">
                                                {{ $totalAbsentTh }}
                                            </th>
                                        @endif
                                        @if ($examSubject->subject->type != 'is_theory')
                                            <th style="border: 1px solid black; padding: 8px;">
                                                {{ $totalAbsentPr }}
                                            </th>
                                        @endif
                                    @endforeach

                                    <th style="border: 1px solid black; padding: 8px; background-color: lightgray"></th>
                                    <th style="border: 1px solid black; padding: 8px; background-color: lightgray"></th>
                                    <th style="border: 1px solid black; padding: 8px; background-color: lightgray"></th>
                                    <th style="border: 1px solid black; padding: 8px; background-color: lightgray"></th>
                                    <th style="border: 1px solid black; padding: 8px; background-color: lightgray"></th>
                                </tr>

                                <tr>
                                    <th style="border: 1px solid black; padding: 8px; text-align: right;" colspan="3">
                                        Highest Marks</th>

                                    @foreach ($examSubjects as $examSubject)
                                        @php
                                            $highestTotalMarksTh = $examMarks
                                                ->where('subject_id', $examSubject->subject_id)
                                                ->max('theory_mark');
                                            $highestTotalMarksPr = $examMarks
                                                ->where('subject_id', $examSubject->subject_id)
                                                ->max('practical_mark');
                                        @endphp
                                        @if ($examSubject->subject->type != 'is_practical')
                                            <th style="border: 1px solid black; padding: 8px;">
                                                {{ $highestTotalMarksTh }}
                                            </th>
                                        @endif
                                        @if ($examSubject->subject->type != 'is_theory')
                                            <th style="border: 1px solid black; padding: 8px;">
                                                {{ $highestTotalMarksPr }}
                                            </th>
                                        @endif
                                    @endforeach

                                    <th style="border: 1px solid black; padding: 8px; background-color: lightgray"></th>
                                    <th style="border: 1px solid black; padding: 8px; background-color: lightgray"></th>
                                    <th style="border: 1px solid black; padding: 8px; background-color: lightgray"></th>
                                    <th style="border: 1px solid black; padding: 8px; background-color: lightgray"></th>
                                    <th style="border: 1px solid black; padding: 8px; background-color: lightgray"></th>
                                </tr>

                                <tr>
                                    <th style="border: 1px solid black; padding: 8px; text-align: right;" colspan="3">
                                        Lowest Marks</th>
                                    @foreach ($examSubjects as $examSubject)
                                        @php
                                            $lowestTotalMarksTh = $examMarks
                                                ->where('subject_id', $examSubject->subject_id)
                                                ->where('is_th_absent', false)
                                                ->min('theory_mark');
                                            $lowestTotalMarksPr = $examMarks
                                                ->where('subject_id', $examSubject->subject_id)
                                                ->where('is_pr_absent', false)
                                                ->min('practical_mark');
                                        @endphp
                                        @if ($examSubject->subject->type != 'is_practical')
                                            <th style="border: 1px solid black; padding: 8px;">
                                                {{ $lowestTotalMarksTh }}
                                            </th>
                                        @endif
                                        @if ($examSubject->subject->type != 'is_theory')
                                            <th style="border: 1px solid black; padding: 8px;">
                                                {{ $lowestTotalMarksPr }}
                                            </th>
                                        @endif
                                    @endforeach

                                    <th style="border: 1px solid black; padding: 8px; background-color: lightgray"></th>
                                    <th style="border: 1px solid black; padding: 8px; background-color: lightgray"></th>
                                    <th style="border: 1px solid black; padding: 8px; background-color: lightgray"></th>
                                    <th style="border: 1px solid black; padding: 8px; background-color: lightgray"></th>
                                    <th style="border: 1px solid black; padding: 8px; background-color: lightgray"></th>
                                </tr>

                                <tr>
                                    <th style="border: 1px solid black; padding: 8px; text-align: right;" colspan="3">
                                        Average Marks</th>
                                    @foreach ($examSubjects as $examSubject)
                                        @php
                                            $averageTotalMarksTh = $examMarks
                                                ->where('subject_id', $examSubject->subject_id)
                                                ->where('is_th_absent', false)
                                                ->avg('theory_mark');
                                            $averageTotalMarksPr = $examMarks
                                                ->where('subject_id', $examSubject->subject_id)
                                                ->where('is_pr_absent', false)
                                                ->avg('practical_mark');
                                        @endphp
                                        @if ($examSubject->subject->type != 'is_practical')
                                            <th style="border: 1px solid black; padding: 8px;">
                                                {{ number_format($averageTotalMarksTh, 2) }}
                                            </th>
                                        @endif
                                        @if ($examSubject->subject->type != 'is_theory')
                                            <th style="border: 1px solid black; padding: 8px;">
                                                {{ number_format($averageTotalMarksPr, 2) }}
                                            </th>
                                        @endif
                                    @endforeach

                                    <th style="border: 1px solid black; padding: 8px; background-color: lightgray"></th>
                                    <th style="border: 1px solid black; padding: 8px; background-color: lightgray"></th>
                                    <th style="border: 1px solid black; padding: 8px; background-color: lightgray"></th>
                                    <th style="border: 1px solid black; padding: 8px; background-color: lightgray"></th>
                                    <th style="border: 1px solid black; padding: 8px; background-color: lightgray"></th>
                                </tr>

                                <tr>
                                    <td colspan="4" style="padding-top: 2rem; text-align: center;">
                                        <span>------------------------</span> <br />
                                        <span>Checked By</span>
                                    </td>

                                    <td colspan="4" style="padding-top: 2rem; text-align: center;">
                                        <span>------------------------</span> <br />
                                        <span>Verified By</span>
                                    </td>
                                    <td colspan="4" style="padding-top: 2rem; text-align: center;">Date:
                                        {{ getTodaySystemDate() }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            @endisset
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(function() {
            $('#year_semester_id').change(async function() {
                const yearSemesterId = $(this).val();
                const targetSelect = $('#exam_id');
                showSelectLoader(targetSelect);

                const options = await getExamOptionsByYearSemesterId(yearSemesterId);
                targetSelect.html(options);

                hideSelectLoader(targetSelect);

                // to change select options for section(group) 
                const targetSelectForSection = $('#section_id');
                showSelectLoader(targetSelectForSection);

                const optionsforSection = await getSectionOptionsByYearSemesterId(yearSemesterId);
                targetSelectForSection.html(optionsforSection);

                hideSelectLoader(targetSelectForSection);
            });

            $('.form').validate({
                errorPlacement: function(e, a) {
                    return true
                }
            });
        });
    </script>
@endsection
