<!DOCTYPE html>
<html>

<head>
    <title>{{ $certificates[0]['name'] }}</title>
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
            size: 297mm 210mm;
            margin: 0;
        }

        .print {
            width: 297mm;
            height: 210mm;
            padding: 10mm;
            page-break-after: always;
        }

        .design {
            padding: 20mm 25mm;
            height: 100%;
            font-family: 'Times New Roman', Times, serif;
            font-size: 18px;
            background-size: 100% 100%;
            overflow: hidden;
        }

        .header {
            text-align: center;
            position: relative;
        }

        .header h2 {
            font-size: 36px;
            margin-bottom: 5px;
        }

        .header .address {
            font-family: Arial, Helvetica, sans-serif;
        }

        .header h3 {
            font-size: 22px;
            text-transform: uppercase;
        }

        .header-left,
        .header-right {
            position: absolute;
            left: 0;
            text-align: left;
            font-size: 13px;
            font-family: Arial, Helvetica, sans-serif;
            font-style: italic;
        }

        .header-left {
            top: 20px;
        }

        .header-right {
            top: 60px;
            left: calc(100% - 210px);
        }

        .logo {
            position: absolute;
            top: 60px;
            left: 0;
        }

        .title {
            font-size: 48px;
            text-align: center;
        }

        .content {
            font-style: italic;
            font-size: 20px;
            line-height: 28px;
        }

        .content p {
            margin-bottom: 15px;
        }

        .footer {
            display: flex;
            text-align: center;
            align-items: end;
        }

        .footer>div {
            flex-grow: 1;
        }
    </style>
</head>

<body>
    @php
    $headerHeight = ($certificates[0]['header_height'] ?? 160).'px';
    $titleHeight = ($certificates[0]['title_height'] ?? 75).'px';
    $contentHeight = ($certificates[0]['content_height'] ?? 275).'px';
    $footerHeight = ($certificates[0]['footer_height'] ?? 42).'px';
    @endphp

    @foreach($certificates as $certificate)
    <div class="print">
        <div class="design" style="background-image: url('{{$certificate['background_image']}}')">
            <div class="header" style="height: {{$headerHeight}}">
                <h2>{{$school_setting->name}}</h4>
                    <p class="address">{{$school_setting->address}}</p>

                    {!! $certificate['sub_heading'] !!}

                    <div class="header-left">
                        {!! $certificate['header_left'] !!}
                    </div>

                    <div class="header-right">
                        {!! $certificate['header_right'] !!}
                    </div>

                    <img src="{{$school_setting->logo_url}}" class="logo" width="140">
            </div>

            <h1 class="title" style="height: {{$titleHeight}}">{{ $certificate['header_middle'] }}</h1>

            <div class="content" style="height: {{$contentHeight}}">
                {!! $certificate['content'] !!}
            </div>

            <div class="footer" style="height: {{$footerHeight}}">
                <div>{!! $certificate['footer_left'] !!}</div>
                <div>{!! $certificate['footer_middle'] !!}</div>
                <div>{!! $certificate['footer_right'] !!}</div>
            </div>
        </div>
    </div>
    @endforeach
</body>

</html>