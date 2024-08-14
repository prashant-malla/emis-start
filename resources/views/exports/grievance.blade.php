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
            <th rowspan="2" colspan="10" align="center"
                style="text-align: center; vertical-align: middle; font-weight: bold; font-size: 18px;">
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
                <th colspan="10">
                    <h2><b>{{ $title }}</b></h2>
                </th>
            </tr>

            <tr></tr>
            <tr>
                <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Grievant Name</th>
                <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Program</th>
                <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Year/Semester</th>
                <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Section</th>
                <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Role</th>
                <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Complaint </th>
                <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Date</th>
                <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Location</th>
                <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Tormentor Name</th>
                <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Grievant Phone Number</th>
            </tr>
        </thead>

        <tbody>

            @foreach ($items as $item)
            <tr>
                @if($item->staff_id != null)
                <td>{{$item->staff->name}}</td>
                <td> - </td>
                <td> - </td>
                <td> - </td>
                @elseif($item->user_id != null)
                <td>{{$item->user->name}}</td>
                <td> - </td>
                <td> - </td>
                <td> - </td>
                @elseif($item->student_id != null)
                <td>{{$item->student->sname}}</td>
                <td>{{$item->student->program->name}}</td>
                <td>{{$item->student->yearsemester->name}}</td>
                <td>{{$item->student->section->group_name}}</td>
                @endif
                <td>{{$item->status}}</td>
                <td>{{implode(', ', $item->complaint)}}</td>
                <td>{{$item->grievance_date ?? '-'}}</td>
                <td>{{$item->location ?? '-'}}</td>
                <td>{{$item->tormentor_name ?? '-'}}</td>
                <td>{{$item->grievant_mobile ?? '-'}}</td>
            </tr>
            @endforeach

        </tbody>

    </table>
</body>

</html>