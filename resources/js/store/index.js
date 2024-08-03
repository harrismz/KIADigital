// import Vue from 'vue';
import Vuex, { createStore } from 'vuex';
import axios from 'axios';
import toastr from 'toastr';
// Vue.useAttrs(Vuex)

const store = createStore({
    state: {
        user: null,

        auth_token: null,
        
        baseUrl: window.location.origin,

        config: {
            baseUrl: window.location.origin, // URL dasar yang mungkin diperlukan
            imgLogo: '',
        },

        dashboard_menu: {
            public:[
                { title: 'Selamat Datang', description: 'lorem ipsum', link: '#', img:  window.location.origin+ "/storage/images/janin.png" },
            ],

            medic:[
                { title: 'Check Up', description: 'Menu check up sebagai catatan kesehatan ibu serta pertumbuhan anak yang diintegrasikan menggunakan QR code.', link: '#', img:  window.location.origin+ "/storage/images/checkup.png" },
                { title: 'History', description: 'History seluruh check up yang telah dilakukan baik pada ibu hamil maupun anak.', link: '#', img:  window.location.origin+ "/storage/images/history.png" },
                { title: 'Information', description: 'Informasi seputar perawatan dan pemenuhan gizi anak, serta informasi relevan lainnya dapat dibaca pada menu ini.', link: '#', img:  window.location.origin+ "/storage/images/information.png" },

            ],

            ibu: [
                { title: 'Input HPL', description: 'Menu Input HPL untuk mencatat HPL', link: '#', img:  window.location.origin+ "/storage/images/checkup.png" },
                { title: 'Bayi Sudah Lahir', description: 'Menu Bayi', link: '#', img:  window.location.origin+ "/storage/images/checkup.png" },

            ],
        }
    },

    getters: {
        isAuthenticated(state) {
            let user = state.user;
            let auth_token = state.auth_token;
            console.log({user, auth_token})
            
            if(state.user == null ) {
                return false;
            }

            return true;
           // Mengembalikan true jika user tidak null
        },

        user: (state) => state.user,

        staff_id: (state) => {
            
            if(state.user) {
                let user = state.user;

                if(user.staff) {
                    return user.staff.id;
                }
            }

            return null;
        },

        hospital_id: (state) => {
            if(state.user) {
                let user = state.user;

                if(user.staff) {
                    return user.staff.hospital_id;
                }
            }

            return null;
        },

        getUser: (state) => state.user,
        baseUrl: (state) => state.config.baseUrl,
        imgLogo: (state) => state.config.imgLogo,

        getMenu: (state) => {
            // check current role
            let dm = state.dashboard_menu;
            let user = state.user;
            if(user == null) {
                return dm.public;
            }

            if(user.role.name == 'medic') {
                return dm.medic;
            }
            
            if(user.role.name == 'ibu') {
                return dm.ibu;
            }
            
            return dm.public;
        },

        userRole(state) {
            let user = state.user;
            
            if(user == null) {
                return null;
            }

            if(user.role == null) {
                return 'ibu'; // ????
            }

            return user.role.name;
            
        }
    },

    mutations: {
        SET_USER(state, user) {
            
            state.user = user;
        },

        setUser(state, user) {
            // localStorage.setItem('auth_token', user.token ); //save token to localStorage
            state.user = user;
        },

        setToken(state, token) {
            // ini
            state.auth_token = token;
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

        async fetchUser( context ) {
            try {
                let endpoint = context.getters.baseUrl + '/api/user';
                console.log(endpoint)
                return axios.get( endpoint , {
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
                    }
                })
                    .then(response => response.data)
                    .then(user => {
                        console.log({ user })
                        context.commit('setUser', user);
                    })
                    .catch(err => {
                        // do something like remove the localStorage

                        // localStorage.removeItem('auth_token');
                        // this
                        // this.updateUser(null)
                        console.log('catch fetch user')
                        context.commit('setUser', null);

                    })
            } catch (error) {
                console.error('Error fetching user:', error);
            }
        },

        // ini belum dipake, nanti aja
        async login(context, payload ) {
            try {
                
                const response = await axios.post('/api/login', {
                    email: payload.email,
                    password: payload.password
                });
                
                let data = response.data;

                console.log({response, data})

                localStorage.setItem('auth_token', data.access_token);
                
                // save to store
                context.commit('setToken', data.access_token );

                // this.$router.push('/profile');

            } catch (error) {
                console.log(error)
                let res = error.response;
                let data = res.data;
                let msg = data.message;
                toastr.error(msg)
            }
        },

        logout(context) {
            const url = context.state.baseUrl + "/api/logout";
            console.log(url)
                        
            axios.post(url, {}, {
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
                }
            }).then(res => res.data)
            .then(res => {
                console.log(res);
                // Remove the token from localStorage
                localStorage.removeItem('auth_token');
                context.commit('setUser', null);
                
            }).catch(error => {
                console.log(error);
                toastr.error(error)
            })
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
