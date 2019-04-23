import Vue from 'vue'
import VueRouter from 'vue-router'

import HomeIndex from '../components/home/Index.vue'
// import HomeIndex from '../components/home/Index.vue'

Vue.use(VueRouter)

var routes = [
    {
        path: '/',
        name: 'homepage',
        component: HomeIndex
    }
];


export const router = new VueRouter({
    routes
})
