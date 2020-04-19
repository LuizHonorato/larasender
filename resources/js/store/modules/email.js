import axios from 'axios';

axios.defaults.baseURL = process.env.BASE_URL;

const state = {
    emails: [],
}

const actions = {
    getEmails({commit}) {
        return axios
            .get('api/emails')
            .then(data => {
                commit('SET_EMAILS', data)
            })
            .catch(err => console.log(err));
    }
}

const mutations = {
    SET_EMAILS (state, emails) {
        state.emails = emails
    }
}

export default {
    state,
    actions,
    mutations
}
