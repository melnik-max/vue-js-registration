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

                    <form v-on:submit="send" enctype="multipart/form-data" id="add_info_form">
                        <div class="form-group">
                            <label for="company">Company: </label>
                            <input v-model="fields.company" type="text" maxlength="45" class="form-control form-control-lg" id="company" name="company" placeholder="Enter company title">
                        </div>

                        <div class="form-group">
                            <label for="position">Position: </label>
                            <input v-model="fields.position" type="text" maxlength="45" class="form-control form-control-lg" id="position" name="position" placeholder="Enter position">
                        </div>

                        <div class="form-group">
                            <label for="about">About me: </label>
                            <textarea v-model="fields.about" maxlength="300" class="form-control form-control-lg" id="about" name="about" placeholder="Enter some details"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="photo">Upload avatar: </label>
                            <input type="file" accept="image/*" class="form-control-file" name="photo" id="photo">
                        </div>

                        <button type="button" @click="goBack" id="back-to-register-form" class="btn btn-primary float-left mb-2">Back</button>
                        <button type="submit" id="add-info" class="btn btn-primary float-right mb-2">Next</button>
                    </form>

                </div>
            </div>
        </div>
    </section>

</template>

<script>
  export default {
    data () {
      return {
        errors: [],
        fields: {}
      }
    },
    methods: {
      send(e) {
        e.preventDefault()

        let photo = $('#photo').prop('files')[0]
        let maxFileSize = 2000 * 1024

        if (photo['size'] > maxFileSize) {
          this.errors.push('Image file size cannot be more than 2 MB')
        } else {

          const self = this
          const router = this.$router

          let formData = new FormData()
          formData.append('photo', photo)
          formData.append('about', $('#about').val())
          formData.append('company', $('#company').val())
          formData.append('position', $('#position').val())

          $.ajax({
            url: '/api/members/update',
            type: 'POST',
            data: formData,

            success: function () {
              router.push('/social')
            },
            errors: function (errors) {
              self.errors = errors.responseJSON
            },

            cache: false,
            contentType: false,
            processData: false
          })

        }
      },

      goBack() {
        this.$router.go(-1)
      },
    }
  }

</script>