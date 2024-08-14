<table class="table table-bordered display" id="feeTable">
    <thead>
        <tr>
            <th>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="checkAll">
                    <label class="custom-control-label" for="checkAll"></label>
                </div>
            </th>
            <th>Fee Type</th>
            <th>Due Date</th>
            <th>Amount</th>
            <th>Discount</th>
            <th>Fine</th>
            <th>Balance</th>
            {{-- <th>Paid Amount</th> --}}
            {{-- <th>Final Due</th> --}}
        </tr>
    </thead>
    @php
    $totalFeeAmount = 0;
    $totalDiscountAmount = 0;
    $totalFineAmount = 0;
    // $totalPaidAmount = 0;
    @endphp
    <tbody>
        @foreach($assignedFees as $key => $fee)
        @php
        $balanceAmount = $fee->amount - $fee->discount_amount + $fee->fine_amount;
        $totalFeeAmount += $fee->amount;
        $totalDiscountAmount += $fee->discount_amount;
        $totalFineAmount += $fee->fine_amount;
        // $totalPaidAmount += $fee->amount_paid;
        @endphp
        <tr data-amount="{{$balanceAmount - $fee->amount_paid}}">
            <td>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input fee-check" id="customCheck{{$key}}"
                        name="assign_fee_id[]" value="{{$fee->id}}">
                    <label class="custom-control-label" for="customCheck{{$key}}"></label>
                </div>
            </td>
            <td>
                <div>
                    {{$fee->name}}

                    @if($fee->submission_type === 'Monthly')
                    ({{$fee->month_name}})
                    @endif
                </div>

                <div>
                    @if($fee->is_due)
                    <span class="badge badge-danger p-1">Over Due</span>
                    @endif

                    @if($fee->amount_paid > 0)
                    <span class="badge badge-info p-1">Partially Paid</span>
                    @endif
                </div>
            </td>
            <td>{{$fee->due_date}}</td>
            <td>{{$fee->amount}}</td>
            <td>{{$fee->discount_amount}}</td>
            <td>{{$fee->fine_amount}}</td>
            <td>
                {{$balanceAmount}}
            </td>
            {{-- <td>{{$fee->amount_paid}}</td> --}}
            {{-- <td>{{$balanceAmount - $fee->amount_paid}}</td> --}}
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="2" class="text-right">Total</th>
            <td></td>
            <th>{{ $totalFeeAmount }}</th>
            <th>{{ $totalDiscountAmount }}</th>
            <th>{{ $totalFineAmount }}</th>
            <th>{{ $totalFeeAmount - $totalDiscountAmount + $totalFineAmount }}</th>
            {{-- <th>{{ $totalPaidAmount }}</th> --}}
            {{-- <th>{{ $totalFeeAmount - $totalDiscountAmount + $totalFineAmount - $totalPaidAmount }}</th> --}}
        </tr>
    </tfoot>
</table>