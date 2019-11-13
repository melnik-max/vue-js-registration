'use strict';

(function ($) {

  $('#birth_date').datepicker({
    maxDate: '0',
    dateFormat: 'yy-mm-dd',
    yearRange: '-100:+0',
    changeMonth: true,
    changeYear: true
  })

  $('#phone_number').inputmask('+9 (999) 999-9999')

})(jQuery)