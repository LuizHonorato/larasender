import axios from 'axios';
import header from "vuetify/lib/components/VDataTable/mixins/header";
import {consoleError} from "vuetify/lib/util/console";

axios.defaults.baseURL = 'http://larasender.test/api';

const state = {
    contacts: [],
}

const actions = {
    getContacts({commit}) {
        return axios
            .get('/contacts')
            .then(res => {
                commit('SET_CONTACTS', res.data)
            })
            .catch(err => console.log(err));
    },

    getContact({commit}, id) {
        return new Promise((resolve, reject) => {
            axios.get(`/contacts/${id}`)
                .then(data => resolve(data))
                .catch(err => reject(err));
        });
    },

    storeContact({dispatch}, contact) {
        const config = {
            headers: {
                'Content-Type' : 'multipart/form-data'
            }
        };

        let formData = new FormData();
        formData.append('name', contact.name);
        formData.append('email', contact.email);
        formData.append('phone', contact.phone);
        formData.append('profile_pic', contact.profile_pic);

        return new Promise((resolve, reject) => {
            axios.post('/contacts', formData, config)
                .then(data => resolve())
                .catch(err => reject(err));
        });
    },

    updateContact({dispatch}, contact) {
        const config = {
            headers: {
                'Content-Type' : 'multipart/form-data'
            }
        };

        let formData = new FormData();
        formData.append('name', contact.name);
        formData.append('email', contact.email);
        formData.append('phone', contact.phone);
        formData.append('profile_pic', contact.profile_pic);
        formData.append('_method', 'PUT');

        return new Promise((resolve, reject) => {
            axios.post(`/contacts/${contact.id}`, formData, config)
                .then(data => resolve())
                .catch(err => reject(err));
        });
    }
}

const mutations = {
    SET_CONTACTS (state, emails) {
        state.contacts = emails
    },
}

export default {
    state,
    actions,
    mutations
}
