'use strict';

(function ($) {

  axios.get('/members/current')
    .then(function (response) {
      if (response.data !== false) {
        $('#register-form').addClass('hidden')
        $('#more-info-form').removeClass('hidden')
      }
    })

  let membersTable = new Vue({
    el: '#members-table',
    data: {
      members: []
    },
    mounted: function () {
     this.getMembers()
    },
    methods: {
      getMembers: function () {
        axios.post('/members')
          .then(function (resp) {
            membersTable.members = resp.data;
          })
          .catch(function (resp) {
            console.error(resp)
          })
      },

      getMembersCount: function () {
        axios.get('/members/count')
          .then(function (resp) {
            $('#members-count').text(resp.data)
          })
          .catch(function (error) {
            console.error(error)
          })
      }
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
        axios.get('/countries')
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
      },

      getCurrentMember: function () {
        axios.get('/members/current')
          .then(function (response) {
            let member = response.data

            for (let key in member) {
              if (key === 'country') {
                $('#country').val(member[key]).change()
              } else if (key === 'phone') {
                $('#phone').inputmask('setvalue', member[key])
              }
              else {
                $('#' + key).attr('value', member[key])
              }
            }

          })
          .catch(function (error) {
            console.error(error)
          })
      }
    }
  })

  $(document).on('click', '#back-to-register-form', function () {
    registerForm.getCurrentMember()
    $('#more-info-form').addClass('hidden')
    $('#register-form').removeClass('hidden')
  })

  $('#register-form').submit(function (e) {
    e.preventDefault()
    registerForm.createMember()
  })

    $('#birth_date').datepicker({
    maxDate: '0',
    dateFormat: 'yy-mm-dd',
    yearRange: '-100:+0',
    changeMonth: true,
    changeYear: true
  })

  $('#phone').inputmask('+9 (999) 999-9999')

  function showErrorMessage (selector, text) {
    $(selector).prepend('<strong class="text-danger">' + text + '</strong><br>')
  }

  let maxFileSize = 2000 * 1024
  $('#photo').on('change', function () {
    if (this.files[0].size > maxFileSize) {
      $('#errors').removeClass('hidden').empty()
      showErrorMessage('#errors', 'Image file size cannot be more than 2 MB')
      $('#photo').replaceWith('<input type="file" accept="image/!*" class="form-control-file" name="photo" id="photo">')
    }
  })

  $('#more-info-form').submit(function (e) {
    e.preventDefault()
    let formData = new FormData(this)

    axios.post('/members/update', formData)
      .then(function (response) {
        if (Array.isArray(response.data)) {

          $('#errors').removeClass('hidden').empty()
          response.data.reverse().forEach(function (item) {
            showErrorMessage('#errors', item)
          })

        } else {
          $('#more-info-form, #errors, #form-header').addClass('hidden')
          membersTable.getMembersCount()
          $('#social').removeClass('hidden')
        }
      })
      .catch(function (error) {
        console.error(error)
      })
  })

})(jQuery)