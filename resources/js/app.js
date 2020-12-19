//require('./bootstrap');
//------------------libs--------------------//
import axios from 'axios'
import Vue from 'vue'
import VueRouter from 'vue-router'
//---------------components-----------------//
import App from './components/App'
/*
componentes de autenticação
*/
import AppLogin from './components/auth/AppLogin'
import AppRegister from './components/auth/AppRegister'
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
            component: AppLogin,
        },
        {
            path: '/register',
            name: 'register',
            component: AppRegister,
        },
    ],
});
//------------------instance----------------//
const app = new Vue({
    el: '#app',
    components: { App },
    router,
    beforeCreate: function () {
        let activeUser = sessionStorage.getItem("user");
        if (activeUser) {
            Vue.prototype.$user = JSON.parse(activeUser);
        } else if (this.$route.name !== 'login' && this.$route.name !== 'register') {
                this.$router.push('/login');
        }
    },
    watch: {
        $route: function (to, from) {
            let activeUser = sessionStorage.getItem("user");
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




