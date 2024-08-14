function transactionRows(transactions, categoryType, indent = '') {
  let rows = '';
  indent += LEVEL_INDENT;

  transactions.forEach((transaction) => {
    const balance = Number(transaction['balance']);
    rows += '<tr>';
    rows += `<td>${indent}${transaction.ledger_account_name}</td>`;
    rows += `<td class="text-right">${DEBIT_ACCOUNT_TYPES.includes(categoryType) ? currency.convertToMoney(balance) : ''}</td>`;
    rows += `<td class="text-right">${CREDIT_ACCOUNT_TYPES.includes(categoryType) ? currency.convertToMoney(balance) : ''}</td>`;
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
    row += `<th class="text-right"></th>`;
    row += '</tr>';

    rows += row;

    if (category.children.length > 0) {
      rows += recursiveCategoryRows(transactions, category.children, indent);
    }

    // self transactions
    const selfTransactions = transactions.filter((t) => t.account_category_id === category.id);
    if (selfTransactions.length > 0) {
      rows += transactionRows(selfTransactions, category.type, indent);
    }
  });

  return rows;
}

function categorySummaryRow(transactions, category, idx) {
  const categoryTransactions = getCategoryTransactions(category, transactions);
  const balance = categoryTransactions.reduce((acc, transaction) => acc + Number(transaction['balance']), 0);

  let rows = '<tr class="tr-summary">';
  rows += `<th class="th-summary-title"><span class="summary-title">${idx}. ${category.name}</span></th>`;
  rows += `<th class="text-right">${DEBIT_ACCOUNT_TYPES.includes(category.type) ? currency.convertToMoney(balance) : ''}</th>`;
  rows += `<th class="text-right">${CREDIT_ACCOUNT_TYPES.includes(category.type) ? currency.convertToMoney(balance) : ''}</th>`;
  rows += '</tr>';

  return rows;
}

function netTotalRow(transactions) {
  const debitNetTotal = transactions.filter((t) => DEBIT_ACCOUNT_TYPES.includes(t.type)).reduce((acc, transaction) => acc + Number(transaction['balance']), 0);
  const creditNetTotal = transactions.filter((t) => CREDIT_ACCOUNT_TYPES.includes(t.type)).reduce((acc, transaction) => acc + Number(transaction['balance']), 0);

  let row = '<tr class="bg-dark text-white tr-net-summary">';
  row += `<th class="text-right">Net Total</th>`;
  row += `<th class="text-right">${currency.convertToMoney(debitNetTotal)}</th>`;
  row += `<th class="text-right">${currency.convertToMoney(creditNetTotal)}</th>`;
  row += '</tr>';

  return row;
}

function generateTableRows(categories, transactions) {
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
      rows += recursiveCategoryRows(transactions, category.children);
    }

    // self transactions
    const selfTransactions = transactions.filter((t) => t.account_category_id === category.id);
    if (selfTransactions.length > 0) {
      rows += transactionRows(selfTransactions, category.type);
    }

    // category summary row
    rows += categorySummaryRow(transactions, category, i + 1);
  });

  // Net total
  rows += netTotalRow(transactions);

  return rows;
}

function filterTrialBalance(filterUrl, data) {
  $.get(filterUrl, data)
    .then(function ({ categories, transactions }) {
      $('#as-of-date').text(data.as_of);

      const rows = generateTableRows(formatCategories(categories), transactions);
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
