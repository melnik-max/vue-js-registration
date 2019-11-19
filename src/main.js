import Vue from 'vue'
import VueRouter from 'vue-router'
import RegisterForm from './components/forms/Register'
import AddInfoForm from './components/forms/AddInfo'
import SocialSection from './components/SocialSection'
import MembersTable from './components/MembersTable'

console.log($('#app').attr('id'))

Vue.use(VueRouter)

/*Vue.config.productionTip = false

new Vue({
  render: h => h(App),
}).$mount('#app')*/
const routes = [
  {
    path: '/members',
    component: MembersTable
  },
  { path: '/',
    name: 'register',
    component: RegisterForm
  },
  {
    path: '/about',
    component: AddInfoForm,
    beforeEnter(to, from, next) {
      $.get('/api/members/current')
        .done(function() {
          next()
        })
        .fail(function() {
          next({ name: 'register' })
        })
    }
  },
  {
    path: '/social',
    component: SocialSection
  }
]

const router = new VueRouter({ routes })

new Vue({
  router
}).$mount('#app')
