//import './bootstrap';
import Vue from 'vue';
import VueRouter from "vue-router";
import axios from 'axios';
import VueAxios from "vue-axios";
import VueAuth from '@websanova/vue-auth'
import BootstrapVue from 'bootstrap-vue'
import router from './router';
import App from '@/js/views/App';
import store from './store';

Vue.use(BootstrapVue);
Vue.use(VueRouter);

Vue.use(VueAxios, axios);
axios.defaults.baseURL = '/api';

Vue.router = router;
Vue.store = store;

Vue.use(VueAuth, {
    auth: require('@websanova/vue-auth/drivers/auth/bearer.js'),
    http: require('@websanova/vue-auth/drivers/http/axios.1.x.js'),
    router: require('./vue-auth-router-fix'),
    tokenStore: ['localStorage'],
    loginData: {
        url: 'login',
    },
    registerData: {
        url: 'register',
    },
    logoutData: {
        url: 'logout'
    },
    refreshData: {
        url: 'refresh'
    },
    fetchData: {
        url: 'user'
    },
    parseUserData: function(data){
        if(data.result){
            Vue.store.commit('setUser', data.data);
        } else {
            Vue.store.commit('unsetUser');
            this.logout();
        }
    }
});

new Vue({
    el: '#app',
    store,
    router,
    render: h => h(App)
});
