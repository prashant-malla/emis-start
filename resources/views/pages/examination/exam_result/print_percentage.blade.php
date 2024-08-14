@php
    $percentages = App\Models\ExamGrade::where('exam_type_id', $exam->exam_type_id)->get();
    $creditHourLabel = getCreditHourLabel($exam->program->type);
@endphp
@include('common.grade')
<style type="text/css">
    @page {
        size: A4 portrait;
        margin: 0;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        line-height: 1.5;
        font-size: 14px;
    }

    .main-wrapper {
        font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
    }

    .marksheet {
        page-break-after: always;
        width: 210mm;
        height: 296mm;
        padding: 15mm;
    }

    .clear {
        clear: both;
    }

    .full-slogan {
        width: 100%;
        text-align: center;
        font-style: italic;
        font-size: 12px;
    }

    .header-group {
        width: 100%;
        padding: 0px 5px;
        height: 100px;
        position: relative;
    }

    .logo {
        width: 130px;
        position: absolute;
        top: 0;
        left: 0;
    }

    .logo img {
        height: 70px;
    }

    .box-name {
        height: 30px;
        text-align: center;
    }

    .box-name h2 {
        margin: 0px 0px 5px;
        font-size: 20px;
        text-transform: uppercase;
    }

    .address {
        font-size: 12px;
        margin: 0px;
        text-transform: uppercase
    }

    .contact {
        font-size: 12px;
        margin: 5px 0px 0px;
    }

    .box-text {
        border: 1px solid #0000FF;
        border-radius: 5px;
        background: #A52A2A;
        color: #fff;
        font-size: 15px;
        padding: 3px;
        width: 150px;
        margin: 10px auto 0;
    }

    .student-details {
        width: 100%;
    }

    table {
        font-size: 14px;
    }

    table.table {
        width: 100%;
        font-size: 14px;
        line-height: 20px;
    }

    table.table-two {
        border-collapse: collapse;
        width: 100%;
        border: 1px solid #00000052;
        margin-top: 5px;
    }

    .table-two td {
        border: 1px solid #00000052;
        padding: 3px;
        border-bottom: none !important;
        border-top: none !important;
        font-size: 14px;

    }

    .total-right td {
        text-align: right;
    }

    .thery {
        border-right: 1px solid #000;
        width: 50%;
        display: block;
        float: left;
    }
</style>
<div class="main-wrapper">
    @foreach ($student_ids as $student_id)
        @php
            $isPracticalFailed = false;
            $isTheoryFailed = false;
            $student = App\Models\Student::where('id', $student_id)->first();
            $studentEnrollment = $student->getEnrollment($exam->year_semester_id);
        @endphp
        <div class="marksheet">
            <div class="header">
                {{-- <div class="full-slogan">
                    <p style="margin-left:15px;margin-bottom:0px;">"{{ $school->slogan }}"</p>
                </div> --}}

                <div style="display: block; text-align: center;">
                    AFFILIATED TO TRIBHUVAN UNIVERSITY
                </div>

                <div class="header-group">
                    <div class="logo">
                        <img src="{{ asset($school->logo_url) }}">
                    </div>

                    <div class="box-name">
                        <h2>{{ $school->name }}</h2>
                        <p class="address">{{ $school->address }}</p>
                    </div>
                </div>

                <div style="text-align: center; margin-bottom: 1rem;">
                    <p><b>{{ $exam->name }}</b></p>
                    <P>ACADEMIC MARKSHEET</P>
                </div>
            </div>

            <div class="student-details clear">
                <table class="table">
                    <tr>
                        <td><b>STUDENT'S NAME: </b> {{ $student->sname }}</td>
                        <td><b>UNIVERSITY REGD. NO: </b> {{ $student->admission }}</td>
                    </tr>

                    <tr>
                        {{-- <td><b>FACULTY:</b> Science</td> --}}
                        <td><b>CAMPUS ROLL NO.: {{ $studentEnrollment?->roll }}</b></td>
                        <td><b>PROGRAMME:</b> {{ $student->program->name }}</td>
                    </tr>

                    <tr>
                        {{-- <td><b>PROGRAMME:</b> {{ $student->program->name }}</td> --}}
                        {{-- TODO::IMPLEMENT SYMBOL NO --}}
                        {{-- <td><b>SYMBOL NO.:</b> </td> --}}
                    </tr>

                    <tr>
                        <td>
                            <b>LEVEL: </b> {{ $student->level->name }}
                        </td>
                        <td>
                            <b>YEAR/SEMESTER: </b> {{ $exam->yearSemester->name }}
                        </td>
                    </tr>

                    {{-- <tr>
                        <td colspan="2">
                            <b>YEAR/SEMESTER: </b> {{ $student->yearSemester->name }}
                        </td>
                    </tr> --}}

                    <tr>
                        <td colspan="2">
                            <b>GROUP: </b> {{ $studentEnrollment?->section->group_name }}
                        </td>
                    </tr>
                </table>
            </div>

            <div class="content-main">
                <div class="first-term" style="margin-top: 1rem;">
                    <table style="border-collapse: collapse; width: 100%;">
                        <tr>
                            <th style="border: 1.5px solid #1f1e1e52; padding: 4px; width: 5%;" rowspan="2"
                                colspan="1">S.N.</th>
                            <th style="border: 1.5px solid #00000052; padding: 4px;" rowspan="2" colspan="1">
                                SUBJECT CODE</th>
                            <th style="border: 1.5px solid #00000052; padding: 4px;" rowspan="2" colspan="1">
                                SUBJECT NAME</th>
                            <th style="border: 1.5px solid #00000052; padding: 4px;" colspan="2">FULL MARKS</th>
                            <th style="border: 1.5px solid #00000052; padding: 4px;" colspan="2">PASS MARKS</th>
                            <th style="border: 1.5px solid #00000052; padding: 4px;" colspan="3">MARK OBTAINED</th>
                            <th style="border: 1.5px solid #00000052; padding: 4px;" rowspan="2" colspan="2">
                                REMARKS</th>
                        </tr>

                        <tr>
                            <td
                                style="border: 1.5px solid #1f1e1e52; padding: 4px; font-size: 12px; text-align: center;">
                                <b>TH</b>
                            </td>

                            <td
                                style="border: 1.5px solid #1f1e1e52; padding: 4px; font-size: 12px; text-align: center;">
                                <b>PR</b>
                            </td>

                            <td
                                style="border: 1.5px solid #1f1e1e52; padding: 4px; font-size: 12px; text-align: center;">
                                <b>TH</b>
                            </td>

                            <td
                                style="border: 1.5px solid #1f1e1e52; padding: 4px; font-size: 12px; text-align: center;">
                                <b>PR</b>
                            </td>

                            <td
                                style="border: 1.5px solid #1f1e1e52; padding: 4px; font-size: 12px; text-align: center;">
                                <b>TH</b>
                            </td>

                            <td
                                style="border: 1.5px solid #1f1e1e52; padding: 4px; font-size: 12px; text-align: center;">
                                <b>PR</b>
                            </td>

                            <td
                                style="border: 1.5px solid #1f1e1e52; padding: 4px; font-size: 12px; text-align: center;">
                                <b>TOTAL</b>
                            </td>
                        </tr>

                        @php
                            $total_marks = 0;
                            $marks = App\Models\ExamMark::where('exam_id', $exam->id)
                                ->where('student_id', $student->id)
                                ->get()
                                ->groupBy('subject_id');

                            $studentExamSubjects = $examSubjects->filter(function ($examSubject) use ($student) {
                                return !$examSubject->subject->is_optional ||
                                    ($examSubject->subject->is_optional &&
                                        $student->optionalSubjects->contains($examSubject->subject->id));
                            });
                            $totalSubjectFullMarks = $studentExamSubjects->sum(function ($examSubject) {
                                return getMark($examSubject->theory_full_marks) +
                                    getMark($examSubject->practical_full_marks);
                            });
                        @endphp

                        @foreach ($studentExamSubjects as $examSubject)
                            @php
                                $subject = $examSubject->subject;
                                $mark = isset($marks[$subject->id]) ? $marks[$subject->id]->first() : null;
                            @endphp

                            @if ($mark)
                                <tr>
                                    <td style="border: 1.5px solid #00000052; padding: 4px;">{{ $loop->index + 1 }}
                                    </td>
                                    <td style="border: 1.5px solid #00000052; padding: 4px;">{{ $subject->code }}</td>
                                    <td style="border: 1.5px solid #00000052; padding: 4px;">{{ $subject->name }}</td>
                                    <td style="border: 1.5px solid #00000052; padding: 4px;">
                                        @if ($subject->type !== 'is_practical')
                                            <b>{{ $examSubject->theory_full_marks }}</b>
                                        @endif
                                    </td>

                                    <td style="border: 1.5px solid #00000052; padding: 4px;">
                                        @if ($subject->type !== 'is_theory')
                                            <b style="float:right;">{{ $examSubject->practical_full_marks }}</b>
                                        @endif
                                    </td>

                                    <td style="border: 1.5px solid #00000052; padding: 4px;">
                                        @if ($subject->type !== 'is_practical')
                                            <b>{{ $examSubject->theory_pass_marks }}</b>
                                        @endif
                                    </td>

                                    <td style="border: 1.5px solid #00000052; padding: 4px;">
                                        @if ($subject->type !== 'is_theory')
                                            <b style="float:right;">{{ $examSubject->practical_pass_marks }}</b>
                                        @endif
                                    </td>

                                    <td style="border: 1.5px solid #00000052; padding: 4px;">
                                        @if (!is_null($mark->theory_mark))
                                            @php
                                                $thFailed = $mark->theory_mark < $examSubject->theory_pass_marks;
                                                if (!$isTheoryFailed) {
                                                    $isTheoryFailed = $thFailed;
                                                }
                                            @endphp

                                            <b style="float: left;">
                                                {{ !$thFailed ? $mark->theory_mark : $mark->theory_mark . '*' }}
                                            </b>
                                        @endif
                                    </td>

                                    <td style="border: 1.5px solid #00000052; padding: 4px;">
                                        @if (!is_null($mark->practical_mark))
                                            @php
                                                $prFailed = $mark->practical_mark < $examSubject->practical_pass_marks;
                                                if (!$isPracticalFailed) {
                                                    $isPracticalFailed = $prFailed;
                                                }
                                            @endphp

                                            <b>
                                                {{ !$prFailed ? $mark->practical_mark : $mark->practical_mark . '*' }}
                                            </b>
                                        @endif
                                    </td>

                                    <td style="border: 1.5px solid #00000052; padding: 4px;">
                                        <b style="float: right;">
                                            @php
                                                $obtainedSubjectMark = 0;

                                                // Handled invalid data where marks exists even if th_absent or pr_absent
                                                // Better to handle it within mark entry validation
                                                if ($subject->type !== 'is_practical' && !$mark->is_th_absent) {
                                                    $obtainedSubjectMark += getMark($mark->theory_mark);
                                                }

                                                if ($subject->type !== 'is_theory' && !$mark->is_pr_absent) {
                                                    $obtainedSubjectMark += getMark($mark->practical_mark);
                                                }

                                                $total_marks += $obtainedSubjectMark;

                                                $percentage = number_format(
                                                    ($total_marks * 100) / $totalSubjectFullMarks,
                                                    2,
                                                );
                                            @endphp

                                            {!! $mark->is_th_absent || $mark->is_pr_absent ? '<b>A</b>' : $obtainedSubjectMark !!}
                                        </b>
                                    </td>

                                    <td style="border: 1.5px solid #00000052; padding: 4px;">
                                        {{ $exam->attempt ? str_repeat('*', $exam->attempt) : '' }}
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td style="border: 1.5px solid #00000052; padding: 4px;">{{ $loop->index + 1 }}
                                    </td>
                                    <td style="border: 1.5px solid #00000052; padding: 4px;">{{ $subject->code }}</td>
                                    <td style="border: 1.5px solid #00000052; padding: 4px;">{{ $subject->name }}</td>
                                    <td style="border: 1.5px solid #00000052; padding: 4px;">
                                        @if ($subject->type !== 'is_practical')
                                            <b>{{ $examSubject->theory_full_marks }}</b>
                                        @endif
                                    </td>

                                    <td style="border: 1.5px solid #00000052; padding: 4px;">
                                        @if ($subject->type !== 'is_theory')
                                            <b style="float:right;">{{ $examSubject->practical_full_marks }}</b>
                                        @endif
                                    </td>

                                    <td style="border: 1.5px solid #00000052; padding: 4px;">
                                        @if ($subject->type !== 'is_practical')
                                            <b>{{ $examSubject->theory_pass_marks }}</b>
                                        @endif
                                    </td>

                                    <td style="border: 1.5px solid #00000052; padding: 4px;">
                                        @if ($subject->type !== 'is_theory')
                                            <b style="float:right;">{{ $examSubject->practical_pass_marks }}</b>
                                        @endif
                                    </td>
                                    <td style="border: 1.5px solid #00000052; padding: 4px;"></td>
                                    <td style="border: 1.5px solid #00000052; padding: 4px;"></td>
                                    <td style="border: 1.5px solid #00000052; padding: 4px;"></td>
                                    <td style="border: 1.5px solid #00000052; padding: 4px;"></td>
                                </tr>
                            @endif
                        @endforeach

                        @php
                            $absentCount = 0;

                            foreach ($marks as $subject => $items) {
                                foreach ($items as $item) {
                                    if ($item['is_th_absent'] == 1 || $item['is_pr_absent'] == 1) {
                                        // $isAbsent = true;
                                        $absentCount++;
                                        // break 2; // Break both loops once a match is found
                                    }
                                }
                            }

                            $isAbsent = $absentCount > 0;
                            $absentInAll = $absentCount == $studentExamSubjects->count();
                        @endphp

                        <tr class="total-right" style="border-top: 1px solid #00000052; line-height: 20px;">
                            <td colspan="7" style="border: 1.5px solid #00000052; padding: 4px;">
                                <b>
                                    TOTAL MARKS:
                                </b>
                            </td>

                            <td style="text-align: center; border: 1.5px solid #00000052; padding: 4px;" colspan="5">
                                <b>
                                    {{ $total_marks }}
                                </b>
                            </td>
                        </tr>

                        <tr class="total-right">
                            <td colspan="7" style="border: 1.5px solid #00000052; padding: 4px;">
                                <b>
                                    PERCENTAGE:
                                </b>
                            </td>

                            <td style="border: 1.5px solid #00000052; padding: 4px; text-align: center;" colspan="5">
                                @if ($exam->attempt === 0)
                                    <b>
                                        {{ $percentage }} %
                                    </b>
                                @endif
                            </td>
                        </tr>

                        <tr class="total-right" style="border-top: 1px solid #00000052; line-height: 20px;">
                            <td colspan="7" style="border: 1.5px solid #00000052; padding: 4px;">
                                <b>
                                    DIVISION:
                                </b>
                            </td>

                            <td style="border: 1.5px solid #00000052; padding: 4px; text-align: center;" colspan="5">
                                @if ($exam->attempt === 0)
                                    <b>
                                        {{ $isAbsent || $isPracticalFailed || $isTheoryFailed ? '' : check_division($percentage) }}
                                    </b>
                                @endif
                            </td>
                        </tr>

                        <tr class="total-right" style="border-top: 1px solid #00000052; line-height: 20px;">
                            <td colspan="7" style="border: 1.5px solid #00000052; padding: 4px;">
                                <b>
                                    RESULT:
                                </b>
                            </td>

                            <td style="border: 1.5px solid #00000052; padding: 4px; text-align: center;" colspan="5">
                                <b>
                                    @switch(true)
                                        @case($absentInAll)
                                            Absent
                                        @break

                                        @case($isAbsent && !$isTheoryFailed && !$isPracticalFailed)
                                            Passed Absent
                                        @break

                                        @case($isAbsent && ($isTheoryFailed || $isPracticalFailed))
                                            Failed Absent
                                        @break

                                        @case(!$isAbsent && ($isTheoryFailed || $isPracticalFailed))
                                            Failed
                                        @break

                                        @default
                                            Passed
                                    @endswitch
                                </b>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <!-- content end -->

            <table width="100%" style="margin-top: 4rem;">
                <tr>
                    <td>........................</td>
                    <td>........................</td>
                    <td></td>
                </tr>

                <tr>
                    <td>Checked By</td>
                    <td>Verified By</td>
                    <td>Date of Issue:</td>
                </tr>
            </table>
        </div>
    @endforeach
</div>
<script type="text/javascript">
    window.addEventListener('load', () => {
        window.print();
    });

    window.addEventListener("afterprint", (event) => {
        window.close();
    });
</script>
