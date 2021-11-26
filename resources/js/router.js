import Vue from 'vue';
import VueRouter from 'vue-router';
import Router from 'vue-router';
import Home from './views/Home.vue';
import Restaurant from './views/Restaurant.vue';
import RestaurantDetail from './views/RestaurantDetail.vue';

Vue.use(Router);

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes: [
    {
      path: '/app/home',
      name: 'home',
      component: Home
    },
    {
      path: '/app/restaurant',
      name: 'restaurant',
      component: Restaurant,
      props: true
    },
    {
      path: '/app/restaurant/:id/detail',
      name: 'restaurant_detail',
      component: RestaurantDetail,
      props: true
    },
]
})

export default router