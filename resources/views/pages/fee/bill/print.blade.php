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

        .bill-heading span {
            border-bottom: 3px double #000;
        }
    </style>
</head>

<body>
    <div class="print">
        <div class="print-item">
            <div class="print-header text-center mb-2">
                <h2 class="h3 fw-bold mb-0">{{ $setting->name }}</h2>
                <p class="mb-0">{{ $setting->address }}</p>
                <p class="mb-0">{{ $setting->phone_number }}</p>
            </div>

            <h1 class="h6 text-center fw-bold bill-heading pb-2">
                <span>Monthly Invoice</span>
            </h1>

            <div class="print-table">
                <div class="mb-2">
                    <div class="row fw-semibold">
                        <div class="col-12">Bill No.: {{ $billNumber }}</div>
                        <div class="col-8">Student Name: {{ $student->sname }}</div>
                        <div class="col-4 text-end">Bill Date: {{ getTodaySystemDate() }}</div>
                        <div class="col-6">Roll No.: {{ $student->roll }}</div>
                        <div class="col-6 text-end">Program: {{ $student->program->name }}</div>
                        <div class="col-6">Year/Semester: {{ $student->yearSemester->name }}</div>
                        <div class="col-6 text-end">Group: {{ $student->section->group_name }}</div>
                    </div>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr class="tr-semidark">
                            <th width="10%">S.N.</th>
                            <th>Fee Headings</th>
                            <th>Discount</th>
                            <th width="25%">Amount (Rs.)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalAmount = 0;
                        @endphp
                        @foreach ($studentFees as $key => $feeItem)
                            @php
                                $totalAmount += $feeItem->amount - $feeItem->discount_amount;
                            @endphp
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    {{ $feeItem->name }}

                                    @if ($feeItem->submission_type === 'Monthly')
                                        ({{ $feeItem->month_name }})
                                    @endif
                                </td>
                                <td>{{ $feeItem->discount_amount }}</td>
                                <td>{{ convertToMoney($feeItem->amount - $feeItem->discount_amount) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        @php
                            $netAmount = $totalAmount + $oldBalance;
                        @endphp
                        <tr>
                            <th colspan="3" class="text-end">Total</th>
                            <th>{{ convertToMoney($totalAmount) }}</th>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-end">Old Balance</th>
                            <th>{{ convertToMoney($oldBalance) }}</th>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-end">Net Total</th>
                            <th>{{ convertToMoney($netAmount) }}</th>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <span class="fw-bold">In Words:</span>
                                <span>{{ convertToWords($netAmount) }}</span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="signatures pt-5">
                <div class="row justify-content-end">
                    <div class="col-4">
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
<script src="{{ asset('template/js/jquery.min.js') }}"></script>
<script type="text/javascript">
    window.addEventListener('load', () => {
        window.print();
    });

    window.addEventListener("afterprint", (event) => {
        const studentId = '{{ $student->id }}';

        $.post(`/fee_bill/student/${studentId}/store`, {
                total_amount: '{{ $netAmount }}',
                _token: '{{ csrf_token() }}'
            })
            .done(function(data) {
                window.close();
            })
            .fail(function() {
                window.close();
            });
    });
</script>
