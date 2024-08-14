<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt Bill</title>
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

            <h1 class="h6 text-center fw-bold">Receipt Bill</h1>

            <div class="print-table">
                <table class="table table-bordered">
                    <thead>
                        <tr class="tr-dark">
                            <th colspan="3">
                                <div class="row">
                                    <div class="col-6">Bill No.: {{$payment->bill_number}}</div>
                                    <div class="col-6">Payment Date: {{$payment->date}}</div>
                                    <div class="col-6">Student Name: {{$payment->student->sname}}</div>
                                    <div class="col-6">Roll No.: {{$payment->student->roll}}</div>
                                    <div class="col-6">Program: {{$payment->student->program->name}}</div>
                                    <div class="col-6">Year/Semester: {{$payment->student->yearSemester->name}}</div>
                                    <div class="col-6">Group: {{$payment->student->section->group_name}}</div>
                                </div>
                            </th>
                        </tr>
                        <tr class="tr-semidark">
                            <th width="10%">S.N.</th>
                            <th>Fee Headings</th>
                            <th width="30%">Amount (Rs.)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payment->collectedFees as $key => $feeItem)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                {{ $feeItem->feeType->name }}
                                
                                @if($feeItem->feeType->submission_type === 'Monthly')
                                ({{$feeItem->assignFee->month_name}})
                                @endif
                            </td>
                            <td>{{ convertToMoney($feeItem->total_balance) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        @php
                            $advance = $oldBalance < 0 ? -$oldBalance : 0;
                            $oldBalance = $oldBalance > 0 ? $oldBalance : 0;
                            $netAmount = $oldBalance + $payment->due_amount - $advance;
                        @endphp
                        <tr>
                            <th colspan="2" class="text-end">Old Balance</th>
                            <th>{{ convertToMoney($oldBalance) }}</th>
                        </tr>
                        <tr>
                            <th colspan="2" class="text-end">Receivable Amount</th>
                            <th>{{ convertToMoney($oldBalance + $payment->due_amount) }}</th>
                        </tr>
                        {{-- <tr>
                            <th colspan="2" class="text-end">Discount Amount</th>
                            <th>{{ convertToMoney($payment->discount_amount) }}</th>
                        </tr>
                        <tr>
                            <th colspan="2" class="text-end">Fine Amount</th>
                            <th>{{ convertToMoney($payment->fine_amount) }}</th>
                        </tr>
                        <tr>
                            <th colspan="2" class="text-end">Net Amount</th>
                            <th>{{ convertToMoney($netAmount) }}</th>
                        </tr> --}}
                        <tr>
                            <th colspan="2" class="text-end">Received Amount</th>
                            <th>
                                {{ convertToMoney($payment->paid_amount) }}
                            </th>
                        </tr>
                        <tr>
                            <th colspan="2" class="text-end">Advance</th>
                            <th>
                                {{ convertToMoney($advance) }}
                                @if($advance > 0 && $payment->paid_amount < $netAmount)
                                (Deducted)
                                @endif

                            </th>
                        </tr>
                        <tr>
                            <th colspan="2" class="text-end">Balance Amount</th>
                            <th>
                                {{ convertToMoney(abs($netAmount - $payment->paid_amount)) }} {{$netAmount - $payment->paid_amount < 0 ? 'Cr.' : 'Dr.'}}
                            </th>
                        </tr>
                        {{-- <tr>
                            <td colspan="3">
                                <span class="fw-bold">In Words:</span>
                                <span>{{ convertToWords($netAmount) }}</span>
                            </td>
                        </tr> --}}
                    </tfoot>
                </table>
            </div>

            <div class="signatures pt-5">
                <div class="row justify-content-end">
                    <div class="col-4">
                        <div class="signature-label text-center mx-auto">
                            <strong>Received By</strong>
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