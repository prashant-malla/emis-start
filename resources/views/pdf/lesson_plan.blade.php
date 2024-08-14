<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>

    <style type="text/css">
        @font-face {
            font-family: Nirmala;
            font-style: normal;
            font-weight: 400;
            src: url('{{storage_path('fonts/Nirmala.ttf') }}') format('truetype');
        }

        @page {
            size: A3 landscape;
            margin: 0;
        }

        *,
        body {
            padding: 2;
            margin: 2;
            box-sizing: border-box;
            font-family: Nirmala, 'Arial', sans-serif;
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
        <img src="{{ public_path(str_replace(config('app.url'), '', $settings->logo_url)) }}"
             style="height: 80; width: 80;" alt="School Logo">
    @endif

    <h3>{{ $settings->name }}</h3>
</div>

<table>
    <caption>
        {{ $title }}
    </caption>
    <thead>
    <tr>
        <th scope="col">Teacher's Name</th>
        <th scope="col">Subject Name</th>
        <th scope="col">Lesson/Unit</th>
        <th scope="col">Department</th>
        <th scope="col">Level</th>
        <th scope="col">Program</th>
        <th scope="col">Year/Semester</th>
        {{-- <th scope="col">Section</th> --}}
        <th scope="col">Completion Days</th>
        <th scope="col">Learning Objectives</th>
        <th scope="col">Learning Tools/ Resources</th>
        <th scope="col">Learning Outcome</th>
    </tr>
    </thead>

    <tbody>

    @foreach ($items as $item)
        <tr>
            <td>{{$item->teacher->name ?? '-'}}</td>
            <td>{{$item->subject->name ?? '-'}}</td>
            <td>{{$item->unit ?? '-'}}</td>
            <td>{{$item->department ?? '-'}}</td>
            <td>{{$item->level->name ?? '-'}}</td>
            <td>{{$item->program->name ?? '-'}}</td>
            <td>{{$item->yearsemester->name ?? '-'}}</td>
            {{-- <td>{{$item->section->group_name ?? '-'}}</td> --}}
            <td>{{$item->completion_days ?? '-'}}</td>
            <td>{!! $item->learning_objective !!}</td>
            <td>{!! $item->learning_tool !!}</td>
            <td>{!! $item->learning_outcome !!}</td>
        </tr>
    @endforeach

    </tbody>

</table>
</body>
</html>