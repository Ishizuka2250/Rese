import Vue from 'vue';
import VueRouter from 'vue-router';
import Router from 'vue-router'
import Home from './views/Home.vue'

Vue.use(Router)

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes: [
    {
      path: '/app/home',
      name: 'home',
      component: Home
    },
]
})

export default router