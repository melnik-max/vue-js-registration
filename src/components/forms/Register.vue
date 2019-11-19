<template>
    <section>
        <iframe width="100%" height="450" src="https://maps.google.com/maps?q=7060%20Hollywood%20Blvd%2C%20Los%20Angeles%2C%20CA&t=&z=13&ie=UTF8&iwloc=&output=embed"></iframe>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-10">

                    <h4 id="form_header" class="mt-3 text-center">To participate in the conference, please fill out the form</h4>

                    <div class="my-4 p-3 text-center border" v-if="errors.length">
                        <strong class="text-danger" v-for="error in errors">{{ error }} <br></strong>
                    </div>

                    <form v-on:submit="send">

                        <div class="form-group">
                            <label for="first_name">First name (*): </label>
                            <input v-model="fields.first_name" type="text" maxlength="45" class="form-control form-control-lg" id="first_name" name="first_name" placeholder="Enter first name" required>
                        </div>

                        <div class="form-group">
                            <label for="last_name">Last name (*): </label>
                            <input v-model="fields.last_name" type="text" maxlength="45" class="form-control form-control-lg" id="last_name" name="last_name" placeholder="Enter last name" required>
                        </div>

                        <div class="form-group">
                            <label for="birth_date">Birth date (*): </label>  <!--2019-01-31-->
                            <vuejs-datepicker placeholder="Select birth date" name="birth_date" id="birth_date" format="yyyy-MM-dd" :disabled-dates="disabledDates" input-class="form-control form-control-lg" v-model="fields.birth_date"/>
                        </div>

                        <div class="form-group">
                            <label for="report_subject">Report subject (*): </label>
                            <input v-model="fields.report_subject" type="text" maxlength="200" class="form-control form-control-lg" id="report_subject" name="report_subject" placeholder="Enter report subject" required>
                        </div>

                        <div class="form-group">
                            <label for="country">Country (*): </label>
                            <select class="custom-select form-control form-control-lg" name="country" id="country" v-model="fields.country" required>
                                <option v-for="country in countries" :value="country">{{ country }}</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone number (*): </label><br>
                            <input type="text"
                                   v-model="fields.phone"
                                   maxlength="18"
                                   class="form-control form-control-lg"
                                   id="phone"
                                   name="phone"
                                   placeholder="+X (XXX) XXX XXXX"
                                   required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email (*): </label>
                            <input v-model="fields.email" type="email" maxlength="45" class="form-control form-control-lg" id="email" name="email" placeholder="Enter email" required>
                        </div>

                        <button type="submit" class="btn btn-primary float-right mt-2 mb-2">Next</button>
                    </form>

                </div>
            </div>
        </div>
    </section>
</template>

<script>
  import InputMask from "inputmask"
  import vuejsDatepicker from 'vuejs-datepicker'

  export default {
    components: {
      vuejsDatepicker
    },
    data () {
      return {
        errors: [],
        countries: '',
        fields: {},
        disabledDates: {
          from: new Date(Date.now())
        }
      }
    },
    mounted () {
      const self = this
      axios.post('/api/countries')
        .then(function (resp) {
          self.countries = resp.data
        })
        .catch(function (resp) {
          console.error(resp)
        })

      $('#country').select2({
        placeholder: "Select a state"
      })

      InputMask('+9 (999) 999-9999').mask('#phone')

      axios.post('/api/members/current')
        .then(function (resp) {
          if (resp.data !== 'No logged member') {
            self.fields = resp.data
          }
        })
        .catch(function (resp) {
          console.error(resp)
        })

    },
    methods: {
      send(e) {
        e.preventDefault()

        const self = this
        const router = this.$router
        console.log(this.fields)

        $.post('/api/members/create', this.fields)
          .done(function() {
            router.push('/about')
          })
          .fail(function(errors) {
            self.errors = errors.responseJSON
          })
      }
    }
  }
</script>