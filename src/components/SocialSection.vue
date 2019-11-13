<template>
    <section>
        <iframe width="100%" height="450" src="https://maps.google.com/maps?q=7060%20Hollywood%20Blvd%2C%20Los%20Angeles%2C%20CA&t=&z=13&ie=UTF8&iwloc=&output=embed"></iframe>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-10">

                    <h4 class="mt-2 mb-2">Registration succeed!</h4>
                    <a href="https://www.facebook.com/sharer.php?u=https://www.wikipedia.org/" class="fa fa-facebook"></a>
                    <a href="https://twitter.com/intent/tweet?url=<?= $twitterUrl ?>/&text=<?= $twitterText ?>" class="fa fa-twitter"></a>
                    <p class="mt-2"><a href="/members" class="text-success h3">All members list ()</a></p>

                </div>
            </div>
        </div>
    </section>


</template>

<script>
  export default {
    data () {
      return {
        members: ''
      }
    },
    mounted () {
      const self = this
      axios.post('/api/members')
        .then(function (resp) {
          self.members = resp.data;
        })
        .catch(function (resp) {
          console.error(resp)
        })
    }

  }
</script>
