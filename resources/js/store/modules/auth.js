import axios from 'axios';

axios.defaults.baseURL = process.env.BASE_URL;

const state = {
    user: null,
}

const actions = {
    login ({commit}, credentials) {
        return axios
            .post('api/login', credentials)
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
