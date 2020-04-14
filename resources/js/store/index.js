import Vue from 'vue';
import Vuex from 'vuex';
import auth from './modules/auth';
import drawer from './modules/drawer';
import email from './modules/email';
import contacts from "./modules/contacts";

Vue.use(Vuex);

const store = new Vuex.Store({
    modules: {
        auth,
        drawer,
        email,
        contacts
    }
});

export default store;
