<template>
    <div class="min-h-screen flex flex-col">
        <header class="bg-gray-800 text-white p-3">
            <div class="container mx-auto flex justify-between items-center">
                <!-- <h1 class="text-xl font-bold">{{Logo}}</h1> -->
                <img :src="baseUrl +  '/storage/images/avatar.png'" alt="" srcset="" class="w-10 h-10">
                <nav class="flex items-center">
                    <!-- <router-link to="/dashboard" class="mr-4">Dashboard</router-link> -->

                    <router-link v-if="user == null" to="/login" class="mr-4">Login</router-link>

                    <router-link v-if="user && userRole == 'ibu' " :to="{ name: 'QRCode', params: { id: user.id } }"
                        class="mr-4">
                        <img :src=" baseUrl + '/storage/images/qr-icon.png'" class="w-5 h-5" alt="">
                    </router-link>

                    <div v-if="user != null" class="relative" @click="toggleDropdown">
                        <img :src=" baseUrl +'/storage/' + user.avatar" alt="Profile Picture"
                            class="rounded-full w-10 h-10 cursor-pointer">
                        <ul v-if="dropdownOpen"
                            class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded shadow-lg">


                            <router-link :to="{ name: 'my-profile' }" v-if="userRole == 'ibu'">
                                <li class="block px-4 py-2 text-gray-800 hover:bg-gray-100 cursor-pointer">
                                    Edit Profile
                                </li>
                            </router-link>
                            <div v-else>
                                {{ user.name }} - {{ user.role.display_name }}
                            </div>

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
    </div>
    <footer class="bg-gray-800 text-white p-2">
        <div class="container mx-auto text-center">
            &copy; 2024 KIA Digital
        </div>
    </footer>
</template>

<script>

import { mapState, mapGetters, mapActions } from 'vuex';
import axios from 'axios';
import toastr from 'toastr';

export default {
    name: 'UserLayout',
    data() {
        return {
            dropdownOpen: false,
            userState:null
        };
    },
    computed: {
        // ...mapState(['user']),

        ...mapGetters([
            'getUser', 'baseUrl', 'userRole'
        ]),

        user() {
            return this.getUser;
        }
    },
    // mounted() {
    //     console.log('mounting userlayout')
    //     this.fetchAuthUser()
    //     console.log('userlayout is mounted')
    // },
    methods: {

        ...mapActions(['updateUser', 'fetchUser']),

        toggleDropdown() {
            this.dropdownOpen = !this.dropdownOpen;
        },

        logout(){
            const url = this.baseUrl + "/api/logout";
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
                this.$store.commit('setUser', null);

                // Redirect to login page
                this.$router.push({
                    name: 'login'
                });
            }).catch(error => {
                console.log(error);
                toastr.error(error)
            })
        },


    }
}
</script>

<style scoped>
/* Tambahkan styling khusus jika diperlukan */
</style>
