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
            .then(data => {
                commit('SET_CONTACTS', data)
            })
            .catch(err => console.log(err));
    },

    submitContact({dispatch}, contact) {
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

        return axios
            .post('/contacts', formData, config)
            .then(data => {
                console.log(data);
                //dispatch('getContacts')
            })
            .catch(err => console.log(err));
    }
}

const mutations = {
    SET_CONTACTS (state, emails) {
        state.contacts = emails
    }
}

export default {
    state,
    actions,
    mutations
}
