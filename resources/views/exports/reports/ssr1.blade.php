<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
</head>

<body>
    <table style="text-align: center;">
        <tr>
            <th rowspan="2" colspan="{{ count($headings) }}" align="center" style="text-align: center; vertical-align: middle; font-weight: bold; font-size: 18px;">
                @if($schoolLogo)
                    <img src="{{ $schoolLogo }}" width="70" alt="School Logo">
                @endif
                <h1>{{ $settings->name }}</h1>
            </th>
        </tr>
    </table>


    <br />

    <h4 style="padding-top: 1rem; padding-bottom: 1rem;">{{ $title }}</h4>

    <br />

        <table style="font-size: 12px; border: 1px solid #000; border-collapse: collapse;">
            <thead>
                <tr>

                    @foreach ($headings as $heading)
                        <th style="font-weight: bold; border: 1px solid #000; border-collapse: collapse;">
                            {{ $heading }}
                        </th>
                    @endforeach

                </tr>
            </thead>

            <tbody>

                @forelse ($ssrs as $staff)
                    <tr>
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
