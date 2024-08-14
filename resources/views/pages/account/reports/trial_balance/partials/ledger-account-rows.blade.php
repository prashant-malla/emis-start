@php
    $spacing .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

    $ledgerTransactions = $transactions->groupBy('ledger_account_id');
    // $categoryDebit = 0;
    // $categoryCredit = 0;
@endphp

@foreach($leafLedgerAccounts as $ledgerAccount)
    @php
        $transactions = $ledgerTransactions[$ledgerAccount->id] ?? collect([]);

        $ledgerAccountDebit = $transactions->sum('debit_amount');
        // $categoryDebit += $ledgerAccountDebit;

        $ledgerAccountCredit = $transactions->sum('credit_amount');
        // $categoryCredit += $ledgerAccountCredit;
    @endphp

    <tr>
        <td>{!! $spacing !!}{{$ledgerAccount->account_name}}</td>
        <td class="text-right">{{ convertToMoney($ledgerAccountDebit) }}</td>
        <td class="text-right">{{ convertToMoney($ledgerAccountCredit) }}</td>
    </tr>
@endforeach

{{-- Category Total Row --}}
{{-- <tr class="bg-light">
    <th></th>
    <th class="text-right">{{ convertToMoney($categoryDebit) }}</th>
    <th class="text-right">{{ convertToMoney($categoryCredit) }}</th>
</tr> --}}