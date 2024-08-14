<table id="report-table" class="table table-bordered">
    <thead>
      <tr class="bg-dark text-white">
        <th>Account</th>
        <th class="text-right" width="25%">Amount</th>
        <th class="text-right" width="25%">Percentage</th>
      </tr>
    </thead>
    <tbody>
      @foreach($categories as $category)

        @php
          $spacing='';
          $accountType = $category->type;
          $ledgerAccountsGroupedByLeafCategory = $transactions->groupBy('account_category_id');
        @endphp

        <tr>
          <th class="text-primary">{{$loop->iteration}}. {{ $category->name }}</th>
          <th class="text-right"></th>
          <th class="text-right"></th>
        </tr>     

        {{-- Nested Category Rows --}}
        @includeWhen($category->allChildren->isNotEmpty(), 'pages.account.reports.profit_loss.partials.sub-category-row', [
          'subCategories' => $category->allChildren
        ])

        {{-- Self Transactions --}}
        @php($selfLedgerAccounts = $transactions->where('account_category_id', $category->id))
        @includeWhen($selfLedgerAccounts->isNotEmpty(), 'pages.account.reports.profit_loss.partials.ledger-account-rows', [
            'leafLedgerAccounts' => $selfLedgerAccounts
        ])

        {{-- Main Category Summary --}}
        @include('pages.account.reports.profit_loss.partials.category-summary-row')

        @endforeach

        {{-- Net Total Row --}}
        <tr class="bg-dark text-white tr-net-summary">
          <th class="text-right">Net Profit</th>
          <th @class(['text-right', 'bg-success' => $netIncome > 0, 'bg-danger' => $netIncome < 0])>{{ convertToMoney($netIncome) }}</th>
          <th @class(['text-right', 'bg-success' => $netIncome > 0, 'bg-danger' => $netIncome < 0])>
            {{ ($totalRevenue + $totalExpense) > 0 ? round(($netIncome / ($totalRevenue + $totalExpense)) * 100, 2) : 0 }}%
          </th>
        </tr>
    </tbody>
</table>