<table id="resultTable" class="table table-bordered">
    <thead class="bg-primary text-white">
        <tr>
            <th rowspan="2">Subjects</th>
            <th colspan="2">Full Mark</th>
            <th colspan="2">Pass Mark</th>
            <th colspan="2">Obtained Mark</th>
        </tr>
        <tr>
            <th>Th</th>
            <th>Pr</th>
            <th>Th</th>
            <th>Pr</th>
            <th>Th</th>
            <th>Pr</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($examSubjects as $examSubject)
            @php($marks = $examMarks->where('subject_id', $examSubject->subject_id)->first())
            <tr>
                <td>{{ $examSubject->subject->name }}</td>
                <td>{{ $examSubject->subject->theory_full_marks }}</td>
                <td>{{ $examSubject->subject->type != 'is_theory' ? $examSubject->subject->practical_full_marks : '' }}
                </td>
                <td>{{ $examSubject->subject->theory_pass_marks }}</td>
                <td>{{ $examSubject->subject->type != 'is_theory' ? $examSubject->subject->practical_pass_marks : '' }}
                </td>
                <td>{{ $marks?->is_th_absent ? 'A' : $marks?->theory_mark }}</td>
                <td>{{ $examSubject->subject->type != 'is_theory' ? $marks?->practical_mark : '' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
