<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>

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
            font-family: 'Arial', sans-serif;
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
    <thead>
    <tr>
        <th>Level</th>
        <th>Program</th>
        <th>Year/Semester</th>
        <th>Group</th>
        <th>Subject</th>
        <th>Assigned By</th>
        <th>Assigned Date</th>
        <th>Submission Date</th>
        <th>Submission Time</th>
        <th>Description</th>
    </tr>
    </thead>

    <tbody>

    @foreach ($items as $item)
        <tr>
            <td>{{$item->level->name}}</td>
            <td>{{$item->program->name}}</td>
            <td>{{$item->yearsemester->name}}</td>
            <td>{{$item->section->group_name}}</td>
            <td>{{$item->subject->name}}</td>
            <td>{{$item->teacher->name}}</td>
            <td>{{$item->assign}}</td>
            <td>{{$item->submission}}</td>
            <td>{{$item->submission_time}}</td>
            <td>{{sanitizeTextforExport($item->description)}}</td>
        </tr>
    @endforeach

    </tbody>

</table>
</body>
</html>