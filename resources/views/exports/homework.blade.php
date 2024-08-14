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
        <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Level</th>
        <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Program</th>
        <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Year/Semester</th>
        <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Group</th>
        <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Subject</th>
        <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Assigned By</th>
        <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Assigned Date</th>
        <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Submission Date</th>
        <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Submission Time</th>
        <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Description</th>
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