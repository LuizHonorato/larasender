import Vue from 'vue';
import Vuex from 'vuex';
import auth from './modules/auth';
import drawer from './modules/drawer'

Vue.use(Vuex);

const store = new Vuex.Store({
    modules: {
        auth,
        drawer
    }
});

export default store;
