//------------------libs--------------------//
import axios from 'axios';
import Vue from 'vue';
import VueRouter from 'vue-router';
import VueLoading from 'vuejs-loading-plugin';
import Swal from 'sweetalert2';
import moment from 'moment';
import InfiniteLoading from 'vue-infinite-loading';
import Multiselect from 'vue-multiselect'

//---------------components-----------------//
import App from './components/App';
import Home from './components/Home';
/*
componentes de autenticação
*/
import Login from './components/auth/Login';
import Register from './components/auth/Register';
/*
componentes de módulos
*/
import Users from './components/modules/users/Index';
//-----------------routes-------------------//
Vue.use(VueRouter)
const router = new VueRouter({
    mode: 'history',
    routes: [
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
        /*
        componentes home
        */
        {
            path: '/home',
            alias: '/',
            name: 'home',
            component: Home,
            meta: {
                title: 'Home'
            }
        },
        /*
        componentes dos módulos
        */
        {
            path: '/users',
            name: 'users',
            title: 'Usuários',
            component: Users,
            meta: {
                title: 'Usuários'
            }
        },
    ],
});

//------------------constants----------------------//
Vue.prototype.$axios = axios;
Vue.prototype.$swal = Swal;
Vue.prototype.$moment = moment;
Vue.prototype.$toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 4000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});
Vue.prototype.$urlBASE = 'http://localhost:8000/';
Vue.prototype.$urlAPI = 'http://localhost:8000/api/';

//------------------ libs-------------------------//
Vue.use(VueLoading, {
    dark: false,
    text: '',
})
Vue.use(InfiniteLoading, { /* options */ });

Vue.component('multiselect', Multiselect);


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





