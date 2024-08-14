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
              <th scope="col">Grievant Name</th>
              <th scope="col">Program</th>
              <th scope="col">Year/Semester</th>
              <th scope="col">Section</th>
              <th scope="col">Role</th>
              <th scope="col">Complaint </th>
              <th scope="col">Date</th>
              <th scope="col">Location</th>
              <th scope="col">Tormentor Name</th>
              <th scope="col">Grievant Phone Number</th>
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