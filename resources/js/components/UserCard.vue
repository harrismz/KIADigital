<template>
    <div class="mb-2 grid grid-cols-3">
        <div class="collapse collapse-arrow col-span-1 bg-pink-200 mb-2 shadow-md" :class="{ 'collapse-open': isOpen }">
            <input type="radio" name="my-accordion-2" v-model="isOpen" class="hidden" />
            <div class="collapse-title text-xl font-medium" @click="toggleCollapse">
                <h1 class="font-mono">{{ userName }} </h1>

                <p v-if="isMedic" class="font-sans font-light">
                    NIP : {{ userDetail.nip }}
                </p>
                <p v-else class="font-sans font-light">
                    HPL : {{ userDetail.hpl }}
                </p>
            </div>

            <div v-if="isMom" class="collapse-content">
                
                <div v-for="child in relations" :key="child.id" @click="goToAnak(child)">
                    <span class="font-bold"> {{getType(child)}}</span>
                    <div class="grid grid-cols-2 grid-rows-2 gap-4">
                        <h1 class=" cursor-pointer">{{ getName(child) }}</h1>
                        <div class="flex justify-end gap-x-3 row-span-2">
                            <img class="w-6 h-6" @click="editAnswer" :src=" baseUrl + '/storage/images/edit.png'"></img>
                        </div>
                        <p class=" cursor-pointer">
                            TTL : {{ child.date_of_birth }}
                        </p>
    
                        <a v-if="getType(child) == 'ibu'" href="#" class="flex items-center space-x-2 cursor-pointer col-span-2">
                            <img :src="baseUrl +  '/storage/images/anak-icon.png'" alt="" class="h-5 w-5">
                            <span>
                                tambah identitas anak
                            </span>
                        </a>
    
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <!-- <div class="mb-2 grid grid-cols-3">
    <div class="mb-2 grid grid-cols-3 me-4">
        <div class="col-span-1 bg-white p-4 ">
            <span class="font-bold">{{userRoleDisplayName}}</span>
            <div class="mt-2">
                <span v-if="user">Nama: {{ user.name }}</span>
            </div>
            <div v-if="isMom">
                HPL: 07-09-2025
            </div>

            <div class="mt-4" v-if="isMom">
                <span class="font-bold">Anak</span>
                <div class="flex justify-between mt-2">
                    <a href="admin/child/create" class=" flex items-center space-x-2">
                        <img src="storage/images/anak-icon.png" alt="" class="h-5 w-5">
                        <span>
                            tambah identitas anak
                        </span>
                    </a>
                </div>
            </div>

        </div>

    </div> --->
</template>

<script>

import { mapState, mapGetters, mapActions } from 'vuex';
import axios from 'axios';
import { ref } from "vue";
import { useRouter } from 'vue-router';

export default {
    name: 'UserCard',
    
    // jangan pake setup 

    computed: {
        // ...mapState(['user']),
        ...mapGetters([
            'getUser', 
            'activeProfileType',
            'isMom', 'userRole', 'userRoleDisplayName', 'isMedic', 'userName', 'mom', 'children', 'baseUrl', 'relations', 'activeProfile'
        ])

    },
    methods: {
        // ...mapActions(["updateUser"]),
        goToAnak(child) {
            this.$store.commit('setActiveChild', child );
            this.$store.commit('setActiveProfile', child );
            
            let id = child.id;

            if (this.activeProfileType === 'ibu') {
                this.$router.push('/dashboard-anak/' + id);
            } else if (this.activeProfileType === 'anak') {
                this.$router.push('/');
            } else {
                // Handle unexpected profile type or a default case
                this.$router.push('/dashboard-anak/' + id);
            }
        },

        getType(child){
            return child.name ? 'Ibu' : 'Anak';
        },

        getName(child) {
            return child.name ? child.name : child.child_name;
        },

        toggleCollapse() {
            this.isOpen = !this.isOpen;
        },
    },
    
    data() {
        return {
            userState: null,
            
            isOpen: false,

            userDetail: {
                // ini perlu diganit
                hpl: '16 JUNE 2025',
                nip: '3450895734895734892',
            },

        };
    }
    
}
</script>

<style scoped>
/* Tambahkan styling khusus jika diperlukan */
</style>
