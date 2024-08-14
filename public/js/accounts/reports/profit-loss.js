function transactionRows(transactions, categoryType, totalRevenue, totalExpense, indent = '') {
  const amountTotal = categoryType === 'Income' ? totalRevenue : totalExpense;

  let rows = '';
  indent += LEVEL_INDENT;

  transactions.forEach((transaction) => {
    const amount = Number(transaction[getAmountKey(transaction.type)]);

    rows += '<tr>';
    rows += `<td>${indent}${transaction.ledger_account_name}</td>`;
    rows += `<td class="text-right">${currency.convertToMoney(amount)}</td>`;
    rows += `<td class="text-right">${amount > 0 ? ((amount / amountTotal) * 100).toFixed(2) : 0}%</td>`;
    rows += '</tr>';
  });
  return rows;
}

function recursiveCategoryRows(transactions, categories, totalRevenue, totalExpense, indent = '') {
  let rows = '';
  indent += LEVEL_INDENT;

  categories.forEach((category) => {
    let row = '<tr>';
    row += `<th>${indent}${category.name}</th>`;
    row += `<th class="text-right"></th>`;
    row += `<th class="text-right"></th>`;
    row += '</tr>';

    rows += row;

    if (category.children.length > 0) {
      rows += recursiveCategoryRows(transactions, category.children, totalRevenue, totalExpense, indent);
    }

    // self transactions
    const selfTransactions = transactions.filter((t) => t.account_category_id === category.id);
    if (selfTransactions.length > 0) {
      rows += transactionRows(selfTransactions, category.type, totalRevenue, totalExpense, indent);
    }
  });

  return rows;
}

function categorySummaryRow(transactions, category, totalRevenue, totalExpense, idx) {
  const categoryTransactions = getCategoryTransactions(category, transactions);
  const amount = categoryTransactions.reduce((acc, transaction) => acc + Number(transaction[getAmountKey(category.type)]), 0);

  const totalAmount = totalRevenue + totalExpense;
  const categoryPercentage = totalAmount > 0 ? ((amount / totalAmount) * 100).toFixed(2) : 0;

  let rows = '<tr class="tr-summary">';
  rows += `<th class="th-summary-title"><span class="summary-title">${idx}. ${category.name}</span></th>`;
  rows += `<th class="text-right">${currency.convertToMoney(amount)}</th>`;
  rows += `<th class="text-right">${categoryPercentage}%</th>`;
  rows += '</tr>';

  return rows;
}

function netTotalRow(totalRevenue, totalExpense, netIncome) {
  const tdClass = netIncome > 0 ? 'bg-success' : 'bg-danger';

  const totalAmount = totalRevenue + totalExpense;
  const netPercentage = totalAmount > 0 ? ((netIncome / totalAmount) * 100).toFixed(2) : 0;

  let row = '<tr class="bg-dark text-white tr-net-summary">';
  row += `<th class="text-right">Net Profit</th>`;
  row += `<th class="text-right ${tdClass}">${currency.convertToMoney(netIncome)}</th>`;
  row += `<th class="text-right ${tdClass}">${netPercentage}%</th>`;
  row += '</tr>';

  return row;
}

function generateTableRows(categories, transactions, totalRevenue, totalExpense, netIncome) {
  let rows = '';

  categories.forEach((category, i) => {
    // main category row
    rows += '<tr>';
    rows += `<th class="text-primary">${i + 1}. ${category.name}</th>`;
    rows += `<th class="text-right"></th>`;
    rows += `<th class="text-right"></th>`;
    rows += '</tr>';

    // recursive child category rows
    if (category.children.length > 0) {
      rows += recursiveCategoryRows(transactions, category.children, totalRevenue, totalExpense);
    }

    // self transactions
    const selfTransactions = transactions.filter((t) => t.account_category_id === category.id);
    if (selfTransactions.length > 0) {
      rows += transactionRows(selfTransactions, category.type, totalRevenue, totalExpense);
    }

    // category summary row
    rows += categorySummaryRow(transactions, category, totalRevenue, totalExpense, i + 1);
  });

  // Net total
  rows += netTotalRow(totalRevenue, totalExpense, netIncome);

  return rows;
}

function filterProfitLoss(filterUrl, data) {
  $.get(filterUrl, data)
    .then(function ({ categories, transactions, totalRevenue, totalExpense, netIncome }) {
      $('#from-date').text(data.from_date);
      $('#to-date').text(data.to_date);

      const rows = generateTableRows(formatCategories(categories), transactions, totalRevenue, totalExpense, netIncome);
      $('#report-table tbody').html(rows);

      $('#report-container').show();

      updateReportView();
      hideButtonLoader('#submit-button');
    })
    .catch(function (error) {
      hideButtonLoader('#submit-button');
      alertBox.showAlert(ALERT_TYPES.ERROR, error?.responseJSON?.message || DEFAULT_ERROR_MESSAGE);
    });
}
