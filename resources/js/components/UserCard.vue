<template>
    <div class="mb-2 grid grid-cols-3">
        <div class="collapse collapse-arrow col-span-1 bg-white border border-4 mb-2 shadow-md"
            :class="{ 'collapse-open': isOpen }">
            <input type="radio" name="my-accordion-2" v-model="isOpen" class="hidden" />
            <div class="collapse-title text-xl font-medium" @click="toggleCollapse">
                <h1 class="font-mono text-lg font-lg font-bold">{{ userName }} </h1>

                <p v-if="isMedic" class="font-sans font-light text-sm">
                    NIP : {{ userDetail.nip }}
                </p>
                <p v-else class="font-sans font-light text-sm text-gray-600">
                    HPL : {{ userDetail.hpl }}
                </p>
            </div>

            <div v-if="isMom" class="collapse-content">

                <div v-for="child in relations" :key="child.id">
                    <div class="">
                        <span class="font-bold"> {{ getType(child) }}</span>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div @click="goToAnak(child)">
                            <h1 class="font-bold cursor-pointer">{{ getName(child) }}</h1>
                            <p class="text-sm text-gray-500 cursor-pointer">
                                TTL : {{ child.date_of_birth }}
                            </p>
                        </div>

                        <div class="flex justify-end gap-x-3 row-span-2">
                            <img class="w-6 h-6 cursor-pointer" @click="editAnak(child)"
                                :src="baseUrl + '/storage/images/edit.png'"></img>
                        </div>

                    </div>
                </div>

                <a href="/child" class="flex items-center space-x-2 cursor-pointer col-span-2">
                    <img :src="baseUrl + '/storage/images/anak-icon.png'" alt="" class="h-5 w-5">
                    <span>
                        tambah identitas anak
                    </span>
                </a>

            </div>
        </div>
    </div>
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

            // if ( child.child_name ) {
            //     // console.log('aku ibu')
            //     // this.$router.push('/dashboard-anak/' + id);
            //     this.$router.push('/' + id);
            // } else if (child.name) {
            //     // console.log('aku anak')
            //     this.$router.push('/');
            // } else {
            //     // console.log('aku else')
            //     // Handle unexpected profile type or a default case
            //     // this.$router.push('/dashboard-anak/' + id);
            //     this.$router.push('/');
            // }
        },
        editAnak(child) {
            // this.$router.push('/dashboard-anak/' + child.id + '/edit');
            this.$router.push('/child/' + child.id + '/edit');
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
