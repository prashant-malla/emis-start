@php($spacing .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;')
@foreach($subCategories as $subCategory)
    <tr>
        <th>{!! $spacing !!}{{ $subCategory->name }}</th>
        <td></td>
        <td></td>
    </tr>
    
    @includeWhen($subCategory->allChildren->isNotEmpty(), 'pages.account.reports.profit_loss.partials.sub-category-row', [
        'subCategories' => $subCategory->allChildren
    ])
    {{-- @includeWhen($subCategory->allChildren->isEmpty(), 'pages.account.reports.profit_loss.partials.ledger-account-rows', [
        'leafLedgerAccounts' => $ledgerAccountsGroupedByLeafCategory[$subCategory->id] ?? []
    ]) --}}

    {{-- Self Transactions --}}
    @php($selfLedgerAccounts = $transactions->where('account_category_id', $subCategory->id))
    @includeWhen($selfLedgerAccounts->isNotEmpty(), 'pages.account.reports.profit_loss.partials.ledger-account-rows', [
        'leafLedgerAccounts' => $selfLedgerAccounts
    ])
@endforeach