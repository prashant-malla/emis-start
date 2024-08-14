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
        <th>Name of counsellor</th>
        <th>Name of counselee</th>
        <th>Counselling Date</th>
        <th>Types of Counselling</th>
        <th>Counselee ID Card Number</th>
        <th>Program</th>
        <th>Issues of Counselling</th>
        <th>Recommendation by Counsellor</th>
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