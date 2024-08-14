function toggleSubmitButton() {
  const checkedInputsCount = $('.subject-check:checked').length;
  $('#submit-button').attr('disabled', checkedInputsCount === 0);
}

$(document).on('click', '.table-checkbox tbody tr', function (e) {
  if (e.target.type !== 'checkbox' && !e.target.closest('label')) {
    const checkbox = $(this).find('input[type="checkbox"]');
    checkbox.prop('checked', !checkbox.is(':checked'));
  }

  toggleSubmitButton();
});

$(document).on('change', '.table-checkbox .subject-check', function (e) {
  const isChecked = $(this).is(':checked');
  $(this).closest('tr').find('.section-check').prop('checked', isChecked);
});

$(document).on('change', '.table-checkbox .section-check', function (e) {
  const isSubjectSectionsChecked = $(this).closest('td').find('.section-check:checked').length > 0;
  console.log(isSubjectSectionsChecked);
  $(this).closest('tr').find('.subject-check').prop('checked', isSubjectSectionsChecked);
});

$('#checkAll').change(function () {
  toggleSubmitButton();
});

$(function () {
  toggleSubmitButton();
});
