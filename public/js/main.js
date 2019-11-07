'use strict';

(function ($) {

  let membersTable = new Vue({
    el: '#members-table',
    data: {
      members: []
    },
    mounted: function () {
      axios.get('/get-members')
        .then(function (resp) {
          membersTable.members = resp.data;
          console.log(resp.data)
        })
        .catch(function (resp) {
          console.error(resp)
        })
    }
  })

  let registerForm = new Vue({
    el: '#register-form',
    data: {
      countries: []
    },
    mounted: function () {
      this.getCountries()
    },
    methods: {
      getCountries: function () {
        axios.get('/get-countries')
          .then(function (resp) {
            registerForm.countries = resp.data;
          })
          .catch(function (resp) {
            console.error(resp)
          })
      },
      createMember: function () {
        let formData = $('#register-form').serialize()
        axios.post('/members/create', formData)
          .then(function (response) {
            console.log(response.data)
            if (Array.isArray(response.data)) {
              $('#errors').removeClass('hidden').empty()
              response.data.reverse().forEach(function (item) {
                showErrorMessage('#errors', item)
              })
            } else {
              $('#register-form, #errors').addClass('hidden')
              $('#more-info-form').removeClass('hidden')
            }
          })
          .catch(function (error) {
            console.error(error)
          })
      }
    }
  })

  /*$.ajax({
    url: '/isLogged',
    type: 'GET',
    success: function (response) {
      if (response === 'true') {
        register_form.addClass("hidden")
        more_info_form.removeClass("hidden")
      }
    }
  })*/

  $('#birth_date').datepicker({
    maxDate: '0',
    dateFormat: 'yy-mm-dd',
    yearRange: '-100:+0',
    changeMonth: true,
    changeYear: true
  })

  $('#phone_number').inputmask('+9 (999) 999-9999')

  function showErrorMessage (selector, text) {
    $(selector).prepend('<strong class="text-danger">' + text + '</strong><br>')
  }

  /*$(document).on('click', '#to_more_info_form', function () {
    let form_data = register_form.serialize()

    $.ajax({
      url: '/members/create',
      type: 'POST',
      dataType: 'json',
      data: {
        'form_data': form_data
      },

      statusCode: {
        200: function () {
          register_form.addClass("hidden")
          errors.addClass("hidden")
          more_info_form.removeClass("hidden")
        },
        422: function (response) {
          errors.removeClass("hidden")
          errors.empty()

          let data = JSON.parse(response.responseText)
          data.forEach(function (item) {
            showErrorMessage('#errors', item)
          })
        }
      }
    })
  })*/

  /*

  $(document).on('click', '#back-to-register-form', function () {
    $.ajax({
      url: '/currentMember',
      type: 'GET',
      dataType: 'json',

      success: function (response) {
        for (let key in response) {
          if (response.hasOwnProperty(key)) {
            if (response[key] != null) {
              if (key === 'country') {
                $('#country').val(response[key]).change()
              } else if (key === 'phone_number') {
                $('#phone_number').inputmask('setvalue', response[key])
              }
              else {
                $('#' + key).attr('value', response[key])
              }
            }
          }
        }
      }
    })

    more_info_form.addClass("hidden")
    register_form.removeClass("hidden")
  })

  let maxFileSize = 2000 * 1024
  $('#photo').on('change', function () {
    if (this.files[0].size > maxFileSize) {
      errors.removeClass("hidden")
      errors.empty()
      showErrorMessage('#errors', 'Image file size cannot be more than 2 MB')
      $('#photo').replaceWith('<input type="file" accept="image/!*" class="form-control-file" name="photo" id="photo">')
    }
  })

  more_info_form.submit(function (e) {
    e.preventDefault()
    let formData = new FormData(this)

    $.ajax({
      url: '/members/update',
      type: 'POST',
      data: formData,

      statusCode: {
        200: function () {
          $('#form_header').addClass("hidden")
          more_info_form.addClass("hidden")
          errors.addClass("hidden")
          social.removeClass("hidden");
        },
        422: function (response) {
          errors.removeClass("hidden");
          errors.empty()
          let data = JSON.parse(response.responseText)
          data.forEach(function (item) {
            showErrorMessage('#errors', item)
          })
        }
      },
      cache: false,
      contentType: false,
      processData: false
    })
  })*/

})(jQuery)