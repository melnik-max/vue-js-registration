<template>
    <section>
        <iframe width="100%" height="450" src="https://maps.google.com/maps?q=7060%20Hollywood%20Blvd%2C%20Los%20Angeles%2C%20CA&t=&z=13&ie=UTF8&iwloc=&output=embed"></iframe>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-10 text-center">
                    <h4 class="mt-2 mb-2">Registration succeed!</h4>

                    <a :href="'https://www.facebook.com/sharer.php?u=' + twitterUrl" class="fa fa-facebook"></a>
                    <a :href="'https://twitter.com/intent/tweet?url=' + twitterUrl + '/&text=' + twitterText" class="fa fa-twitter"></a>
                    <p><router-link to="/members" class="text-success h3">All members list ({{ membersCount }})</router-link></p>
                </div>
            </div>
        </div>
    </section>


</template>

<script>
  export default {
    data () {
      return {
        membersCount: '',
        twitterUrl: '',
        twitterText: ''
      }
    },
    mounted () {
      let self = this
      axios.get('/api/members/count')
        .then(function (resp) {
          self.membersCount = resp.data
        })
        .catch(function (resp) {
          console.error(resp)
        })

      axios.get('/api/twitter')
        .then(function (resp) {
          self.twitterText = resp.data.twitterText
          self.twitterUrl = resp.data.twitterUrl
        })
        .catch(function (resp) {
          console.error(resp)
        })

    }

  }
</script>
