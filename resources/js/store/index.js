// import Vue from 'vue';
import Vuex, { createStore } from 'vuex';
import axios from 'axios';
import toastr from 'toastr';
import { localStoragePlugin, loadState } from '../localStoragePlugin';
import helper from '../components/helper';

// Vue.useAttrs(Vuex)
const origin = window.location.origin;

const determineActiveUser = (user) => {

    const savedState = localStorage.getItem('store');

    if (!savedState) {
        return ;
    }

    let str = JSON.parse(savedState);

    let activeProfile = str.active_profile;

    if(activeProfile) {
        return activeProfile;
    }

    if (user.staff) {
        return user.staff;
    } else if (user.mom) {
        return user.mom;
    }

    return null;
}

const initialState = loadState();

const store = createStore({
    plugins:[localStoragePlugin],

    state: {
        user: initialState.user || null,

        active_child:initialState.active_child || null,

        active_profile: initialState.active_profile || null,

        lastHpl: initialState.lastHpl || null,

        auth_token: initialState.auth_token || null,

        period_id: initialState.period_id || null,

        patient: initialState.patient || null,  //could be mother, could be children, fetched by checkupshow by guid
        
        periods: initialState.periods || null,  //could be mother, could be children, fetched by checkupshow by guid
        
        baseUrl: origin,

        questions:[],

        config: {
            baseUrl: origin, // URL dasar yang mungkin diperlukan
            imgLogo: '',
        },

        dashboard_menu: {
            public:[
                { title: 'Selamat Datang', description: 'lorem ipsum', link: '#', img:  origin+ "/storage/images/janin.png" },
            ],

            medic:[
                {
                    title: 'Check Up', description: 'Menu check up sebagai catatan kesehatan ibu serta pertumbuhan anak yang diintegrasikan menggunakan QR code.',
                    link: 'checkup', img:  origin+ "/storage/images/checkup.png" },
                {
                    title: 'History', description: 'History seluruh check up yang telah dilakukan baik pada ibu hamil maupun anak.',
                    link: 'history', img:  origin+ "/storage/images/history.png" },
                {
                    title: 'Information', description: 'Informasi seputar perawatan dan pemenuhan gizi anak, serta informasi relevan lainnya dapat dibaca pada menu ini.',
                    link: 'informasi-medis', img:  origin+ "/storage/images/information.png" },

            ],

            ibu: [
                { title: 'Info Janin Secara Umum', description: 'Tinggi : xxx cm Berat : xxx cm Ukuran : xxx Ciri-ciri : xxx', link: '#', img: '/storage/images/janin.png' },


                { title: 'Diary Ibu', description: 'Pemantauan mingguan, perawatan sehari-hari, serta keluhan yang dirasakan ibu dapat diisi secara mandiri dalam menu ini.', link: 'weekly-monitoring-result', img: '/storage/images/diary.png' },


                { title: 'Catatan Kesehatan Ibu', description: 'Hasil skrining preeklampsia dan hasil pemeriksaan kesehatan ibu, serta saran hingga tanggapan tenaga kesehatan terkait keluhan dapat dilihat dalam menu ini.', link: 'health-records', img: '/storage/images/catatan.png' },


                { title: 'Grafik Evaluasi Kehamilan', description: 'Grafik peningkatan berat badan dan grafik evaluasi kehamilan dapat dipantau dalam menu ini.', link: 'grafik-evaluasi-kehamilan', img: '/storage/images/grafik.png' },


                { title: 'Information', description: 'Informasi seputar kehamilan, pola makan dan minum ibu, aktivitas fisik dan latihan fisik, serta informasi relevan lainnya dapat dibaca pada menu ini.', link: 'informasi-medis', img: '/storage/images/information.png' },


                { title: 'Riwayat Persalinan', description: 'Informasi seputar persalinan, kondisi bayi saat lahir, hingga asuhan bayi baru lahir (IMD dalam 1 jam pertama kelahiran) bisa dapat dilihat dalam menu ini.', link: 'riwayat-persalinan', img: '/storage/images/riwayat.png' },

            ],
            anak: [
                { title: 'Diary Anak', description: 'Pemantauan kondisi dan perkembangan serta keluhan yang anak rasakah dapat diisi dalam menu ini.', link: 'child-weekly-monitoring-result', img: '/storage/images/diary.png' },

                { title: 'Information', description: 'Informasi seputar perawatan dan pemenuhan gizi anak, serta informasi relevan lainnya dapat dibaca pada menu ini.', link: 'informasi-medis', img: '/storage/images/information.png' },

                { title: 'Catatan Pertumbuhan Anak', description: 'Informasi seputar perawatan dan pemenuhan gizi anak, serta informasi relevan lainnya dapat dibaca pada menu ini.', link: 'child-development-list', img: '/storage/images/information-anak.png' },

                { title: 'Pelayanan Imunisasi', description: 'Pelayanan Imunisasi ini merupakan informasi mengenai imunisasi yang wajib dilakukan oleh anak. Sudah maupun belum dilakukan imunisasi dapat dilacak dalam menu ini.', link: 'imunisasi', img: '/storage/images/jarum.png' },
            ]
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

        period_id(state) {
            return state.period_id;
        },
        
        periods(state) {
            return state.periods;
        },

        questions: (state) => {
            return state.questions;
        },

        user: (state) => state.user,

        userName: (state, getters) => {
            // jika ibu, ambil dari ibu, jika staff ambil dari staff
            if(!state.user) {
                return 'user not found';
            }

            // yg active_profile siapa,
            if(state.active_profile) {
                // gmn cara cek active_profile antara name / child_name ?
                return state.active_profile.name ? state.active_profile.name : state.active_profile.child_name;
            }

            if(state.user.mother) {
                return state.user.mother.name;
            }

            if(state.user.staff) {
                return state.user.staff.staff_name;
            }

            return state.user.name;
        },

        user_hpl: (state) => state.lastHpl,

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

        patient: (state) => state.patient,

        baseUrl: (state) => state.config.baseUrl,

        imgLogo: (state) => state.config.imgLogo,

        mom: (state) => {

            if(!state.user) {
                return null;
            }

            return state.user.mother
        },

        children: (state, getters) => {
            if(!getters.mom) {
                return null;
            }

            return getters.mom.children;
        },

        activeProfile: (state, getters) => {
            return state.active_profile
        },

        activeProfileType: (state,getters) => {
            if(getters.activeProfile) {
                if(getters.activeProfile.child_name) {
                    return 'anak'
                }

                if(getters.activeProfile.name) {
                    return 'ibu'
                }

                if(getters.activeProfile.staff_name) {
                    return 'staff'
                }
            }

            return null;
        },

        relations: (state, getters) => {
            if(getters.activeProfile) {
                if(getters.activeProfile.child_name) {
                    return [getters.mom] //as an array of mom karena dipake di v-for
                }

                if(getters.activeProfile.name) {
                    return getters.children; // udah array dari sono nya
                }
            }

            return getters.children;
        },

        child: (state) => {
            return state.active_child;
        },

        isMom(state) {
            // cek dulu role nya null ngga, nanti error
            if(!state.user) {
                return false;
            }

            if(!state.user.role){
                return false;
            }

            return state.user.role.name == 'ibu';
        },

        isMedic(state) {
            if(!state.user) {
                return false;
            }

            if(!state.user.role){
                return false;
            }

            return state.user.role.name == 'medic';
        },

        getMenu: (state, getters) => {
            // check current role
            let dm = state.dashboard_menu;
            let user = state.user;
            if(user == null) {
                return dm.public;
            }

            // if(this.activeProfile)
            if(getters.activeProfileType == 'anak') {
                return dm.anak;
            }
            
            if(getters.activeProfileType == 'ibu') {
                return dm.ibu;
            }
            
            if(getters.activeProfileType == 'medic') {
                return dm.medic;
            }

            if(user.role.name == 'medic') {
                return dm.medic;
            }

            if(user.role.name == 'ibu') {
                return dm.ibu;
            }

            return dm.public;
        },

        getMenuAnak: (state) => {
            // check current role
            let dm = state.dashboard_menu;
            return dm.anak;
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

        },

        userRoleDisplayName(state){
            let user = state.user;

            if(user == null) {
                return null;
            }

            if(user.role == null) {
                return 'ibu'; // ????
            }

            return user.role.display_name;
        },

        // isMom(state,getters) {
        //     return getters.userRole == 'ibu'
        // }
    },

    mutations: {
        SET_USER(state, user) {
            state.user = user;
        },

        setPeriodId(state, period_id) {
            state.period_id = period_id;
        },
        
        setPeriods(state, periods) {
            state.periods = periods;
        },

        setQuestions(state, questions) {
            state.questions = questions;
        },

        setActiveChild(state, child) {
            state.active_child = child;
        },

        setActiveProfile(state, person) {
            state.active_profile = person; //person could be mom coulb be child
        },

        setPatient(state, patient) {
            state.patient = patient;
        },

        setUser(state, user) {
            // localStorage.setItem('auth_token', user.token ); //save token to localStorage
            state.user = user;
        },

        setUserHpl(state, lastHpl) {
            state.lastHpl = lastHpl;
        },

        setPregnancyInfo(state, pregnancy) {
            state.dashboard_menu.ibu[0].description = pregnancy.description;
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
                console.log({ endpoint })
                return axios.get( endpoint , {
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
                    }
                })
                    .then(response => response.data)
                    .then(user => {
                        console.log({ user })
                        context.commit('setUser', user);
                        // context.commit('setActiveUser', determineActiveUser(user) );

                        // I have user that has mom, child, and staff properties
                        // if user is is staff, then it shouldn't be a mom
                        // if user is a mom, it chould have a children
                        // now, i want to set one of them, (staff, mom, or child) to become active_profile in the state
                        // but i wonder how to do it properly,
                        // the default active users could be mother or a staff
                        // if it is a mom, people can click in children menu and set it into active user with children data changes into array of mom ( because it's used in component as v-for )
                        // how can I do that ?

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

        async fetchPregnancyInfo( context ) {
            try {
                let endpoint = context.getters.baseUrl + '/api/pregnancy-history-last';
                console.log({ endpoint })
                return axios.get( endpoint , {
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
                    }
                })
                .then(pregnancyhistory => {
                    console.log('fetch pregnancy info')
                    console.log({ pregnancyhistory })
                    const data = pregnancyhistory.data;
                    const payload = {
                        description: `Tinggi: ${data.fundal_height}cm\nBerat: ${data.weight_baby}g\nDetak Jantung: ${data.fetal_heart_rate}\nSaran: ${data.advice_given}`
                    };
                    context.commit('setPregnancyInfo', payload);
                })
                .catch(err => {
                    console.log('catch fetch pregnancy info')
                    context.commit('setPregnancyInfo', null);

                })
            } catch (error) {
                console.error('Error fetching pregnancy info:', error);
            }
        },

        async fetchLastHpl(context) {
            try {
                let endpoint = context.getters.baseUrl + '/api/pregnancy';
                console.log({ endpoint })
                return axios.get(endpoint, {
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
                    }
                })
                    .then(response => response.data)
                    .then(pregnancy => {
                        console.log({ pregnancy })
                        context.commit('setLastHpl', pregnancy.estimate_date_of_delivery);
                    })
                    .catch(err => {
                        // do something like remove the localStorage

                        // localStorage.removeItem('auth_token');
                        // this
                        // this.updateUser(null)
                        console.log('catch fetch LastHpl', err)
                        context.commit('setLastHpl', null);

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
                console.log({ error })
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
                console.log({ error });
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

        fetchQuestionAnswer(self, payload){
            
            let child = self.getters.child;
            const url = self.getters.baseUrl + "/api/questions/"+ payload.period_id;
                        
            axios.get(url, {
                // apa aja nih disini;
                params:{
                    child_id: child.id
                }
            }).then(res => res.data)
            .then(res => {
                console.log(res);
                // this.questions = res.data;
                self.commit('setQuestions', res.data )
            }).catch(error => {
                console.log(error);
                helper.renderError(error);
            })
        },

    }
});

export default store;
