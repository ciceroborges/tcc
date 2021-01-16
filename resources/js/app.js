//require('./bootstrap');
//------------------libs--------------------//
import axios from 'axios'
import Vue from 'vue'
import VueRouter from 'vue-router'
//---------------components-----------------//
import App from './components/App'
import Home from './components/Home'
/*
componentes de autenticação
*/
import Login from './components/auth/Login'
import Register from './components/auth/Register'
//-----------------routes-------------------//
Vue.use(VueRouter)
const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/home',
            alias: '/',
            name: 'home',
            component: Home,
        },
        /*
        componentes de autenticação
        */
        {
            path: '/login',
            name: 'login',
            component: Login,
        },
        {
            path: '/register',
            name: 'register',
            component: Register,
        },
    ],
});
//------------------instance----------------//
const app = new Vue({
    el: '#app',
    components: { App },
    router,
    beforeCreate: function () {
        let activeUser = localStorage.getItem("user");
        if (activeUser) {
            Vue.prototype.$user = JSON.parse(activeUser);
        } else if (this.$route.name !== 'login' && this.$route.name !== 'register') {
                this.$router.push('/login');
        }
    },
    watch: {
        $route: function (to, from) {
            let activeUser = localStorage.getItem("user");
            if (activeUser) {
                Vue.prototype.$user = JSON.parse(activeUser);
            } else if (this.$route.name !== 'login' && this.$route.name !== 'register') {
                    this.$router.push('/login');
            }
        }
    }
});
//------------------constants----------------------//
Vue.prototype.$axios = axios;
Vue.prototype.$urlBASE = 'http://localhost:8000/';
Vue.prototype.$urlAPI = 'http://localhost:8000/api/';




