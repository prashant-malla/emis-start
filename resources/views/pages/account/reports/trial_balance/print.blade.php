<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trial Balance Print</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('css/accounts/reports/trial-balance.css')}}">
    <style>
        .table {
            --bs-table-bg: transparent
        }

        .tr-dark {
            background-color: #aaa
        }

        .tr-semidark {
            background-color: #ddd
        }

        .table,
        .table th,
        .table td {
            border-color: #777;
            padding: 3px 5px;
            font-size: 13px;
        }

        .print {
            font-size: 14px;
            font-family: Arial, Helvetica, sans-serif;
        }

        .print .signature-label {
            border-top: 1px dotted #000;
            max-width: 180px;
        }
    </style>

    <style>
        .text-right{
            text-align: right;
        }

        tr.text-white>th{
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="print">
        <div class="print-item">
            <div class="print-header text-center mb-2">
                <h2 class="h3 fw-bold mb-0">{{$setting->name}}</h2>
                <p class="mb-0">{{$setting->address}}</p>
                <p class="mb-0">{{$setting->phone_number}}</p>
            </div>

            <h1 class="h6 text-center fw-bold">Trial Balance as of {{$filters['from_date']}} to {{$filters['to_date']}}</h1>

            <div class="print-table">
                @include('pages.account.reports.trial_balance.partials.report-table')
            </div>

            <div class="signatures pt-5">
                <div class="row">
                    <div class="col">
                        <div class="signature-label text-center mx-auto">
                            <strong>Prepared By</strong>
                        </div>
                    </div>
                    <div class="col">
                        <div class="signature-label text-center mx-auto">
                            <strong>Checked By</strong>
                        </div>
                    </div>
                    <div class="col">
                        <div class="signature-label text-center mx-auto">
                            <strong>Approved By</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="{{asset('js/accounts/reports/trial-balance.js')}}"></script>
<script type="text/javascript">
    window.addEventListener('load', () => {
        updateReportView(true);
        window.print();
    });

    window.addEventListener("afterprint", (event) => {
        window.close();
    });
</script>

