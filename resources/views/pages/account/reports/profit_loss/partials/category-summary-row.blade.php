@php
    $primaryGroupAllChildIds = collect($category->getAllChildIds());
    $primaryGroupAllChildIds->push($category->id);

    $primaryGroupTransactions = $transactions->whereIn('account_category_id', $primaryGroupAllChildIds);
    $amount = $category->type === 'Income' ? $primaryGroupTransactions->sum('credit_amount') : $primaryGroupTransactions->sum('debit_amount');
@endphp

<tr class="tr-summary">
    <th class="th-summary-title">
        <span class="summary-title">{{$loop->iteration}}. {{ $category->name }}</span>
    </th>
    <th class="text-right">{{ convertToMoney($amount) }}</th>
    <th class="text-right">
        {{ ($totalRevenue + $totalExpense) > 0 ? round(($amount / ($totalRevenue + $totalExpense)) * 100, 2) : 0 }}%
    </th>
</tr>