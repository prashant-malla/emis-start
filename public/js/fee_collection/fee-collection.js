function handleFeePayment(feePaymentUrl, data, form, triggerPrint) {
  clearFormErrors(form);

  $.post(feePaymentUrl, data)
    .then(function (response) {
      alertBox.showAlert(ALERT_TYPES.SUCCESS, response.message);
      hideButtonLoader('.submit-button');
      if(triggerPrint && response.printUrl){
        window.open(response.printUrl, '_blank', 'noopener, noreferrer');
      }
      location.reload();
    })
    .catch(function (error) {
      hideButtonLoader('.submit-button');
      if (error.status !== 500 && error?.responseJSON?.errors) {
        displayFormErrors(form, error.responseJSON.errors);
      } else {
        alertBox.showAlert(ALERT_TYPES.ERROR, error?.responseJSON?.message || DEFAULT_ERROR_MESSAGE);
      }
    });
}

function geSelectedFeeIds() {
  const selectedFeeIds = [];
  $('#feeTable .fee-check:checked').each(function () {
    selectedFeeIds.push({
      assignFeeId: $(this).val(),
      paidAmount: $(this).closest('tr').attr('data-amount'),
    });
  });
  return selectedFeeIds;
}

function serialize(data) {
  let obj = {};
  for (let [key, value] of data) {
    if (obj[key] !== undefined) {
      if (!Array.isArray(obj[key])) {
        obj[key] = [obj[key]];
      }
      obj[key].push(value);
    } else {
      obj[key] = value;
    }
  }
  return obj;
}

$('.submit-button').click(function (e) {
  e.preventDefault();

  const form = $(this).closest('form');
  if (!form.valid()) {
    return;
  }

  const triggerPrint = $(this).data('print');
  const formData = new FormData(form[0]);
  $('#fineForm table tbody .fine-check:checked').each(function () {
    formData.append('fine_id[]', $(this).val());
  });

  showButtonLoader('.submit-button');

  const feePaymentUrl = form.attr('action');
  handleFeePayment(feePaymentUrl, serialize(formData), form, triggerPrint);
});

function updateFinalDue() {
  const feeDue = $('.fee-check:checked')
    .map(function () {
      return Number($(this).closest('tr').attr('data-amount'));
    })
    .get()
    .reduce(function (acc, value) {
      return acc + value;
    }, 0);

  const totalFine = $('#fineForm table tbody .fine-check:checked')
    .map(function () {
      return Number($(this).closest('tr').attr('data-fine-amount'));
    })
    .get()
    .reduce(function (acc, value) {
      return acc + value;
    }, 0);

  // const discount = Number($('input[name="discount_amount"]').val());
  const totalPaid = Number($('input[name="paid_amount"]').val());

  let finalDue = feeDue + Number(oldDue) + totalFine - totalPaid;
  let advanceAmount = Number(advance);

  if (finalDue < 0) {
    advanceAmount = advanceAmount + finalDue * -1;
    finalDue = 0;
  }

  $('#final-due-display').text(currency.convertToMoney(finalDue));
  $('#advance-display').text(currency.convertToMoney(advanceAmount));
}

$('#checkAll, .fee-check').change(function () {
  updateFinalDue();
});

$('#totalDiscountAmount, #totalPaidAmount').keyup(function () {
  updateFinalDue();
});

function updateTotalFine() {
  const totalFine = $('#fineForm table tbody .fine-check:checked')
    .map(function () {
      return Number($(this).closest('tr').attr('data-fine-amount'));
    })
    .get()
    .reduce(function (acc, value) {
      return acc + value;
    }, 0);

  $('#totalFineCalculated').val(currency.convertToMoney(totalFine));
  $('#totalFineAmount').val(totalFine);
  $('input[name="paid_amount"]').attr('min', totalFine);

  updateFinalDue();
}

function populateFine(fine) {
  $('#fineForm table tbody').prepend(`
    <tr data-fine-amount="${fine.amount}">
      <td>
          <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input fine-check"
                  id="fine_${fine.id}" name="fine_id[]" value="${fine.id}" checked>
              <label class="custom-control-label" for="fine_${fine.id}"></label>
          </div>
      </td>
      <td>
          <input type="text" class="form-control" value="${fine.title}" readonly>
      </td>
      <td class="text-right">
          <input type="text" class="form-control" value="${currency.convertToMoney(fine.amount)}" readonly>
      </td>
      <td></td>
    </tr>
  `);

  updateTotalFine();
}

function handleFinePayment(fineSaveUrl, data, form) {
  $.post(fineSaveUrl, data)
    .then(function (fine) {
      $(form).trigger('reset');
      populateFine(fine);
      hideButtonLoader('#fine-submit-button');
    })
    .catch(function (error) {
      hideButtonLoader('#fine-submit-button');
      alertBox.showAlert(ALERT_TYPES.ERROR, error?.responseJSON?.message || DEFAULT_ERROR_MESSAGE);
    });
}

$('#fineForm').submit(function (e) {
  e.preventDefault();
  if (!$(this).valid()) {
    return;
  }

  showButtonLoader('#fine-submit-button');

  const fineSaveUrl = $(this).attr('action');
  handleFinePayment(fineSaveUrl, $(this).serialize(), this);
});

$('.fine-check').change(function () {
  updateTotalFine();
});

// $.ajaxSetup({
//   headers: {
//     'X-CSRF-TOKEN': '{{csrf_token()}}',
//   },
// });

// $('.check-student').change(function () {
//   if ($(this).is(':checked')) {
//     $(this).closest('tr').find('.paidAmount').removeAttr('disabled');
//   } else {
//     $(this).closest('tr').find('.paidAmount').attr('disabled', '').val('');
//   }
// });

// $('#checkAll').change(function () {
//   if ($(this).is(':checked')) {
//     $(this).closest('table').find('.check-student').closest('td').siblings().find('.paidAmount').removeAttr('disabled');
//   } else {
//     $(this).closest('table').find('.check-student').closest('tr').find('.paidAmount').attr('disabled', '').val('');
//   }
// });

// $('#savePayment').click(function () {
//   const form = $(this).closest('form');
//   if (form.valid()) {
//     alert('pay now');
//   }
//   $.ajax({
//     type: 'POST',
//     url: '/paid_fee/store',
//     data: formData,
//     processData: false,
//     contentType: false,
//     success: function (response) {
//       console.log(response);
//       location.reload();
//     },
//   });
// });

// $('#paidFeeForm').submit(function (event) {
//   event.preventDefault();
//   $('.check-student').change(function () {
//     let payment_mode = $('#payment_mode').find(':selected').val();
//     let totalPaidAmount = $('#totalPaidAmount').val();
//     if (payment_mode == '') {
//       $('#payment_mode_error_msg').append(`<span class="text-danger">Payment Mode is Required</span>`);
//       return;
//     }
//     if (totalPaidAmount == '') {
//       $('#paid_amount_error_msg').append(`<span class="text-danger">Total Paid Amount is Required</span>`);
//       return;
//     }
//   });

//   let formData = new FormData(this);
//   $('#feeTable tbody .check-student:checked').each(function () {
//     let paidAmount = $(this).closest('tr').find('.paidAmount').val();
//     if (paidAmount === '') {
//       // alert("Paid Amount is Required");
//       $('#paid_amount_error_msg').append(`<span class="text-danger">Paid Amount is Required</span><br>`);
//       return;
//     }
//     let tr = $(this).closest('tr');
//     let monthName = tr.find('.month_name').text();
//     let feesType = tr.find('.fee_type').text();
//     let dueDate = tr.find('.dueDate').text();
//     let feeAmount = tr.find('.feeAmount').text();
//     let discount = tr.find('.payDiscount').text();
//     let fineAmount = tr.find('.fineAmount').text();
//     let previousSessionFee = tr.find('.previousSessionFee').text();
//     let balance = tr.find('.balanceAmount').text();
//     formData.append('feesType[]', feesType);
//     formData.append('monthName[]', monthName);
//     formData.append('dueDate[]', dueDate);
//     formData.append('feeAmount[]', feeAmount);
//     formData.append('discount[]', discount);
//     formData.append('fineAmount[]', fineAmount);
//     formData.append('previousSessionFee[]', previousSessionFee);
//     formData.append('balance[]', balance);
//   });

//   $.ajax({
//     type: 'POST',
//     url: '/paid_fee/store',
//     data: formData,
//     processData: false,
//     contentType: false,
//     success: function (response) {
//       console.log(response);
//       location.reload();
//     },
//   });
// });

// function payFee(){
//validation
// let payment_mode = $('#payment_mode').find(":selected").val();
// let paidAmount = $('#paidAmount').val();
// if (payment_mode == ""){
//     $('#payment_mode_error_msg').append(`<span class="text-danger">Payment Mode is Required</span>`)
//     return;
// }
// if (paidAmount == ""){
//     $('#paid_amount_error_msg').append(`<span class="text-danger">Amount is Required</span>`)
//     return;
// }
// let form = document.getElementById('payForm');
// let formData = new FormData(form);
// $('#example3 tbody .check-student:checked').each(function (){
//    let tr = $(this).closest('tr');
//    let fee_type_id = tr.find('.fee_type').attr('data-fee_type_id');
//    let feesType = tr.find('.fee_type').text();
//    let monthName = tr.find('.month_name').text();
//     let dueDate = tr.find('.dueDate').text();
//     let feeAmount = tr.find('.feeAmount').text();
//     let discount = tr.find('.payDiscount').text();
//     let fineAmount = tr.find('.fineAmount').text();
//     let previousSessionFee = tr.find('.previousSessionFee').text();
//     let balance = tr.find('.balanceAmount').text();
//    formData.append('fee_type_id[]', fee_type_id);
//    formData.append('feesType[]', feesType);
//    formData.append('monthName[]', monthName);
//    formData.append('dueDate[]', dueDate);
//    formData.append('feeAmount[]', feeAmount);
//    formData.append('discount[]', discount);
//    formData.append('fineAmount[]', fineAmount);
//    formData.append('previousSessionFee[]', previousSessionFee);
//    formData.append('balance[]', balance);
// });
// console.log(...formData);
// $.ajax({
//     type: 'POST',
//     url: '/paid_fee/store',
//     data: formData,
//     processData: false,
//     contentType: false,
//     success: function (response) {
//         console.log(response);
//         location.reload();
//     }
// });
// }
