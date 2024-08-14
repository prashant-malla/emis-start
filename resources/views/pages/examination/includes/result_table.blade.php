<table id="resultTable" class="table table-bordered">
    <thead class="bg-primary text-white">
        <tr>
            @if ($isSuperAdmin)
                <th rowspan="2" width="60" class="text-center">
                    <input type="checkbox" id="checkAll">
                </th>
            @endif
            <th rowspan="2">Student</th>
            <th rowspan="2">Roll No.</th>
            @foreach ($examSubjects as $examSubject)
                @php
                    $rowspan = $examSubject->subject->type == 'is_theory' ? 2 : 1;
                    $colspan = $examSubject->subject->type == 'is_theory' ? 1 : 2;
                @endphp
                <th class="text-center" rowspan="{{ $rowspan }}" colspan="{{ $colspan }}">
                    {{ $examSubject->subject->name }} <br />
                    ({{ $examSubject->subject->code }})
                    @if ($examSubject->subject->type == 'is_theory')
                        <br />
                        ({{ $examSubject->theory_full_marks . '/' . $examSubject->theory_pass_marks }})
                    @endif
                </th>
            @endforeach
            @if ($isSuperAdmin)
                <th width="50" rowspan="2"></th>
            @endif
        </tr>
        <tr>
            @foreach ($examSubjects as $examSubject)
                @if ($examSubject->subject->type != 'is_theory')
                    <th class="text-center">
                        Th<br />
                        ({{ $examSubject->theory_full_marks . '/' . $examSubject->theory_pass_marks }})
                    </th>
                    <th class="text-center">
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
                $studentEnrollment = $student->getEnrollment($exam->year_semester_id);
            @endphp
            <tr>
                @if ($isSuperAdmin)
                    <td class="text-center">
                        <input type="checkbox" name="student_id[]" value="{{ $student->id }}">
                    </td>
                @endif
                <td>
                    <div>
                        <a href="{{ route('student.show', $student->id) }}" class="text-primary"
                            target="_blank">{{ $student->sname }}</a>
                    </div>
                    <div>
                        ({{ $student->admission }})
                    </div>
                </td>
                <td>{{ $studentEnrollment?->roll }}</td>
                @foreach ($examSubjects as $examSubject)
                    @php($marks = $studentExamMarks?->where('subject_id', $examSubject->subject_id)->first())
                    @if ($examSubject->subject->type != 'is_theory')
                        <td class="text-center">{{ $marks?->is_th_absent ? 'A' : $marks?->theory_mark }}</td>
                        <td class="text-center">{{ $marks?->is_pr_absent ? 'A' : $marks?->practical_mark }}</td>
                    @else
                        <td class="text-center">{{ $marks?->is_th_absent ? 'A' : $marks?->theory_mark }}</td>
                    @endif
                @endforeach
                @if ($isSuperAdmin)
                    <td>
                        <a href="{{ route('exam_result.marksheet', ['exam' => $exam_id, 'student' => $student->id]) }}"
                            target="_blank" class="btn btn-sm btn-primary m-1" title="Print Marksheet"
                            data-toggle="tooltip">
                            <i class="material-icons">print</i>
                        </a>
                    </td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>
