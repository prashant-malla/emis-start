<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
</head>
@php
$filePath = public_path($schoolLogo);
$fileExists = checkFileExists($filePath);
@endphp
<body>
    <table style="text-align: center;">
        <tr>
            <th rowspan="2" colspan="11" align="center"
                style="text-align: center; vertical-align: middle; font-weight: bold; font-size: 18px;">
                @if($fileExists)
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
                <th colspan="11">
                    <h2><b>{{ $title }}</b></h2>
                </th>
            </tr>

            <tr></tr>
            <tr>
                {{-- <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Cover Image</th> --}}
                <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Title</th>
                <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Book Number</th>
                <th scope="col" style="border: 1px solid #808080; font-weight: bold;">ISBN Number</th>
                <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Publisher</th>
                <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Author</th>
                <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Subject</th>
                <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Rack Number</th>
                <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Quantity</th>
                <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Book Price</th>
                <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Date of Procurement</th>
                <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Book Type</th>
                <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Book Edition</th>
                <th scope="col" style="border: 1px solid #808080; font-weight: bold;">Description</th>
            </tr>
        </thead>

        <tbody>

            @foreach ($items as $item)
            <tr>                
                {{-- <td>
                    <!-- Image will be drawn from drawings -->
                </td> --}}
                <td>{{$item->title}}</td>
                <td>{{$item->book_number}}</td>
                <td>{{$item->isbn_number}}</td>
                <td>{{$item->publisher}}</td>
                <td>{{$item->author}}</td>
                <td>{{$item->subject}}</td>
                <td>{{$item->rack_number}}</td>
                <td>{{$item->quantity}}</td>
                <td>{{$item->book_price}}</td>
                <td>{{$item->post_date}}</td>
                <td>{{$item->book_type}}</td>
                <td>{{$item->book_edition}}</td>
                <td>{{$item->description}}</td>
            </tr>
            @endforeach

        </tbody>

    </table>
</body>

</html>