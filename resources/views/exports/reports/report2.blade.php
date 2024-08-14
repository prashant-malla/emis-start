<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Report 2</title>
</head>
<body>
    <table style="text-align: center;">
        <tr>
            <th rowspan="2" colspan="11" align="center" style="text-align: center; vertical-align: middle; font-weight: bold; font-size: 18px;">
                @if($schoolLogo)
                    <img src="{{ $schoolLogo }}" width="70" alt="School Logo">
                @endif
                <h1>{{ $settings->name }}</h1>
            </th>
        </tr>
    </table>

    <table id="example3" class="display" style="min-width: 845px; border: 1px solid #808080;">
        <caption>
            {{ $title }}
        </caption>
        <col>
        <col>
        <col>
        <colgroup span="8"></colgroup>

        <thead>
            <tr>
                <th colspan="4">
                    <h2><b>{{ $title }}</b></h2>
                </th>
            </tr>

            <tr></tr>

            <tr>
                <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Level</th>
                <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Academic Programs</th>
                <th colspan="9" scope="colgroup" style="border: 1px solid #808080; font-weight: bold;">Year/ Semester Wise No. of Student (Enrollment)</th>
            </tr>

            <tr>
                <th colspan="2" scope="colgroup" style="border: 1px solid #808080;"></th>
                <th scope="col" style="border: 1px solid #808080; font-weight: bold;">1st</th>
                <th scope="col" style="border: 1px solid #808080; font-weight: bold;">2nd</th>
                <th scope="col" style="border: 1px solid #808080; font-weight: bold;">3rd</th>
                <th scope="col" style="border: 1px solid #808080; font-weight: bold;">4th</th>
                <th scope="col" style="border: 1px solid #808080; font-weight: bold;">5th</th>
                <th scope="col" style="border: 1px solid #808080; font-weight: bold;">6th</th>
                <th scope="col" style="border: 1px solid #808080; font-weight: bold;">7th</th>
                <th scope="col" style="border: 1px solid #808080; font-weight: bold;">8th</th>
                <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Total</th>
            </tr>
        </thead>

        <tbody>

            @foreach ($items as $level)
            @foreach ($level->programs as $program)
            @php
                $totalProgramStudents = 0;
            @endphp

            @if ($program->students->count())
            <tr>
                @if ($loop->first)
                <th rowspan="{{ $level->programs->count() }}" scope="rowgroup" style="vertical-align: center;">
                    {{ $level->name }}
                </th>
                @endif
                <th scope="row">{{ $program->name }}</th>

                @foreach ($program->yearSemesters as $yearSemester)
                    @php
                        $totalProgramStudents += $yearSemester->students->count();
                    @endphp
                    <td>{{ $yearSemester->students->count() }}</td>
                @endforeach

                @if ($program->type == 'year')
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                @endif

                <td>{{ $totalProgramStudents }}</td>
            </tr>
            @endif

            @endforeach
            @endforeach

        </tbody>

    </table>
</body>
</html>