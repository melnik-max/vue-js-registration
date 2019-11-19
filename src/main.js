import Vue from 'vue'
import VueRouter from 'vue-router'
import MembersTable from './components/MembersTable'
import RegisterForm from './components/forms/Register'
import AddInfoForm from './components/forms/AddInfo'
import SocialSection from './components/SocialSection'

Vue.use(VueRouter)

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
        .done(function(resp) {
          if (resp === 'No logged member') {
            next({ name: 'register' })
          }
          next()
        })
    }
  },
  {
    path: '/social',
    component: SocialSection
  }
]

const router = new VueRouter({ routes })

const app = new Vue({
  router
}).$mount('#app')

