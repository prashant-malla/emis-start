function reserveAndSurplusRow(balance) {
  let rows = '<tr>';
  rows += `<th>${LEVEL_INDENT}Reserve & Surplus</th>`;
  rows += `<th class="text-right">${currency.convertToMoney(balance)}</th>`;
  rows += '</tr>';

  return rows;
}

function transactionRows(transactions, indent = '') {
  let rows = '';
  indent += LEVEL_INDENT;

  transactions.forEach((transaction) => {
    rows += '<tr>';
    rows += `<td>${indent}${transaction.ledger_account_name}</td>`;
    rows += `<td class="text-right">${currency.convertToMoney(transaction['balance'])}</td>`;
    rows += '</tr>';
  });
  return rows;
}

function recursiveCategoryRows(transactions, categories, indent = '') {
  let rows = '';
  indent += LEVEL_INDENT;

  categories.forEach((category) => {
    let row = '<tr>';
    row += `<th>${indent}${category.name}</th>`;
    row += `<th class="text-right"></th>`;
    row += '</tr>';

    rows += row;

    if (category.children.length > 0) {
      rows += recursiveCategoryRows(transactions, category.children, indent);
    }

    // self transactions
    const selfTransactions = transactions.filter((t) => t.account_category_id === category.id);
    if (selfTransactions.length > 0) {
      rows += transactionRows(selfTransactions, indent);
    }
  });

  return rows;
}

function categorySummaryRow(transactions, category, netIncome, idx) {
  const categoryTransactions = getCategoryTransactions(category, transactions);

  // sum net profit in liabilities side
  const balance = (category.type === 'Liabilities' ? Number(netIncome) : 0) + categoryTransactions.reduce((acc, transaction) => acc + Number(transaction['balance']), 0);

  let rows = '<tr class="tr-summary">';
  rows += `<th class="th-summary-title"><span class="summary-title">${idx}. ${category.name}</span></th>`;
  rows += `<th class="text-right">${currency.convertToMoney(balance)}</th>`;
  rows += '</tr>';

  return rows;
}

function generateTableRows(categories, transactions, netIncome) {
  let rows = '';

  categories.forEach((category, i) => {
    // main category row
    rows += '<tr>';
    rows += `<th class="text-primary">${i + 1}. ${category.name}</th>`;
    rows += `<th class="text-right"></th>`;
    rows += '</tr>';

    // recursive child category rows
    if (category.children.length > 0) {
      rows += recursiveCategoryRows(transactions, category.children);
    }

    // self transactions
    const selfTransactions = transactions.filter((t) => t.account_category_id === category.id);
    if (selfTransactions.length > 0) {
      rows += transactionRows(selfTransactions);
    }

    // reserve and surplus row
    if (category.type === 'Liabilities') {
      rows += reserveAndSurplusRow(netIncome);
    }

    // category summary row
    rows += categorySummaryRow(transactions, category, netIncome, i + 1);
  });

  return rows;
}

function filterBalanceSheet(filterUrl, data) {
  $.get(filterUrl, data)
    .then(function ({ categories, transactions, netIncome }) {
      $('#as-of-date').text(data.as_of);

      const rows = generateTableRows(formatCategories(categories), transactions, netIncome);
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
