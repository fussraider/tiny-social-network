import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        user: {}
    },
    getters: {
        getUser: state => {
            return state.user;
        },

        userName: state => {
            return state.user.name || '';
        },

        userId: state => {
            return state.user.id || null;
        }
    },
    mutations: {
        setUser: (state, user_data) => {
            state.user = user_data;
        },

        unsetUser: (state) => {
            state.user = {};
        }
    },
    actions: {},
});

export default store;
