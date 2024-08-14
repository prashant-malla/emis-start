<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Report 2</title>

        <style type="text/css">
          @page {
            size: A4;
            margin: 0;
        }

        *,
        body {
            padding: 2;
            margin: 2;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #ccc;
        }

        th, td {
            padding: 6px 7px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            font-weight: bold;
            color: #333;
        }
    </style>
</head>
<body>
    <div style="text-align: center;">
        @if($settings->logo_url)
            <img src="{{ public_path(str_replace(config('app.url'), '', $settings->logo_url)) }}" style="height: 80; width: 80;" alt="School Logo">
        @endif

        <h3>{{ $settings->name }}</h3>
    </div>

    <table>
        <caption>
            {{ $title }}
        </caption>
        <col>
        <col>
        <col>
        <colgroup span="8"></colgroup>

        <thead>
            <tr>
                <th scope="col" style="width: 10%; background-color: #f2f2f2;">Level</th>
                <th scope="col" style="width: 10%; background-color: #f2f2f2;">Academic Programs</th>
                <th colspan="9" scope="colgroup" style="width: 60%; background-color: #f2f2f2;">Year/ Semester Wise No. of Student (Enrollment)</th>
            </tr>

            <tr>
                <th colspan="2" scope="colgroup"></th>
                <th scope="col">1st</th>
                <th scope="col">2nd</th>
                <th scope="col">3rd</th>
                <th scope="col">4th</th>
                <th scope="col">5th</th>
                <th scope="col">6th</th>
                <th scope="col">7th</th>
                <th scope="col">8th</th>
                <th scope="col">Total</th>
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