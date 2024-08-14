@php
    $spacing .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

    $ledgerTransactions = $transactions->groupBy('ledger_account_id');
    // $categoryAmount = 0;
    $amountTotal = $accountType === 'Income' ? $totalRevenue : $totalExpense;
@endphp

@foreach($leafLedgerAccounts as $ledgerAccount)
    @php
        $transactions = $ledgerTransactions[$ledgerAccount->ledger_account_id] ?? collect([]);

        $ledgerAccountAmount = $accountType === 'Income' ? $transactions->sum('credit_amount') : $transactions->sum('debit_amount');
        // $categoryAmount += $ledgerAccountAmount;
    @endphp
    <tr>
        <td>{!! $spacing !!}{{$ledgerAccount->ledger_account_name}}</td>
        <td class="text-right">{{ convertToMoney($ledgerAccountAmount) }}</td>
        <td class="text-right">{{ $amountTotal > 0 ? round(($ledgerAccountAmount / $amountTotal) * 100, 2) : 0 }} %</td>
    </tr>
@endforeach

{{-- Category Total Row --}}
{{-- <tr class="bg-light">
    <th></th>
    <th class="text-right">{{ convertToMoney($categoryAmount) }}</th>
    <th class="text-right">{{ $amountTotal > 0 ? round(($categoryAmount / $amountTotal) * 100, 2) : 0 }} %</th>
</tr> --}}