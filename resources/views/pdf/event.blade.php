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
        <th>Event Title</th>
        <th>Date</th>
        <th>Event Venue</th>
        <th>Participants</th>
{{--        <th>(for staff)Role</th>--}}
{{--        <th>(for student)Level</th>--}}
{{--        <th>(for student)Program</th>--}}
{{--        <th>(for student)Year/Semester</th>--}}
{{--        <th>(for student)Group</th>--}}
        <th>Organized By</th>
        <th>Objectives of the Event/Training</th>
    </tr>
    </thead>

    <tbody>

    @foreach ($items as $item)
        <tr>
            <td>{{$item->title}}</td>
            <td>{{$item->date}}</td>
            <td>{{$item->venue}}</td>
            <td>{{$item->participants}}</td>
{{--            <td>--}}
{{--                @if($item->participants == "Staff")--}}
{{--                    @foreach($item->roles as $role)--}}
{{--                        {{$role->role}},--}}
{{--                    @endforeach--}}
{{--                @endif--}}
{{--            </td>--}}
{{--            <td>--}}
{{--                @if($item->participants == "Student")--}}
{{--                    @foreach($item->levels as $level)--}}
{{--                        {{$level->name}},--}}
{{--                    @endforeach--}}
{{--                @endif--}}
{{--            </td>--}}
{{--            <td>--}}
{{--                @if($item->participants == "Student")--}}
{{--                    @foreach($item->programs as $program)--}}
{{--                        {{$program->name}},--}}
{{--                    @endforeach--}}
{{--                @endif--}}
{{--            </td>--}}
{{--            <td>--}}
{{--                @if($item->participants == "Student")--}}
{{--                    @foreach($item->yearsemesters as $yearSemester)--}}
{{--                        {{$yearSemester->name}},--}}
{{--                    @endforeach--}}
{{--                @endif--}}
{{--            </td>--}}
{{--            <td>--}}
{{--                @if($item->participants == "Student")--}}
{{--                    @foreach($item->sections as $group)--}}
{{--                        {{$group->group_name}},--}}
{{--                    @endforeach--}}
{{--                @endif--}}
{{--            </td>--}}
            <td>{{$item->organize}}</td>
            <td>{{sanitizeTextforExport($item->objective)}}</td>
        </tr>
    @endforeach

    </tbody>

</table>
</body>
</html>