<template>
    <div class="mb-2 grid grid-cols-3">
        <div class="col-span-1 bg-white p-4 ">
            <span class="font-bold">Ibu</span>
            <div class="mt-2">
                <span>Nama: {{ user.name }}</span>
            </div>
            <div>
                HPL: 07-09-2025
            </div>

            <div class="mt-4">
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
</template>

<script>

import { mapState, mapGetters, mapActions } from 'vuex';
import axios from 'axios';

export default {
    name: 'UserCard',
    data() {
        return {
            userState: null
        };
    },
    computed: {
        ...mapState(['user']),
        ...mapGetters([
            'getUser'
        ])
    },
    mounted() {
        
    },
    methods: {

        ...mapActions(['updateUser']),
        
    }
}
</script>

<style scoped>
/* Tambahkan styling khusus jika diperlukan */
</style>
