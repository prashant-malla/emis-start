function setSelectedByDataAttrOnce(selectInstance) {
  const activeId = selectInstance.attr('data-selected');
  activeId && selectInstance.val(activeId) && selectInstance.removeAttr('data-selected');
}

async function getAssignedSubjectsByYearSemesterId(yearSemesterId) {
  if (!yearSemesterId) {
    return DEFAULT_SELECT;
  }

  return new Promise((resolve) => {
    $.get(`/assigned-subjects/${yearSemesterId}`, function (response) {
      const data = JSON.parse(response);
      let optionsHtml = DEFAULT_SELECT;
      data.forEach(function ({ subject }) {
        optionsHtml += `<option value="${subject.id}">${subject.name}</option>`;
      });
      resolve(optionsHtml);
    });
  });
}

$(function () {
  $('#level_id').change(async function () {
    const levelId = $(this).val();
    const targetSelect = $('#program_id');
    showSelectLoader(targetSelect);

    const options = await getProgramsOptions(levelId, true);
    targetSelect.html(options);

    // set initial value for edit
    setSelectedByDataAttrOnce(targetSelect);

    hideSelectLoader(targetSelect);
    targetSelect.trigger('change');
  });

  $('#program_id').change(async function () {
    const programId = $(this).val();
    const targetSelect = $('#year_semester_id');
    showSelectLoader(targetSelect);

    const options = await getYearSemesterOptions(programId, true);
    targetSelect.html(options);

    // set initial value for edit
    setSelectedByDataAttrOnce(targetSelect);

    hideSelectLoader(targetSelect);
    targetSelect.trigger('change');
  });

  $('#year_semester_id').change(async function () {
    const yearSemesterId = $(this).val();
    const targetSelect = $('#subject_id');
    showSelectLoader(targetSelect);

    const options = await getAssignedSubjectsByYearSemesterId(yearSemesterId);
    targetSelect.html(options);

    // set initial value for edit
    setSelectedByDataAttrOnce(targetSelect);

    hideSelectLoader(targetSelect);
    targetSelect.trigger('change');
  });

  CKEDITOR.replace('learning_objective');
  CKEDITOR.replace('learning_tool');
  CKEDITOR.replace('learning_outcome');
  CKEDITOR.replace('evaluation_method');

  $('#level_id').val() && $('#level_id').trigger('change');
});

// function resetClone(){
//     $('.multiple_template .clone_item').removeClass('bg-light border pt-1 px-2');
//     $('.multiple_template > div:not(:first-child)').remove();
//     $('.multiple_template').find('input, select').val('');
//     $('.addCard, .removeCard').hide();
//     $('.section').html(`<option value="" disabled selected>Processing...</option>`);
// }

// function hasMoreOptions(){
//     const sectionItems = $('select[name="section_id[]"]').eq(0).find('option').length  - 1;
//     const cloneCount = $('.multiple_template > div').length;
//     return cloneCount < sectionItems;
// }

// $('#year_semester_id').on('change', function () {
//     resetClone();
//     const id = $(this).val();

//     $.ajax({
//         type: 'GET',
//         url: '/getSections/' + id,
//         success: function (response) {
//             response = JSON.parse(response);

//             $('.section').html(`<option value="" disabled selected>Select Group</option>`);
//             $('.subject').html(`<option value="" disabled selected>Select Subject</option>`);

//             response.forEach(element => {
//                 $('.section').append(`<option value="${element['id']}">${element['group_name']}</option>`);
//             });

//             if(response.length > 1){
//                 $('.multiple_template .clone_item').addClass('bg-light border pt-1 px-2');
//                 $('.addCard').show();
//             }
//         }
//     });
// });

// $(document).ready(function() {
//     $('.addCard').click(function(){
//         $('.multiple_template .addCard').hide();

//         const itemToClone = $('.multiple_template > div:first').clone(true);
//         itemToClone.find('input, select').val('');
//         itemToClone.find('.removeCard').show();

//         $('.multiple_template').append(itemToClone);

//         if(hasMoreOptions()){
//             itemToClone.find('.addCard').show();
//         }
//     });

//     $(document).on('click', '.removeCard', function() {
//         $(this).closest('.clone_item').remove();
//         $('.multiple_template > div:last-child .addCard').show();
//     });
// });

// $('.section').on('change', function () {
//     let id = $(this).val();
//     const subjectSelect = $(this).closest('.clone_item').find('.subject');
//     subjectSelect.empty();
//     subjectSelect.append(`<option value="" disabled selected>Processing...</option>`);
//     $.ajax({
//         type: 'GET',
//         url: '/assigned-subjects/' + id,
//             success: function (response) {
//                 response = JSON.parse(response);
//                 // console.log(response);
//                 let options = `<option value="" disabled selected>Select Subject</option>`
//                 response.forEach(element => {
//                     options += `<option value="${element['subject']['id']}">${element['subject']['name']}</option>`;
//                 });
//                 subjectSelect.html(options);
//             }
//     });
// });
