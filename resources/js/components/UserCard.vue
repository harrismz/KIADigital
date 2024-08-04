<template>
    <div class="mb-2 grid grid-cols-3">
        <div class="collapse collapse-arrow col-span-1 bg-pink-200 mb-2 shadow-md" :class="{ 'collapse-open': isOpen }">
            <input type="radio" name="my-accordion-2" v-model="isOpen" class="hidden" />
            <div class="collapse-title text-xl font-medium" @click="toggleCollapse">
                <h1 class="font-mono">DISINI NAMA IBU BUKAN USER</h1>
                <p v-if="isMedic" class="font-sans font-light">
                    NIP : {{ userDetail.nip }}
                </p>
                <p v-else class="font-sans font-light">
                    HPL : {{ userDetail.hpl }}
                </p>
            </div>
            <div v-if="isMom" class="collapse-content">
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

export default {
    name: 'UserCard',
    setup() {
        const isOpen = ref(false);
        const userDetail = {
            hpl: '16 JUNE 2025',
            nip: '3450895734895734892',
        }

        const toggleCollapse = () => {
            isOpen.value = !isOpen.value;
        };

        return {
            isOpen,
            toggleCollapse,
            userDetail
        };
    },
    computed: {
        ...mapState(['user']),
        ...mapGetters([
            'getUser', 'isMom', 'userRole', 'userRoleDisplayName'
        ])
    },
    mounted() {

    },
    methods: {
        ...mapActions(["updateUser"]),
    },
    // data() {
    //     return {
    //         userState: null
    //     };
    // }
    // }
}
</script>

<style scoped>
/* Tambahkan styling khusus jika diperlukan */
</style>
