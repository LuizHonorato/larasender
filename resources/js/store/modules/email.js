import axios from 'axios';

axios.defaults.baseURL = 'http://larasender.test/api';

const state = {
    emails: [],
}

const actions = {
    getEmails({commit}) {
        return axios
            .get('/emails')
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
