import Vue from 'vue'
import VueRouter from 'vue-router'
import MembersTable from './components/MembersTable'
import RegisterForm from './components/forms/Register'
import AddInfoForm from './components/forms/AddInfo'

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
        .done(function() {
          next()
        })
        .fail(function() {
          next({ name: 'register' })
        })
    }
  }
]

const router = new VueRouter({ routes })

const app = new Vue({
  router
}).$mount('#app')

