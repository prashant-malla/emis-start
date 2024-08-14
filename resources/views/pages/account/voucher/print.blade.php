<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voucher Print</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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
</head>

<body>
    <div class="print">
        <div class="print-item">
            <div class="print-header text-center mb-2">
                <h2 class="h3 fw-bold mb-0">{{$setting->name}}</h2>
                <p class="mb-0">{{$setting->address}}</p>
                <p class="mb-0">{{$setting->phone_number}}</p>
            </div>

            <h1 class="h6 text-center fw-bold">{{ucFirst($voucher->type)}} Voucher</h1>

            <div class="print-table">
                <table class="table table-bordered">
                    <thead>
                        <tr class="tr-dark">
                            <th colspan="2">Voucher Number: {{$voucher->voucher_number}}</th>
                            <th colspan="3">Voucher Date: {{$voucher->date}}</th>
                        </tr>
                        <tr class="tr-semidark">
                            <th width="5%">S.N.</th>
                            <th>Account Head</th>
                            <th width="20%">Description</th>
                            <th width="20%">Debit Amt.</th>
                            <th width="20%">Credit Amt.</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $transactions = $voucher->generalLedgers()->with('ledgerAccount')->get();
                        @endphp
                        @foreach($transactions as $key => $transaction)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $transaction->ledgerAccount->account_name }}</td>
                            <td>{{ $transaction->remark }}</td>
                            <td>{{ convertToMoney($transaction->debit_amount) }}</td>
                            <td>{{ convertToMoney($transaction->credit_amount) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-center">Total</th>
                            <th>{{ convertToMoney($transactions->sum('debit_amount')) }}</th>
                            <th>{{ convertToMoney($transactions->sum('credit_amount')) }}</th>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <span class="fw-bold">Narration:</span>
                                <span>{{ $voucher->description }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <span class="fw-bold">In Words:</span>
                                <span>{{ convertToWords($voucher->amount) }}</span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
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
<script type="text/javascript">
    window.addEventListener('load', () => {
        window.print();
    });

    window.addEventListener("afterprint", (event) => {
        window.close();
    });
</script>