<div class="modal fade" id="partialPaidFeeModal" tabindex="-1" aria-labelledby="partialPaidFeeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="partialPaidFeeModalLabel">Old Dues List</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered display" id="feeTable">
                    <thead>
                        <tr>
                            <th>Fee Type</th>
                            <th>Due Date</th>
                            <th>Amount</th>
                            <th>Discount</th>
                            <th>Fine</th>
                            <th>Balance</th>
                            <th>Paid Amount</th>
                            <th>Final Due</th>
                        </tr>
                    </thead>
                    @php
                    $totalFeeAmount = 0;
                    $totalDiscountAmount = 0;
                    $totalFineAmount = 0;
                    $totalPaidAmount = 0;
                    @endphp
                    <tbody>
                        @foreach($partialFees as $key => $fee)
                        @php
                        $balanceAmount = $fee->amount - $fee->discount_amount + $fee->fine_amount;
                        $totalFeeAmount += $fee->amount;
                        $totalDiscountAmount += $fee->discount_amount;
                        $totalFineAmount += $fee->fine_amount;
                        $totalPaidAmount += $fee->amount_paid;
                        @endphp
                        <tr data-amount="{{$balanceAmount - $fee->amount_paid}}">
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
                            <td>{{$fee->amount_paid}}</td>
                            <td>{{$balanceAmount - $fee->amount_paid}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="text-right">Total</th>
                            <td></td>
                            <th>{{ $totalFeeAmount }}</th>
                            <th>{{ $totalDiscountAmount }}</th>
                            <th>{{ $totalFineAmount }}</th>
                            <th>{{ $totalFeeAmount - $totalDiscountAmount + $totalFineAmount }}</th>
                            <th>{{ $totalPaidAmount }}</th>
                            <th>{{ $totalFeeAmount - $totalDiscountAmount + $totalFineAmount - $totalPaidAmount }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>