function netTotalRow(transactions, previousBalance, balanceType) {
  let debitNetTotal = 0;
  let creditNetTotal = 0;
  let balanceNetTotal = Number(previousBalance);

  transactions.forEach((transaction) => {
    debitNetTotal += parseFloat(transaction['debit_amount']);
    creditNetTotal += parseFloat(transaction['credit_amount']);
    balanceNetTotal += parseFloat(transaction['balance']);
  });

  let row = '';

  row += '<tr class="bg-dark text-white tr-net-summary">';
  row += `<th colspan="5" class="text-right">Net Total</th>`;
  row += `<th class="text-right">${currency.convertToMoney(debitNetTotal)}</th>`;
  row += `<th class="text-right">${currency.convertToMoney(creditNetTotal)}</th>`;
  row += `<th class="text-right">${currency.convertToMoney(getAbsoluteValue(balanceNetTotal))}</th>`;
  row += `<th>${getBalanceDrCr(balanceNetTotal, balanceType)}</th>`;
  row += '</tr>';

  return row;
}

function getPreviousBalanceDescription(isOpeningBalance) {
  return isOpeningBalance ? 'Opening Balance' : 'Previous Balance';
}

function generatePreviousBalanceRow(previousBalance, isOpeningBalance, balanceType, date) {
  let rows = '';
  rows += '<tr>';
  rows += `<td>${date}</td>`;
  rows += `<td></td>`;
  rows += `<td></td>`;
  rows += `<td>${getPreviousBalanceDescription(isOpeningBalance)}</td>`;
  rows += `<td class="text-right"></td>`;
  rows += `<td class="text-right"></td>`;
  rows += `<td class="text-right"></td>`;
  rows += `<td class="text-right">${currency.convertToMoney(getAbsoluteValue(previousBalance))}</td>`;
  rows += `<td>${getBalanceDrCr(previousBalance, balanceType)}</td>`;
  rows += '</tr>';
  return rows;
}

function generateTableRows(transactions, previousBalance, isOpeningBalance, balanceType, fromDate) {
  let rows = generatePreviousBalanceRow(previousBalance, isOpeningBalance, balanceType, fromDate);

  let closingBalance = Number(previousBalance);
  transactions.forEach((transaction) => {
    closingBalance += Number(transaction.balance);
    rows += '<tr>';
    rows += `<td>${transaction.date}</td>`;
    rows += `<td>${transaction.voucher_number}</td>`;
    rows += `<td>${transaction.cheque_number || ''}</td>`;
    rows += `<td>${transaction.description || ''}</td>`;
    rows += `<td></td>`;
    rows += `<td class="text-right">${currency.convertToMoney(transaction.debit_amount)}</td>`;
    rows += `<td class="text-right">${currency.convertToMoney(transaction.credit_amount)}</td>`;
    rows += `<td class="text-right">${currency.convertToMoney(getAbsoluteValue(closingBalance))}</td>`;
    rows += `<td>${getBalanceDrCr(closingBalance, balanceType)}</td>`;
    rows += '</tr>';
  });

  // Net total
  rows += netTotalRow(transactions, previousBalance, balanceType);

  return rows;
}

function filterLedgerDetail(filterUrl, data) {
  $.get(filterUrl, data)
    .then(function ({ transactions, previousBalance, isOpeningBalance, balanceType }) {
      $('#from-date').text(data.from_date);
      $('#to-date').text(data.to_date);

      const rows = generateTableRows(transactions, previousBalance, isOpeningBalance, balanceType, data.from_date);
      $('#report-table tbody').html(rows);

      $('#report-container').show();

      hideButtonLoader('#submit-button');
    })
    .catch(function (error) {
      hideButtonLoader('#submit-button');
      alertBox.showAlert(ALERT_TYPES.ERROR, error?.responseJSON?.message || DEFAULT_ERROR_MESSAGE);
    });
}
