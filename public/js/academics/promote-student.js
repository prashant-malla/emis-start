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
  targetSelect.trigger('change');
});

$('#year_semester_id').change(async function () {
  const yearSemesterId = $(this).val();
  const targetSelect = $('#section_id');
  showSelectLoader(targetSelect);

  const options = await getSectionOptions(yearSemesterId);
  targetSelect.html(options);

  hideSelectLoader(targetSelect);
});

$('#to_academic_year_id').change(async function () {
  const batchId = $('#batch_id').val();
  const programId = $('#to_program_id').val();
  const academicYearId = $(this).val();
  const targetSelect = $('#to_year_semester_id');
  showSelectLoader(targetSelect);

  const options = await getProgramYearSemesterOptions(programId, {
    academicYearId,
    batchId,
  });
  targetSelect.html(options);

  hideSelectLoader(targetSelect);
  targetSelect.trigger('change');
});

$('#to_year_semester_id').change(async function () {
  const yearSemesterId = $(this).val();
  const targetSelect = $('.student-section-select');
  showSelectLoader(targetSelect);

  const options = await getSectionOptions(yearSemesterId);
  targetSelect.html(options);

  // update default values
  targetSelect.each(function () {
    if ($(this).attr('data-default')) {
      $(this).val($(this).attr('data-default'));
    }
  });

  hideSelectLoader(targetSelect);
});

$('#master-student-section-select').change(function () {
  const sectionId = $(this).val();
  $('.student-section-select').val(sectionId);
});

$('#promote-button').click(function () {
  const promoteForm = $(this).closest('form');
  if (!promoteForm.valid()) return;

  showButtonLoader(this);
  promoteForm.submit();
});
