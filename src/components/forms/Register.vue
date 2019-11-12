<template>
    <div>
        <iframe width="100%" height="450" src="https://maps.google.com/maps?q=7060%20Hollywood%20Blvd%2C%20Los%20Angeles%2C%20CA&t=&z=13&ie=UTF8&iwloc=&output=embed"></iframe>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-10">

                    <h4 id="form_header" class="mt-3 text-center">To participate in the conference, please fill out the form</h4>

                    <!--<section id="errors" class="errors text-center border hidden"></section>-->

                    <form v-on:submit="send" id="register_form">

                        <form-control type="text" name="first_name" maxlength="45" placeholder="Enter first name" label="First name (*):" />

                        <form-control type="text" name="last_name" maxlength="45" placeholder="Enter last name" label="Last name (*):" />

                        <form-control type="text" name="birth_date" placeholder="Enter date of birth" label="Birth date (*):" />

                        <form-control type="text" name="report_subject" maxlength="200" placeholder="Enter report subject" label="Report subject (*):" />

                        <div class="form-group">
                            <label for="country">Country (*): </label>
                            <select class="custom-select form-control form-control-lg" name="country" id="country" required>
                                <option v-for="country in countries" v-bind:value="country">{{ country }}</option>
                            </select>
                        </div>

                        <form-control type="text" name="phone" maxlength="18" placeholder="+X (XXX) XXX XXXX" label="Phone number (*):" />

                        <form-control type="email" name="email" maxlength="45" placeholder="Enter email" label="Email (*):" />


                        <button type="submit" id="to_more_info_form" class="btn btn-primary float-right mt-2 mb-2">Next</button>
                    </form>


                </div>
            </div>
        </div>
    </div>
</template>

<script>
  import FormControl from './Control'

  export default {
    components: {
      'form-control': FormControl
    },
    data () {
      return {
        countries: ''
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
    },
    methods: {
      goToNext() {
        this.$router.push('/about')
      },
      send(e) {
        console.log('SENDING')
        e.preventDefault()
      }
    }
  }
</script>