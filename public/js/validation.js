function clearFormErrors(formInstance, fieldInstance = '.clearable'){
  $(fieldInstance, formInstance).empty();
}

function displayFormErrors(formInstance, errors){
  if(!errors) return;
  
  for(const key in errors){
    $(`#${key}_error_msg`, formInstance).html(errors[key][0]);
  }
}

function validateForm(formSelector, basic) {
  $(formSelector).validate({
    errorPlacement: function (e, a) {
      !basic && (a).parents('.form-group').append(e);
    },
  });
}

$(function () {
  validateForm('form.validate');
  validateForm('form.validate-basic', true);
});