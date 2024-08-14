<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>

        <style type="text/css">
          @page {
            size: A4 landscape;
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
{{--                <th scope="col">Cover Image</th>--}}
                <th scope="col">Title</th>
                <th scope="col">Book Number</th>
                <th scope="col">ISBN Number</th>
                <th scope="col">Publisher</th>
                <th scope="col">Author</th>
                <th scope="col">Subject</th>
                <th scope="col">Rack Number</th>
                <th scope="col">Quantity</th>
                <th scope="col">Book Price</th>
                <th scope="col">Date of Procurement</th>
                <th scope="col">Book Type</th>
            </tr>
        </thead>

        <tbody>

          @foreach ($items->chunk(10) as $chunk)
          @foreach($chunk as $item)
            <tr>
{{--                <td>--}}
{{--                    @if($item->image)--}}
{{--                        <img src="{{ public_path(str_replace(config('app.url'), '', $item->image)) }}" alt="cover_image" style="height: 120px; width: 100px">--}}
{{--                    @endif--}}
{{--                </td>--}}
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
            </tr>
          @endforeach
          @endforeach

        </tbody>

    </table>
</body>
</html>