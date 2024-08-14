<table id="report-table" class="table table-bordered">
    <thead>
      <tr class="bg-dark text-white">
        <th>Account</th>
        <th class="text-right" width="25%">Debit Amount</th>
        <th class="text-right" width="25%">Credit Amount</th>
      </tr>
    </thead>
    <tbody>
      @foreach($categories as $category)

        @php
          $spacing='';
          $ledgerAccountsGroupedByLeafCategory = $ledgerAccounts->groupBy('account_category_id');
        @endphp

        <tr>
          <th class="text-primary">{{$loop->iteration}}. {{ $category->name }}</th>
          <th class="text-right"></th>
          <th class="text-right"></th>
        </tr>     

        {{-- Nested Sub Category Rows --}}
        @includeWhen($category->allChildren->isNotEmpty(), 'pages.account.reports.trial_balance.partials.sub-category-row', [
          'subCategories' => $category->allChildren
        ])

        {{-- Self Transactions --}}
        @php($selfLedgerAccounts = $ledgerAccounts->where('account_category_id', $category->id))
        @includeWhen($selfLedgerAccounts->isNotEmpty(), 'pages.account.reports.trial_balance.partials.ledger-account-rows', [
            'leafLedgerAccounts' => $selfLedgerAccounts
        ])

        {{-- Main Category Summary --}}
        @include('pages.account.reports.trial_balance.partials.category-summary-row')

      @endforeach

      {{-- Net Total Row --}}
      <tr class="bg-dark text-white tr-net-summary">
        <th class="text-right">Net Total</th>
        <th class="text-right">{{ convertToMoney($transactions->sum('debit_amount')) }}</th>
        <th class="text-right">{{ convertToMoney($transactions->sum('credit_amount')) }}</th>
      </tr>
    </tbody>
</table>