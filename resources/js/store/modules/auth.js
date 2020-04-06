import axios from 'axios';

axios.defaults.baseURL = 'http://larasender.test/api';

const state = {
    user: null,
}

const actions = {
    login ({commit}, credentials) {
        return axios
            .post('/login', credentials)
            .then(({data}) => {
                commit('SET_USER', data)
            })
    },

    logout({commit}) {
        commit('CLEAR_USER');
    }
}

getters: {
    isLogged: state => !!state.user
}

const mutations = {
    SET_USER(state, userData) {
        state.user = userData;
        localStorage.setItem('user', JSON.stringify(userData));
        axios.defaults.headers.common.Authorization = `Bearer ${userData.token}`;
    },

    CLEAR_USER() {
        localStorage.removeItem('user');
        location.reload();
    }
}

export default {
    state,
    actions,
    mutations
}
