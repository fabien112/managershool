import Vue from "vue";
import Router from "vue-router";
Vue.use(Router);

import Login from '../components/pages/Login';
// import Login from '../components/pages/Login';

const routes=[
    {
        path:'/login',
        component: Login
    },
    {
        path: '/',
        component: Login
    }
]


export default new Router({
mode:'history',
routes
});
