require('./bootstrap');

window.Vue = require('vue');
import Vuetify from 'vuetify';
import router from './router';
import Vuex from "vuex";
import store from "./store/";

Vue.use(Vuetify);
Vue.use(Vuex);

const app = new Vue({
    el: '#app',
    router,
    store,
    created() {
        const userInfo = localStorage.getItem('user')
        if(userInfo) {
            const userData = JSON.parse(userInfo)
            this.$store.commit('SET_USER', userData)
        }
        axios.interceptors.response.use(
            response => response,
            error => {
                if(error.response.status === 401) {
                    this.$store.dispatch('logout')
                }
                return Promise.reject(error)
            }
        )
    },
    vuetify: new Vuetify(),
});
