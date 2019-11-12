import Vue from 'vue'
import VueRouter from 'vue-router'
import MembersTable from './components/MembersTable'
import RegisterForm from './components/forms/Register'

Vue.use(VueRouter)

const Bar = { template: '<div>ABOUT FORM</div>' }

const routes = [
  { path: '/members', component: MembersTable },
  { path: '/', component: RegisterForm },
  { path: '/about', component: Bar }
]

const router = new VueRouter({ routes })

const app = new Vue({
  router
}).$mount('#app')

