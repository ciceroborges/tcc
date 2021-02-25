//require('./bootstrap');
//------------------libs--------------------//
import axios from 'axios'
import Vue from 'vue'
import VueRouter from 'vue-router'
import VueLoading from 'vuejs-loading-plugin'
import Swal from 'sweetalert2'
import moment from 'moment';
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
        let storagedUser = localStorage.getItem("user");
        if (storagedUser) {
            let user = JSON.parse(storagedUser);
            if (document.cookie.includes(`app_session=${user.token}`)) {
                Vue.prototype.$user = user;
            } else if (this.$route.name !== 'login' && this.$route.name !== 'register') {
                localStorage.clear();
                this.$router.push('/login');
            }
        } else if (this.$route.name !== 'login' && this.$route.name !== 'register') {
            this.$router.push('/login');
        }
    },
    watch: {
        $route: function (to, from) {
            let storagedUser = localStorage.getItem("user");
            if (storagedUser) {
                let user = JSON.parse(storagedUser);
                if (document.cookie.includes(`app_session=${user.token}`)) {
                    Vue.prototype.$user = user;
                } else if (this.$route.name !== 'login' && this.$route.name !== 'register') {
                    localStorage.clear();
                    this.$router.push('/login');
                }
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

Vue.use(VueLoading, {
    dark: false,
    text: '',
})




