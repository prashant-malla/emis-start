function initNepaliDatePicker(elm, format) {
  // update default value to be displayed in nepali
  // const defaultValue = $(elm).val();
  // if (defaultValue) {
  //   $(elm).val(NepaliFunctions.AD2BS(defaultValue));
  // }

  $(elm).attr('type', 'text'); // remove conflicting native datepicker where type = date
  $(elm).nepaliDatePicker({
    ndpYear: true,
    ndpMonth: true,
    // dateFormat: format.toUpperCase(),
    onChange: function () {
      $(elm).valid();
    },
  });
}

function initEnglishDatePicker(elm, format) {
  $(elm).attr("type", "date");
  // $(elm).pickadate({
  //   format: 'yyyy-mm-dd',
  //   selectMonths: true,
  //   selectYears: true,
  //   onSet: function () {
  //     $(elm).valid();
  //   },
  // });
}

function initDatePicker(elm, type, format) {
  type === 'np' ? initNepaliDatePicker(elm, format) : initEnglishDatePicker(elm, format);
}

function initTimePicker(elm) {
  $(elm).pickatime({
    min: new Date(2015, 3, 20, 6),
    max: new Date(2015, 3, 20, 18),
    onSet: function () {
      $(elm).valid();
    },
  });
}

$(function () {
  // old english datepicker
  $('.datepicker').each(function () {
    initDatePicker(this, 'en', systemDateFormat);
  });

  $('.system-datepicker').each(function () {
    initDatePicker(this, systemCalendarType, systemDateFormat);
  });

  $('.timepicker').each(function () {
    initTimePicker(this);
  });
});
