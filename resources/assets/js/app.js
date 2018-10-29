/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import './bootstrap'

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import Vue from 'vue'
import VueRouter from 'vue-router'
import axios from 'axios'
import VueAxios from 'vue-axios'
import App from './App.vue'
import routes from './routes'
import Auth from '@websanova/vue-auth'
import VueAuth from '@websanova/vue-auth/drivers/auth/bearer.js'
import VueAuthHttp from '@websanova/vue-auth/drivers/http/axios.1.x.js'
import VueAuthRouter from '@websanova/vue-auth/drivers/router/vue-router.2.x.js'
import moment from 'moment'

Vue.use(VueRouter)
Vue.use(VueAxios, axios)

axios.defaults.baseURL = 'http://localhost:8000/api'

Vue.router = new VueRouter({routes})

Vue.use(Auth, {
  auth: VueAuth,
  http: VueAuthHttp,
  router: VueAuthRouter,
})

App.router = Vue.router

Vue.filter('formatDate', function (value) {
  if (value) {
    return moment(String(value)).format('DD/MM/YYYY hh:mm')
  }
})

new Vue(App).$mount('#app')