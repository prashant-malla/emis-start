function confirmDelete() {
  return confirm('Are you sure want to delete?');
}

// clone helpers
function deleteRow(element) {
  $(element).closest('tbody').find('tr').length > 1 && $(element).closest('tr').remove();
}

function disableSelect2(container) {
  $(container).find('select.select')?.select2('destroy');
}

function enableSelect2(container) {
  $(container).find('select.select')?.select2({
    width: 'resolve',
    theme: 'classic',
  });
}

function resetInputs(container) {
  $(container).find('input, select, textarea').not(':hidden').val('');
}

function cloneLastRow(tableId) {
  const lastRow = $(tableId).find('tbody tr:last-child');
  if (!lastRow) return;

  disableSelect2(lastRow);
  const newRow = lastRow.clone();

  resetInputs(newRow);
  enableSelect2(lastRow);
  enableSelect2(newRow);
  $(tableId).find('tbody').append(newRow);
}

function clearRow(element) {
  resetInputs($(element).closest('tr'));
}

// loader helpers
function showButtonLoader(element) {
  $(element).addClass('loading');
}

function hideButtonLoader(element) {
  $(element).removeClass('loading');
}

function showSelectLoader(element) {
  $(element).prop('disabled', true).html('<option value="">Loading...</option>');
}

function hideSelectLoader(element) {
  $(element).prop('disabled', false);
}

function enableDisableTableButton(table, button) {
  const bodyRowsCount = $(table).find('tbody tr').length;
  $(button).prop('disabled', bodyRowsCount <= 0);
}

// validation helpers
function validAllInputs(selector) {
  let valid = true;
  $(selector)
    .find('.form-control')
    .each(function (_, input) {
      if (!$(input).valid()) {
        valid = false;
      }
    });
  return valid;
}

function createDeleteFileInput(name) {
  const deleteFileInput = document.createElement('input');

  deleteFileInput.setAttribute('type', 'hidden');
  deleteFileInput.setAttribute('class', 'deleteFile');
  deleteFileInput.setAttribute('name', 'delete_' + name);
  deleteFileInput.value = 1;

  return deleteFileInput;
}

function addDeleteFileInput(e) {
  const hasOldFile = !!$(e.target).attr('data-default-file');
  if (!hasOldFile) return;

  const drWrapperElement = $(e.target).closest('.dropify-wrapper');

  // delete input already exists
  if (drWrapperElement.find('input.deleteFile').length > 0) return;

  // create and append new delete input
  drWrapperElement.append(createDeleteFileInput($(e.target).attr('name')));
}

function getCreditHourLabel(courseType = 'semester') {
  const labels = {
    semester: 'Credit Hour',
    year: 'Lecture Hours/ Total Period',
  };

  return labels[courseType] ?? labels['semester'];
}
