@php
    $primaryGroupAllChildIds = collect($category->getAllChildIds());
    $primaryGroupAllChildIds->push($category->id);

    // Find all ledger accounts for group (account_category could be self or child categories)
    $primaryGroupLedgerAccountIds = $ledgerAccounts->whereIn('account_category_id', $primaryGroupAllChildIds)->pluck('id')->toArray();

    $primaryGroupTransactions = $transactions->whereIn('ledger_account_id', $primaryGroupLedgerAccountIds);
@endphp
<tr class="tr-summary">
    <th class="th-summary-title">
        <span class="summary-title">{{$loop->iteration}}. {{ $category->name }}</span>
    </th>
    <th class="text-right">{{ convertToMoney($primaryGroupTransactions->sum('debit_amount')) }}</th>
    <th class="text-right">{{ convertToMoney($primaryGroupTransactions->sum('credit_amount')) }}</th>
</tr>