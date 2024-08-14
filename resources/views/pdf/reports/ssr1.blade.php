<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@100&family=Roboto:wght@300;400;500;700&display=swap"
    rel="stylesheet">
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
            font-family: 'Roboto', sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #ccc;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
            color: #333;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
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

    <h5 style="padding-top: 1rem; padding-bottom: 1rem;">{{ $title }}</h5>

    <table style="font-size: 12px;">
        <thead>
            <tr>
                <th>SN</th>

                @foreach ($headings as $heading)
                <th>{{ $heading }}</th>
                @endforeach

            </tr>
        </thead>

        <tbody>

            @forelse ($ssrs as $staff)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    @foreach ($headings as $heading)
                    <td>{{ $staff[array_search($heading, $headings)] }}</td>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($headings) + 1 }}" style="text-align: center;">
                        No records found.
                    </td>
                </tr>
            @endforelse

        </tbody>
    </table>
</body>
</html>
