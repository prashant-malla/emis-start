<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $school_setting->name }}</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ $school_setting->logo_url }}">

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <!-- Summernote -->
    <link href="/template/vendor/summernote/summernote.css" rel="stylesheet">
    <link rel="stylesheet" href="/template/vendor/bootstrap-select/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="/template/css/style.css">
    <link rel="stylesheet" href="/template/css/skin-3.css">

    <!-- English Date/Time Picker -->
    <link rel="stylesheet" href="/template/vendor/pickadate/themes/default.css">
    <link rel="stylesheet" href="/template/vendor/pickadate/themes/default.date.css">

    {{-- Toaster --}}
    <link rel="stylesheet" href="{{ asset('template/vendor/toastr/css/toastr.min.css') }}">

    {{-- Nepali Date Picker --}}
    <link rel="stylesheet" href="/template/vendor/nepali.datepicker.v4.0.1/css/nepali.datepicker.v4.0.1.min.css">

    <!-- link for flash message-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.1/css/bootstrap.min.css"
        integrity="sha512-Ez0cGzNzHR1tYAv56860NLspgUGuQw16GiOOp/I2LuTmpSK9xDXlgJz3XN4cnpXWDmkNBKXR/VDMTCnAaEooxA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
        integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{--
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> --}}

    <!-- Datatable -->
    <link href="{{ asset('template/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('template/vendor/jqvmap/css/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/vendor/chartist/css/chartist.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('template/css/skin-2.css') }}">

    <style>
        input[type="date"]::-webkit-calendar-picker-indicator {
            background: transparent;
            bottom: 0;
            color: transparent;
            cursor: pointer;
            height: auto;
            left: 0;
            position: absolute;
            right: 0;
            top: 0;
            width: auto;
        }

        input {
            position: relative;
        }

        .form-select {
            font-size: 0.937rem;
        }

        span.required,
        label.error {
            color: #FF1616;
        }

        .form-control.error,
        .form-select.error,
        .form-select.error~.select2 .select2-selection,
        .form-control.error~.select2 .select2-selection {
            border-color: #FF1616;
        }

        .select2-container .select2-selection--single,
        .select2-container--classic .select2-selection--single .select2-selection__arrow {
            top: 0 !important;
            height: 36.47px !important;
            background: transparent !important;
        }

        .select2-container--classic .select2-selection--single .select2-selection__rendered {
            line-height: 1.5 !important;
            padding: .375rem 2.25rem .375rem .75rem
        }

        .mt-lh {
            margin-top: 30.469px;
        }

        .picker__select--month,
        .picker__select--year {
            font-size: 16px;
        }

        .btn.loading {
            opacity: 0.5;
            pointer-events: none
        }

        .btn.loading::after {
            content: '...';
        }

        .material-icons {
            vertical-align: sub;
        }

        table.dataTable thead .no-sort {
            background-image: none
        }

        @media(min-width: 768px) {
            .mt-md-lh {
                margin-top: 30.469px;
            }
        }

        /* Scroll Table */
        .table-scroll {
            overflow-y: auto;
        }

        .table-scroll thead {
            position: sticky;
            top: 0;
            z-index: 2;
        }

        /* Page Print Fix */
        @page {
            size: auto;
        }

        @media print {

            .nav-header,
            .header,
            .dlabnav,
            .page-titles,
            .footer {
                display: none
            }

            .content-body,
            .container-fluid {
                margin: 0 !important;
                padding: 0 !important;
            }

            body {
                background-color: transparent
            }
        }
    </style>
    @yield('styles')
</head>
