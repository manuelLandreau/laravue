import Home from './components/Home.vue'
import Login from './components/Login.vue'
import UserList from './components/UserList.vue'

/**
 * App routes
 */
export default [
  {
    path: '/',
    name: 'home',
    component: Home,
  }, {
    path: '/login',
    name: 'login',
    component: Login,
    meta: {
      auth: false,
    },
  }, {
    path: '/users',
    name: 'users',
    component: UserList,
    meta: {
      auth: true,
    },
  },
]