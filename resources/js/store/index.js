import { createStore } from 'vuex';
import axios from 'axios';

const store = createStore({
    state: {
        user: {
            role: 'ibu'
        }, // Informasi pengguna yang login
        config: {
            baseUrl: '', // URL dasar yang mungkin diperlukan
            imgLogo: '',
        },
    },
    getters: {
        isAuthenticated(state) {
            return !!state.user;  // Mengembalikan true jika user tidak null
        },
        user: (state) => state.user,
        getUser: (state) => state.user,
        baseUrl: (state) => state.config.baseUrl,
        imgLogo: (state) => state.config.imgLogo,
    },

    mutations: {
        SET_USER(state, user) {
            state.user = user;
        },

        setUser(state, user) {
            state.user = user;
        },

        setBaseUrl(state, url) {
            state.config.baseUrl = url;
        },
        setLogo(state, imgLogo) {
            state.config.imgLogo = imgLogo;
        },
        LOGOUT(state) {
            state.user = null;
        },
    },

    actions: {
        // login({ commit }, user) {
        //     // Implementasikan logika login, seperti panggilan API
        //     commit('SET_USER', user);
        // },
        // logout({ commit }) {
        //     commit('LOGOUT');
        // },
        updateUser({commit}, user ){
            commit('setUser', user );
        },

        async fetchUser({ commit }) {
            try {
                console.log('Fetching user...');  // Debugging
                const response = await axios.get('/user');
                console.log('User fetched:', response.data);  // Debugging
                commit('SET_USER', response.data);
            } catch (error) {
                console.error('Error fetching user:', error);
            }
        },

        async fetchBaseUrl({ commit }) {
            try {
                const response = await axios.get('/config');
                commit('setBaseUrl', response.data.baseUrl);
            } catch (error) {
                console.error('Error fetching baseUrl :', error);
            }
        },
        async fetchLogo({ commit }) {
            try {
                const response = await axios.get('/config');
                commit('setLogo', response.data.baseUrl + '/storage/images/buku_kia.png');
            } catch (error) {
                console.error('Error fetching Logo :', error);
            }
        },

    }
});

export default store;
