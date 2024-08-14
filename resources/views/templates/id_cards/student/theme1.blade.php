@php
$paperSize = isset($paperSize) ? $paperSize : 'single'
@endphp

<!DOCTYPE html>
<html>

<head>
  <title>{{ $idcard['name'] }}</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&family=Martel:wght@900&display=swap"
    rel="stylesheet">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

  <style>
    * {
      margin: 0;
      padding: 0;
      border: 0;
      box-sizing: border-box;
      print-color-adjust: exact;
      -webkit-print-color-adjust: exact;
    }

    @page {
      size: 54mm 86mm;
      margin: 0;
    }

    .print {
      width: 54mm;
      height: 86mm;
      page-break-after: always;
    }

    .design {
      padding: 2mm;
      height: 100%;
      font-family: 'Manrope', sans-serif;
      font-size: 7.2px;
      font-weight: 500;
      background-size: 100% 100%;
      position: relative;
      overflow: hidden;
    }

    .title {
      margin-bottom: 3px;
      text-transform: uppercase;
      text-align: center;
    }

    .header {
      text-align: center;
      margin-bottom: 5px;
    }

    .header h1 {
      font-family: 'Martel', serif;
      font-size: 15px;
      line-height: 17px;
      font-weight: 900;
    }


    .header h2 {
      font-family: 'Martel', serif;
      font-size: 12px;
      line-height: 14px;
      font-weight: 900;
    }

    .header h3 {
      font-family: 'Martel', serif;
      font-size: 9px;
      line-height: 11px;
      font-weight: 900;
    }

    .header p {
      font-weight: 600;
    }

    .logo {
      text-align: center;
      margin-bottom: 5px;
    }

    .logo img {
      width: auto;
    }

    .student-title {
      margin-bottom: 5px;
      text-align: center;
    }

    .student-name {
      font-size: 11px;
      font-weight: 700;
      text-transform: uppercase;
      font-weight: bold;
    }

    .sub-text {
      margin-top: 2px;
    }

    .profile {
      text-align: center;
      margin-bottom: 5px;
      position: relative;
    }

    .profile .profile-image {
      object-fit: cover;
      object-position: center top;
      border: 4px solid #fff;
      border-radius: 50%;
      box-shadow: 0 2px 4px rgba(0, 0, 0, .2);
    }

    .profile .signature {
      height: 40px;
      width: auto;
      position: absolute;
      bottom: -10px;
      left: 50%;
      transform: translateX(-50%);
    }

    .fields {
      list-style: none;
      padding: 0 0 0 12px;
      letter-spacing: 0.1px;
      font-weight: bold;
      font-size: 8px;
    }

    .fields li {
      display: flex;
      margin-bottom: 1px;
    }

    .field-key {
      flex-shrink: 0;
      flex-basis: 65px;
      position: relative;
    }

    .field-key::after {
      content: ' :';
      position: absolute;
      top: 0;
      right: 0;
      margin-right: 8px;
    }

    /* .field-value {
      word-break: break-all;
    } */

    .footer {
      position: absolute;
      bottom: 10px;
      left: 0;
      width: 100%;
      text-align: center;
      font-size: 7px;
    }

    @media screen {
      .design {
        outline: 1px dashed #ccc;
        outline-offset: 1px
      }
    }
  </style>

  @if($paperSize === 'A4')
  <style>
    @page {
      size: 297mm 210mm;
      margin: 0;
    }

    .print-container {
      width: 297mm;
      height: 210mm;
      page-break-after: always;
      display: flex;
      flex-wrap: wrap;
    }

    .print {
      page-break-after: avoid;
      flex-shrink: 0;
      margin: 37px 0 0 17px
    }

    .design {
      outline: 1px dashed #ccc;
      outline-offset: 1px
    }
  </style>
  @endif
</head>

<body>
  @php
  $logoHeight = ($idcard['logo_height'] ?? 45).'px';
  $headerHeight = ($idcard['header_height'] ?? 26).'px';
  $imageWidth = ($idcard['image_width'] ?? 70).'px';
  $imageHeight = ($idcard['image_height'] ?? 70).'px';
  $fieldItemHeight = ($idcard['field_item_height'] ?? 9).'px';

  $chunkLength = $paperSize === 'A4' ? 10 : count($students);
  $students = is_array($students) ? $students : $students->toArray();
  $studentsChunk = array_chunk($students, $chunkLength);
  @endphp

  @foreach($studentsChunk as $students)
  <div class="print-container">
    @foreach($students as $student)
    <div class="print">
      <div class="design" style="background-image: url('{{$idcard['background_image']}}')">
        @if($idcard['title'])
        <h3 class="title">{{$idcard['title']}}</h3>
        @endif

        <div class="logo" style="height:{{$logoHeight}}">
          <img src="{{$idcard['logo'] ? $idcard['logo'] : $school_setting->logo_url}}" style="height:{{$logoHeight}}">
        </div>

        <div class="header" style="height:{{$headerHeight}}">
          {!! $idcard['header'] !!}
        </div>

        <div class="profile">
          <img
            src="{{$student['profileImage'] ? $student['profileImage'] : asset('template/images/placeholder/1.jpg')}}"
            class="profile-image" style="width:{{$imageWidth}}; height:{{$imageHeight}}">

          @if($idcard['signature'])
          <img src="{{$idcard['signature']}}" class="signature">
          @endif
        </div>

        <div class="student-title">
          <p class="student-name" style="color:{{$idcard['primary_color']}}">{{ $student['sname'] }}</p>
          {{-- <p class="sub-text" style="color:{{$idcard['secondary_color']}}">{{ $student['email'] }}</p> --}}
        </div>


        <ul class="fields">
          @foreach($idcard['fields'] as $field => $label)
          @if(isset($student[$field]) && $student[$field])
          <li style="min-height: {{$fieldItemHeight}}">
            <div class="field-key" style="color:{{$idcard['primary_color']}}">
              {{$field === 'yearSemester' ? ucfirst($student['yearSemesterType']) : $label}}
            </div>
            <div class="field-value" style="color:{{$idcard['secondary_color']}}">{!! $student[$field] !!}</div>
          </li>
          @endif
          @endforeach

          @if($idcard['valid_upto'])
          <li style="min-height: {{$fieldItemHeight}}">
            <div class="field-key" style="color:{{$idcard['primary_color']}}">Valid Upto</div>
            <div class="field-value" style="color:{{$idcard['secondary_color']}}">{{$idcard['valid_upto']}}</div>
          </li>
          @endif
        </ul>

        <div class="footer">
          {!! $idcard['footer'] !!}
        </div>
      </div>
    </div>
    @endforeach
  </div>
  @endforeach
</body>

</html>