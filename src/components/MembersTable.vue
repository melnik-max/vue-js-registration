<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">

                <h4 class="text-center mt-3 mb-3">All members</h4>
                <table id="members-table" class="table table-striped border">
                    <thead>
                    <tr>
                        <th scope="col">Photo</th>
                        <th scope="col">Full name</th>
                        <th scope="col">Report subject</th>
                        <th scope="col">Email</th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr v-for='member in members'>
                        <td>{{ member.photo }}</td>
                        <td>{{ member.last_name }}</td>
                        <td>{{ member.report_subject }}</td>
                        <td>{{ member.email }}</td>
                    </tr>

                    </tbody>
                </table>

            </div>
        </div>
    </div>

</template>

<script>
  export default {
    methods: {
      getMembers () {
        axios.post('/api/members')
          .then(function (resp) {
            console.log(resp.data)
            return resp.data;
          })
          .catch(function (resp) {
            console.error(resp)
          })
      }
    },
    computed: {
      members() {
        return this.getMembers()
      }
    }

  }
</script>
