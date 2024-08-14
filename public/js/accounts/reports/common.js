const LEVEL_INDENT = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
const DEBIT_ACCOUNT_TYPES = ['Assets', 'Expenses'];
const CREDIT_ACCOUNT_TYPES = ['Liabilities', 'Equity', 'Income'];

function getAbsoluteValue($value) {
  return Math.abs($value);
}

function getChildIds(items, parentId) {
  const result = [];
  for (const item of items) {
    if (item.parent_id === parentId) {
      result.push(item.id, ...getChildIds(items, item.id));
    }
  }
  return result;
}

function buildHierarchy(items, parentId = null) {
  const result = [];
  for (const item of items) {
    if (item.parent_id === parentId) {
      item.children = buildHierarchy(items, item.id);
      result.push(item);
    }
  }
  return result;
}

function formatCategories(categories) {
  return buildHierarchy(categories).map((category) => {
    category.childIds = getChildIds(categories, category.id);
    return category;
  });
}

function getAmountKey(type) {
  return type === 'Income' ? 'credit_amount' : 'debit_amount';
}

function getBalanceDrCr(balance, balanceType) {
  if (balanceType === 'debit') {
    return balance >= 0 ? 'Dr.' : 'Cr.';
  } else {
    return balance >= 0 ? 'Cr.' : 'Dr.';
  }
}

function getCategoryTransactions(category, transactions) {
  // for parent category, simply check type
  if (category.parent_id === null) {
    return transactions.filter((transaction) => transaction.type === category.type);
  }

  // for non parent category, check transactions that belongs to category(self), subcategories
  const childIds = [category.id, ...category.childIds];
  return transactions.filter((transaction) => childIds.includes(transaction.account_category_id));
}

function updateReportView(detailed = false) {
  const rows = $('#report-table tbody tr');
  rows.hide();

  const rowsToShow = rows.filter(function (_, tr) {
    return detailed ? true : $(tr).hasClass('tr-summary') || $(tr).hasClass('tr-net-summary');
  });

  $('#report-table .tr-summary').toggleClass('detailed-view', detailed);
  rowsToShow.show();
}
