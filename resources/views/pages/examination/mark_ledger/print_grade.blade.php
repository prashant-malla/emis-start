@php
    $grades = App\Models\ExamGrade::where('exam_type_id', $exam->exam_type_id)->get();
    $creditHourLabel = getCreditHourLabel($exam->program->type);
@endphp
@include('common.grade')
<style type="text/css">
    @page{
        size: A4 portrait;
        margin: 0;
    }

    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box
    }

    .main-wrapper{
        font-family: Helvetica Neue,Helvetica,Arial,sans-serif;
    }

    .marksheet{
        page-break-after: always;
        width: 210mm;
        height: 296mm;
        padding: 15mm;
    }
    .clear{
        clear:both;
    }
    .full-slogan{
        width: 100%;
        text-align: center;
        font-style: italic;
        font-size: 12px;
    }
    .header-group{
        width: 100%;
        padding: 0px 5px;
        height: 100px;
    }
    .logo{
        width: 130px;
        float: left;
    }
    .logo img{
        height: 70px;
    }
    .box-name{
        width: 220px;
        float: left;
        height: 30px;
        text-align: center;
        margin-left: 118px;
    }
    .box-name h2{
        margin: 0px 0px 5px;
        font-size: 20px;
        text-transform: uppercase;
    }
    .address{
        font-size: 12px;
        margin: 0px;
    }
    .contact{
        font-size: 12px;
        margin: 5px 0px 0px;
    }
    .box-text{
        border:1px solid #0000FF;
        border-radius: 5px;
        background: #A52A2A;
        color: #fff;
        font-size: 15px;
        padding: 3px;
        width: 150px;
        margin: 10px auto 0;
    }
    .student-details{
        width: 100%;
    }
    table{
        font-size: 14px;

    }
    table.table{
        width: 100%;
        font-size: 14px;
        line-height: 20px;
    }
    td.right-house{
        float: right;
    }
    table.table-one{
        text-align: center;
        width: 100%;
        border:1px solid #00000052;
        font-size: 14px;

    }
    table.table-two{
        border-collapse: collapse;
        width: 100%;
        border:1px solid #00000052;
        margin-top: 5px;
    }
    .table-two td{
        border: 1px solid #00000052;
        padding: 3px;
        border-bottom: none !important;
        border-top: none !important;
        font-size: 14px;

    }
    .total-right td{
        text-align: right;
    }
    table.table-three{
        text-align: center;
        margin-top: 5px;
        width: 100%;
        border:1px solid #00000052;
        border-collapse: collapse;
        font-size: 14px;
        line-height: 20px;

    }
    table.table-three td{
        border:1px solid #00000052;
    }
    table.table-four{
        width: 100%;
        text-align: center;
        margin-top: 5px;
        border:1px solid black;
        border-collapse: collapse;
        font-size: 14px;
        line-height: 17px;

    }
    table.table-four td{
        border:1px solid  #00000052;
    }
    table.one-gray{
        margin-top: 5px;
        border-collapse: collapse;
        width: 100%;
    }
    table.one-gray td{
        text-align: left;
        border:1px solid #00000052;
        font-size: 14px;
        line-height: 30px;
    }
    td.padding {
    }
    table.table-five{
        width: 100%;
        text-align: center;
        margin-top: 65px;
        border:1px solid  #00000052;
        border-collapse: collapse;
        line-height: 15px;
    }
    table.table-five td{
        border:1px solid  #00000052;
    }
    td.padding-btm{
        padding: 3px;
    }
    .thery{
        border-right: 1px solid #000;
        width: 50%;
        display: block;
        float: left;
    }
    .footer{
        margin-top:40px;
        font-size: 12px;
    }
    .table-three{
        font-size:9px;
    }
    .table-four{
        font-size:12px;
    }    
    @media print{
        body>*:not(.main-wrapper){
            display: none
        }
    }
</style>
<div class="main-wrapper">
    @foreach($student_ids as $student_id)
        <div class="marksheet">
            @php
                $student = App\Models\Student::where('id',$student_id)->first();
            @endphp
            <div class="header">
                <div class="full-slogan">
                    <p style="margin-left:15px;margin-bottom:0px;">"{{ $school->slogan }}"</p>
                </div>
                <div class="header-group">
                    <div class="logo">
                        <img src="{{ asset('files/'.$school->logo) }}">
                    </div>
                    <div class="box-name">
                        <h2>{{ $school->name }}</h2>
                        <p class="address">{{ $school->address }}</p>
                        <p class="contact">Contact:{{ $school->phone_number }}</p>
                        <p class="box-text">GRADE SHEET</p>
                    </div>
                </div>
                <div  class="student-details clear">
                    <table class="table">
                        <tr>
                            <td><b>Name:</b> {{ $student->sname }}</td>
                        </tr>
                    </table>
                    <table class="table">
                        <tr>
                            <td><b>Level:</b> {{ $student->level->name }}</td>
                            <td><b>Program:</b> {{ $student->program->name }}</td>
                            <td>
                                <b>{{$student->yearSemester->type === 'year' ? 'Year' : 'Semester'}}:</b> 
                                {{ $student->yearSemester->name }} ({{$student->section->group_name}})
                            </td>
                            <td class="right-house"><b>Roll No:</b> {{ $student->roll }}</td>
                        </tr>
                    </table>
                    <div class="first-term">
                        <table class="table-one">
                            <tr>
                                <td><b>{{ $exam->name }}</b></td>
                            </tr>
                        </table>
                        <table class="table-two">
                            <thead style="border-bottom: 1px solid #00000052;font-weight:bold;">
                            <tr>
                                <td>S.N</td>
                                <td>Subjects</td>
                                <td width="110">{{$creditHourLabel}}</td>
                                <td>
                                    <p style="text-align: center;margin: 0px;">Obtained Grade</p>
                                    <p style="margin:4px 0px 0px 0px;font-size: 12px;"><b>TH</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b style="float:right;">PR</b></p>
                                </td>
                                <td>Final Grade</td>
                                <td>Grade Point</td>
                            </tr>
                            </thead>
                            <tbody style="font-size: 10px;">
                            @php
                                $total_marks = 0;
                                $total_grade_point = 0;
                                $marks = App\Models\ExamMark::where('exam_id', $exam->id)->where('student_id', $student->id)->get()->groupBy('subject_id');
                            @endphp
                            @foreach($examSubjects as $examSubject)
                                @php
                                    $subject = $examSubject->subject;
                                    $mark = isset($marks[$subject->id]) ? $marks[$subject->id]->first() : null;
                                @endphp                                
                                @if($mark)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $subject->name }}</td>
                                    <td>{{ $subject->credit_hour }}</td>
                                    <td>
                                        @if($subject->type == 'is_theory')
                                            @php
                                                $marks_obtained = $mark->theory_mark / 100 * 100;
                                                $grade = getGrade($marks_obtained, $grades);
                                                echo  '<b class="theory" style="">'.($grade ? $grade['grade_name'] : '').'</b>';
                                                echo ' <b style="float:right;"></b>';
                                                $total_marks += $marks_obtained;
                                            @endphp
                                        @else
                                            @php
                                                $theory = $mark->theory_mark / $subject->theory_full_marks * 100;
                                                $grade = getGrade($theory, $grades);
                                                echo  '<b class="theory"style="">'.($grade ? $grade['grade_name'] : '').'</b>';
                                                $practical = $mark->practical_mark  / $subject->practical_full_marks * 100;
                                                $grade = getGrade($practical, $grades);
                                                echo '<b style="float:right;">'.($grade ? $grade['grade_name'] : '').'</b>';
                                                $mark_t_p = $mark->theory_mark + $mark->practical_mark / 100 * 100 ;
                                                $total_marks += $mark_t_p;
                                            @endphp
                                        @endif
                                    </td>
                                    <td>
                                        @if($subject->type == 'is_theory')
                                            @php
                                                $marks_obtained = $mark->theory_mark / 100 * 100;
                                                $grade = getGrade($marks_obtained, $grades);
                                                echo ($grade ? $grade['grade_name'] : '');
                                                $total_grade_point += $grade ? $grade['grade_point']: 0;
                                            @endphp
                                        @else
                                            @php
                                                $theory = $mark->theory_mark  / 100 * 100;
                                                $practical = $mark->practical_mark  /  100 * 100;
                                                $mark_t_p = $theory + $practical / 100 * 100;
                                                $grade = getGrade($mark_t_p, $grades);
                                                echo ($grade ? $grade['grade_name'] : '');
                                                $total_grade_point += $grade ? $grade['grade_point']: 0;
                                            @endphp
                                        @endif
                                    </td>
                                    <td>
                                        @if($subject->type == 'is_theory')
                                            @php
                                                $marks_obtained = $mark->theory_mark / $subject->theory_full_marks * 100;
                                                $grade = getGrade($marks_obtained, $grades);
                                                echo $grade ? $grade['grade_point']: 0;
                                            @endphp
                                        @else
                                            @php
                                                $theory = $mark->theory_mark  / 100 * 100;
                                                $practical = $mark->practical_mark  /  100 * 100;
                                                $mark_t_p = $theory + $practical / 100 * 100;
                                                $mark_t_p = $theory + $practical ;
                                                $grade = getGrade($mark_t_p, $grades);
                                                echo $grade ? $grade['grade_point']: 0;
                                            @endphp
                                        @endif
                                    </td>
                                </tr>
                                @else
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $subject->name }}</td>
                                    <td>{{ $subject->credit_hour }}</td>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                    <td>0</td>
                                </tr>
                                @endif
                            @endforeach
                            <tr class="total-right" style="border-top: 1px solid #00000052; line-height: 20px;">
                                <td colspan="3" style="text-align: left;"><b> GRADE:
                                    @php
                                        $grade = getGradeFromGradePoint(round($total_grade_point/count($examSubjects),2), $grades);
                                        echo $grade ? $grade['grade_name'] : '';
                                    @endphp
                                    </b>
                                </td>
                                <td colspan="3" style="text-align: right;"><b> GPA:
                                        {{ round($total_grade_point/count($examSubjects),2) }}
                                    </b>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <table class="table-four">
                            <tr>
                                <td colspan="4"><b>Grading System</b></td>
                            </tr>
                            <tr>
                                <td><b>Percent</b></td>
                                <td><b>Grade</b></td>
                                <td><b>Grade Point</b></td>
                            </tr>
                            @foreach($grades as $row)
                                <tr>
                                    <td style="text-align: left;"><?php echo $row['percentage_from'] ?>% to <?php echo $row['percentage_to'] ?>%</td>
                                    <td><?php echo $row['grade_name'] ?></td>
                                    <td><?php echo $row['grade_point'] ?></td>
                                </tr>
                            @endforeach
                        </table>
                        <table class="one-gray">
                            <tr >
                                <td  colspan="3"><b>Remarks:
                                    @php
                                        $grade = getGradeFromGradePoint(round($total_grade_point/count($examSubjects),2), $grades);
                                        echo $grade ? $grade['remarks'] : '';
                                    @endphp
                                    </b>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="content-main">
                </div>
                <!-- content end -->

                <div class="footer">
                    <table class="table-five">
                        <tr>
                            <td class="padding-btm"><b>Class Teacher</b></td>
                            <td class="padding-btm"><b>Exam Coordinator</b></td>
                            <td class="padding-btm"><b>School Seal<br> Date:{{ $exam->result_date }}</b></td>
                            <td class="padding-btm"><b>Principal</b></td>
                        </tr>
                    </table>
                </div>
            </div>
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
