<div class="mb-3 p-4 table-responsive" style="background-color: #dcd9ea; border-radius: 10px">
    <table class="table table-bordered mb-0">
        <tr>
            <th>Program</th>
            <th>Batch</th>
            <th>Year/Semester</th>
            <th>Fee Type</th>
            <th>Submission Type</th>
            {{-- <th>Fee Group</th> --}}
            <th>Amount</th>
            <th>Due Date</th>
            <th>Fine Type</th>
        </tr>
        <tr>
            <td>{{ $feeMaster->yearSemester->program->name }}</td>
            <td>{{ $feeMaster->yearSemester->batch->title }}</td>
            <td>{{ $feeMaster->yearSemester->name }}</td>
            <td>{{ $feeMaster->fee_type->name }}</td>
            <td>{{ $feeMaster->fee_type->submission_type }}</td>
            {{-- <td>{{$feeMaster->fee_title->name}}</td> --}}
            <td>{{ $feeMaster->amount }}</td>
            <td>{{ $feeMaster->due_date }}</td>
            <td>{{ $feeMaster->fine_type }}
                @if ($feeMaster->fine_amount)
                    ({{ $feeMaster->fine_amount }})
                @elseif($feeMaster->percentage)
                    ({{ $feeMaster->percentage }}%)
                @endif
            </td>
        </tr>
    </table>
</div>
