<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
</head>
<body>
<table style="text-align: center;">
    <tr>
        <th rowspan="2" colspan="4" align="center" style="text-align: center; vertical-align: middle; font-weight: bold; font-size: 18px;">
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
    <thead>
    <tr>
        <th colspan="4">
            <h2><b>{{ $title }}</b></h2>
        </th>
    </tr>

    <tr></tr>
    <tr>
        <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Event Title</th>
        <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Date</th>
        <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Event Venue</th>
        <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Participants</th>
{{--        <th scope="col" style="border: 1px solid #808080; font-weight: bold;">(for staff)Role</th>--}}
{{--        <th scope="col" style="border: 1px solid #808080; font-weight: bold;">(for student)Level</th>--}}
{{--        <th scope="col" style="border: 1px solid #808080; font-weight: bold;">(for student)Program</th>--}}
{{--        <th scope="col" style="border: 1px solid #808080; font-weight: bold;">(for student)Year/Semester</th>--}}
{{--        <th scope="col" style="border: 1px solid #808080; font-weight: bold;">(for student)Group</th>--}}
        <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Organized By</th>
        <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Objectives of the Event/Training</th>
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