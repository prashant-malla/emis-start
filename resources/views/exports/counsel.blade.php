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
        <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Name of counsellor</th>
        <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Name of counselee</th>
        <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Counselling Date</th>
        <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Types of Counselling</th>
        <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Counselee ID Card Number</th>
        <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Program</th>
        <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Issues of Counselling</th>
        <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Recommendation by Counsellor</th>
    </tr>
    </thead>

    <tbody>

    @foreach ($items as $item)
        <tr>
            <td>{{$item->counselt_name}}</td>
            @if($item->counselling_type == "Enrollment Counselling")
                <td>{{$item->counselte_name}}</td>
            @else
                <td>{{$item->student->sname ?? ''}}</td>
            @endif
            <td>{{$item->counsel_date}}</td>
            <td>{{$item->counselling_type}}</td>
            <td>{{$item->card_no ?? ''}}</td>
            <td>{{$item->program->name ?? ''}}</td>
            <td>{{sanitizeTextforExport($item->issue)}}</td>
            <td>{{sanitizeTextforExport($item->recommendation)}}</td>
        </tr>
    @endforeach

    </tbody>

</table>
</body>
</html>