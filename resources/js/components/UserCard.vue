<template>
    <div class="collapse collapse-arrow bg-base-200">
        <input type="radio" name="my-accordion-2" />
        <div class="collapse-title text-xl font-medium">
            <div class="grid grid-cols-2 grid-rows-2 gap-4">
                <div class="row-span-2">
                    <img :src="baseUrl + '/storage/' + user.avatar" alt="Profile Picture"
                        class="rounded-full w-10 h-10 cursor-pointer">
                </div>
                <div>
                    <h2>{{ user.name }}</h2>
                </div>
                <div>
                    <p>{{ user.hpl }}</p>
                </div>
            </div>
        </div>
        <div class="collapse-content">
            <p>hello</p>
        </div>
    </div>
    <!-- <div class="mb-2 grid grid-cols-3">
        <div class="col-span-1 bg-white p-4 ">
            <span class="font-bold">Ibu</span>
            <div class="mt-2">
                <span v-if="user">Nama: {{ user.name }}</span>
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

    </div> -->
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
