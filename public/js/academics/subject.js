function getYearSemesterNumberOptions(courseType) {
  if (!Object.values(COURSE_TYPES).includes(courseType)) {
    return DEFAULT_SELECT;
  }

  const courseTypeNumbers = courseType === COURSE_TYPES.YEAR ? YEAR_NUMBERS : SEMESTER_NUMBERS;

  let optionsHtml = DEFAULT_SELECT;
  Object.entries(courseTypeNumbers).forEach(([key, value]) => {
    optionsHtml += `<option value="${value}">${value}</option>`;
  });

  return optionsHtml;
}

function updateCreditHourLabel(formGroup, courseType) {
  const creditHourLabel = getCreditHourLabel(courseType);
  console.log(formGroup, creditHourLabel);
  $('.form-label', formGroup).text(creditHourLabel);
  $('.form-control', formGroup).attr('placeholder', 'Enter ' + creditHourLabel);
}

function toggleMarksFields(subjectType) {
  const theoryFields = $('#theory_full_marks, #theory_pass_marks');
  const practicalFields = $('#practical_full_marks, #practical_pass_marks');

  switch (subjectType) {
    case SUBJECT_TYPES.THEORY:
      theoryFields.show();
      practicalFields.hide().find('input').val('');
      break;

    case SUBJECT_TYPES.PRACTICAL:
      theoryFields.hide().find('input').val('');
      practicalFields.show();
      break;

    case SUBJECT_TYPES.THEORY_PRACTICAL:
      theoryFields.show();
      practicalFields.show();
      break;

    default:
      theoryFields.hide().find('input').val('');
      practicalFields.hide().find('input').val('');
      break;
  }
}

$('#level_id').change(async function () {
  const levelId = $(this).val();
  const targetSelect = $('#program_id');
  showSelectLoader(targetSelect);

  const options = await getProgramsOptions(levelId);
  targetSelect.html(options);

  hideSelectLoader(targetSelect);
  targetSelect.trigger('change');
});

$('#program_id').change(function () {
  const programType = $(':selected', this).attr('data-type');
  $('#year_semester_number').html(getYearSemesterNumberOptions(programType));
  updateCreditHourLabel('#credit_hour-group', programType);
});

$('#subjectType').change(function () {
  toggleMarksFields($(this).val());
});

$(function () {
  $('#subjectType').trigger('change');
});
