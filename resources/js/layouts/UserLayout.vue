<template>
    <div class="min-h-screen flex flex-col">
        <header class="bg-gray-800 text-white p-4">
            <div class="container mx-auto flex justify-between items-center">
                <!-- <h1 class="text-xl font-bold">{{Logo}}</h1> -->
                <img :src="baseUrl +  '/storage/images/avatar.png'" alt="" srcset="" class="w-10 h-10">
                <nav class="flex items-center">
                    <!-- <router-link to="/dashboard" class="mr-4">Dashboard</router-link> -->

                    <router-link v-if="user == null" to="/login" class="mr-4">Login</router-link>

                    <router-link v-if="user !== null" :to="{ name: 'QRCode', params: { id: user.id } }"
                        class="mr-4">
                        <img :src=" baseUrl + '/storage/images/qr-icon.png'" class="w-5 h-5" alt="">
                    </router-link>

                    <div v-if="user != null" class="relative" @click="toggleDropdown">
                        <img :src=" baseUrl +'/storage/' + user.avatar" alt="Profile Picture"
                            class="rounded-full w-10 h-10 cursor-pointer">
                        <ul v-if="dropdownOpen"
                            class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded shadow-lg">


                            <li class="block px-4 py-2 text-gray-800 hover:bg-gray-100 cursor-pointer">
                                {{ user.name }} - {{ user.role.display_name }}</li>
                            <li class="block px-4 py-2 text-gray-800 hover:bg-gray-100 cursor-pointer" @click="logout">
                                Logout</li>
                        </ul>
                    </div>



                </nav>
            </div>
        </header>
        <main class="flex-grow container mx-auto p-4">
            <slot></slot>
        </main>
        <footer class="bg-gray-800 text-white p-4">
            <div class="container mx-auto text-center">
                &copy; 2024 KIA Digital
            </div>
        </footer>
    </div>
</template>

<script>

import { mapState, mapGetters, mapActions } from 'vuex';
import axios from 'axios';

export default {
    name: 'UserLayout',
    data() {
        return {
            dropdownOpen: false,
            userState:null
        };
    },
    computed: {
        ...mapState(['user']),

        ...mapGetters([
            'getUser', 'baseUrl'
        ]),

        user() {
            return this.getUser;
        }
    },
    mounted() {
        console.log('mounting userlayout')
        this.fetchAuthUser()
        console.log('userlayout is mounted')
    },
    methods: {

        ...mapActions(['updateUser', 'fetchUser']),

        fetchAuthUser() {
            console.log('fetchAuthUser')
            this.fetchUser(); //declared in store/index.js ( vuex )
            
            // axios.get('api/user', {
            //     headers: {
            //         'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
            //     }
            // })
            //     .then(response => response.data)
            //     .then(user => {
            //         console.log({ user })
            //         this.updateUser(user)
            //         this.userState = user;
            //     })
        },

        toggleDropdown() {
            this.dropdownOpen = !this.dropdownOpen;
        },

        async logout() {
            try {
                await axios.post('/api/logout', {}, {
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
                    }
                });

                // Remove the token from localStorage
                localStorage.removeItem('auth_token');

                // Redirect to login page
                this.$router.push('/login');
            } catch (error) {
                console.error('Logout error:', error);
            }
        }
    }
}
</script>

<style scoped>
/* Tambahkan styling khusus jika diperlukan */
</style>
