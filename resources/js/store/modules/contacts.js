import axios from 'axios';

axios.defaults.baseURL = process.env.BASE_URL;

const state = {
    contacts: [],
}

const actions = {
    getContacts({commit}) {
        return axios
            .get('api/contacts')
            .then(res => {
                commit('SET_CONTACTS', res.data);
            })
            .catch(err => console.log(err));
    },

    getContact({commit}, id) {
        return new Promise((resolve, reject) => {
            axios.get(`api/contacts/${id}`)
                .then(data => resolve(data))
                .catch(err => reject(err));
        });
    },

    searchContact({commit}, params) {
        axios.post('api/contacts/search', params)
            .then(res => {
                commit('SET_CONTACTS', res.data);
            })
            .catch(err => {
                console.log(err);
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
            axios.post('api/contacts', formData, config)
                .then(data => resolve())
                .catch(err => reject(err.response));
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
            axios.post(`api/contacts/${contact.id}`, formData, config)
                .then(data => resolve())
                .catch(err => reject(err.response));
        });
    },

    deleteContact({dispatch}, id) {
        return new Promise((resolve, reject) => {
            axios.delete(`api/contacts/${id}`)
                .then(data => resolve(data))
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
