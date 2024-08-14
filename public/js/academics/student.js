function toggleStudentStatusFields(status) {
  if (Number(status) !== STUDENT_STATUS_TYPES.ACTIVE) {
    $('.student-status-remarks, .student-status-date').show();
  } else {
    $('.student-status-remarks, .student-status-date').hide().find('input, textarea').val('');
  }
}

$(function () {
  $('#level_id').change(async function () {
    const levelId = $(this).val();
    const targetSelect = $('#program_id');
    showSelectLoader(targetSelect);

    const options = await getProgramsOptions(levelId);
    targetSelect.html(options);

    hideSelectLoader(targetSelect);

    targetSelect.trigger('change');
  });

  $('#academic_year_id, #batch_id, #program_id').change(async function () {
    const programId = $('#program_id').val();
    const academicYearId = $('#academic_year_id').val();
    const batchId = $('#batch_id').val();

    const targetSelect = $('#year_semester_id');
    showSelectLoader(targetSelect);

    const options = await getProgramYearSemesterOptions(programId, {
      academicYearId,
      batchId,
    });

    targetSelect.html(options);
    hideSelectLoader(targetSelect);

    // reset year semester filter
    targetSelect.trigger('change');
  });

  $('#year_semester_id').change(async function () {
    const yearSemesterId = $(this).val();
    const targetSelect = $('#section_id');
    showSelectLoader(targetSelect);

    const options = await getSectionOptionsByYearSemesterId(yearSemesterId);
    targetSelect.html(options);

    hideSelectLoader(targetSelect);
  });

  $('#status').change(function () {
    toggleStudentStatusFields($(this).val());
  });

  $('#status').trigger('change');
});
