import { createStore } from 'vuex';
import axios from '@/plugins/axios';

const store = createStore({
    state: {
        token: localStorage.getItem('token') || '',
        user: null,
    },
    mutations: {
        SET_TOKEN(state, token) {
            state.token = token;
            localStorage.setItem('token', token);
        },
        CLEAR_TOKEN(state) {
            state.token = '';
            localStorage.removeItem('token');
        },
        SET_USER(state, user) {
            state.user = user;
        },
    },
    actions: {
        async fetchUser({ commit }) {
            try {
                const response = await axios.get('/user');
                commit('SET_USER', response.data);
            } catch (error) {
                console.error(error);
            }
        },
        logout({ commit }) {
            commit('CLEAR_TOKEN');
            commit('SET_USER', null);
        },
    },
    getters: {
        isAuthenticated: state => !!state.token,
        user: state => state.user,
    }
});

export default store;
