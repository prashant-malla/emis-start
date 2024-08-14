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
                <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Do you believe that there is a skills gap in providing effectual administration and education?</th>
                <th scope="col" style="border: 1px solid #808080; font-weight: bold;">(Only for academic staff) What kind of training do you think will improve the quality of teaching? Please list out.</th>
                <th scope="col" style="border: 1px solid #808080; font-weight: bold;">(Only for employees) What kind of training is required to carry out the tasks listed in the job description? Please list out.</th>
                <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Your advice and comments on skill development?</th>
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