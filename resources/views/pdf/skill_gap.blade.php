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
                <th>Do you believe that there is a skills gap in providing effectual administration and education?</th>
                <th>(Only for academic staff) What kind of training do you think will improve the quality of teaching? Please list out.</th>
                <th>(Only for employees) What kind of training is required to carry out the tasks listed in the job description? Please list out.</th>
                <th>Your advice and comments on skill development?</th>
            </tr>
        </thead>

        <tbody>

            @foreach ($items as $item)            
            <tr>
                <td>{{$item->organize}}</td>
                <td>{{sanitizeTextforExport($item->staff)}}</td>
                <td>{{sanitizeTextforExport($item->employees)}}</td>
                <td>{{sanitizeTextforExport($item->objective)}}</td>
            </tr>
            @endforeach

        </tbody>

    </table>
</body>
</html>