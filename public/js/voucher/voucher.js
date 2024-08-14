function resetRows(rows) {
  rows.find('input, select').val('');
  return rows;
}

function toggleRemoveButton() {
  const tbody = $('#voucher-entry-table tbody');
  if (tbody.find('tr').length <= 1) {
    tbody.find('tr:first-child td:last-child .btn').hide();
  }
}

function removeRows(elm) {
  const row = $(elm).closest('tr');

  const hasValue = (element, name) => element.find(`input[name="${name}[]"]`).val();
  const rowHasValue = ['debit_amount', 'credit_amount'].some((name) => hasValue(row, name));

  if (rowHasValue && !confirm('Are you sure you want to remove?')) {
    return;
  }

  row.remove();

  toggleRemoveButton();
}

function addNewRows() {
  const tbody = $('#voucher-entry-table tbody');
  const rows = tbody.find('tr:eq(0)');

  // destroy select2 before clone
  rows.find('.select').select2('destroy');
  rows.find('input[name="debit_amount[]"], input[name="credit_amount[]"]').removeClass('disabled bg-light');

  const newRows = resetRows(rows.clone());

  // reapply select2 to select on both rows
  enableSelect2(rows);
  enableSelect2(newRows);

  tbody.append(newRows);
  tbody.find('tr td:last-child .btn').show();

  computeTotal();
}

function toggleDebitCreditInput(e) {
  const input = $(e.target);
  const inputs = input.closest('tr').find('input[name="debit_amount[]"], input[name="credit_amount[]"]');

  if (Number(input.val())) {
    inputs.not(input).val('').addClass('disabled bg-light');
  } else {
    inputs.removeClass('disabled bg-light');
  }
}

function updateRemainingDisplay(totalDebit, totalCredit){
  $('#voucher-entry-table tbody .remaining').text('');
  
  const remainingDebit = totalCredit - totalDebit;
  const remainingCredit = totalDebit - totalCredit;

  if(remainingDebit > 0){
    $('#voucher-entry-table tbody tr:last-child .remaining-debit').text(`Remaining: ${remainingDebit}`);
  }

  if(remainingCredit > 0){
    $('#voucher-entry-table tbody tr:last-child .remaining-credit').text(`Remaining: ${remainingCredit}`);
  }
}

function computeTotal() {
  let debitAmountTotal = 0;
  let creditAmountTotal = 0;

  $('#voucher-entry-table tbody tr').each(function () {
    const debitAmount = Number($(this).find('input[name="debit_amount[]"]').val());
    const creditAmount = Number($(this).find('input[name="credit_amount[]"]').val());
    debitAmountTotal += debitAmount;
    creditAmountTotal += creditAmount;
  });

  $('#voucher-entry-table tfoot #debit-amount-total').val(debitAmountTotal);
  $('#voucher-entry-table tfoot #credit-amount-total').val(creditAmountTotal);

  updateRemainingDisplay(debitAmountTotal, creditAmountTotal);
}

function isValidVoucherEntry(form) {
  if (!$(form).valid()) {
    return;
  }

  let isValid = true;

  $('#voucher-entry-table tbody tr').each(function () {
    const debitAmount = Number($(this).find('input[name="debit_amount[]"]').val());
    const creditAmount = Number($(this).find('input[name="credit_amount[]"]').val());
    if (!debitAmount && !creditAmount) {
      isValid = false;
    }
  });

  if (!isValid) {
    alert('Please fill data in debit or credit column of each row');
    return false;
  }

  const debitAmountTotal = Number($('#voucher-entry-table tfoot #debit-amount-total').val());
  const creditAmountTotal = Number($('#voucher-entry-table tfoot #credit-amount-total').val());
  isValid = debitAmountTotal === creditAmountTotal;

  if (!isValid) {
    alert('Debit Amount Total must be equal to Credit Amount Total');
    return false;
  }

  return true;
}

$(document).on('change', 'select[name="ledger_account_id[]"]', function () {
  const balanceInput = $(this).closest('tr').find('input.balance');

  if ($(this).val() !== '') {
    balanceInput.val($(this).find(':selected').attr('data-balance'));
  } else {
    balanceInput.val('');
  }
});

$(document).on('keyup change', 'input[name="debit_amount[]"], input[name="credit_amount[]"]', function (e) {
  toggleDebitCreditInput(e);
  computeTotal();
});

$('#payment-method').change(function () {
  const isBankPayment = $(this).val() === 'Bank';
  $('.col-cheque-number').toggle(isBankPayment).find('input').val('');
});

$('#voucher-type').change(function () {
  const showPaymentMethod = $(this).val() !== 'Journal';
  $('.col-payment-method').toggle(showPaymentMethod).find('select').val('').trigger('change');
});
