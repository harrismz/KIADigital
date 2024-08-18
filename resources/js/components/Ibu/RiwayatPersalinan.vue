<template>
    <div class="p-8 bg-gray-100 min-h-screen">
        <div class="max-w-2xl mx-auto bg-white p-8 rounded-md shadow-md">
            <div class="mb-6">
                <div class="grid grid-cols-2 gap-4">
                    <h1 class="text-2xl font-bold">Riwayat Persalinan</h1>
                    <div class="flex justify-end item-end items-center gap-x-3">
                        <img class="w-6 h-6" @click="gotoHome" :src="'storage/images/home.png'"></img>
                        <!-- <img class="w-6 h-6" @click="editAnswer" :src="'storage/images/edit.png'"></img> -->
                        
                        <button @click="editAnswer()" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <i class="fa fa-add"></i>
                            <span class="sr-only">Icon description</span>
                        </button>
                    </div>
                </div>
            </div>
            <div v-if="loading" class="text-center">Loading...</div>
            <div v-else>
                <div v-for="preg in pregnancies" :key="preg.id" class="bg-gray-100 mb-4 p-4">

                    <div class="flex p-2 justify-between">
                        <div>
                            <h2 class="text-l font-bold">Kehamilan ke {{ preg.pregnancy_number }}</h2>
                        </div>
                        <div>
                            <img class="w-6 h-6" @click="editAnswer(preg.id)" :src="'storage/images/edit.png'"></img>
                        </div>
                    </div>

                    <div class="p-2 items-center">
                        <div>
                            Hari Pertama Haid Terakhir {{ preg.first_day_of_last_period }}
                        </div>
                        <div>
                            Hari Perkiraan Lahir {{ preg.estimate_date_of_delivery }}
                        </div>
                    </div>
                </div>

                
            </div>
        </div>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import {mapGetters} from 'vuex';
import helper from '../helper';

export default {
    name: 'RiwayatPersalinan',
    setup() {
        const childBirthData = ref({});
        const loading = ref(false);
        const router = useRouter();

        const fetchData = async () => {
            // Ganti URL ini dengan endpoint API yang sesuai
            const response = await fetch('/api/childbirth-history');
            childBirthData.value = await response.json();
            loading.value = false;
        };

        const editAnswer = (id = null ) => {
            router.push({
                name: 'riwayat-persalinan-edit',
                query: id ? {id} : {}
            });
        };
        const gotoHome = () => {
            router.push({
                name: 'dashboard',
                params: {}
            });
        };

        onMounted(fetchData);

        return {
            childBirthData,
            loading,
            gotoHome,
            editAnswer
        };
    },

    computed:{
        ...mapGetters(['baseUrl', 'mom']),

    },

    data(){
        return {
            pregnancies: []
        }
    },

    methods: {
        fetchPregnancy(){
            const url = this.baseUrl+"/api/pregnancy/"+ this.mom.id+"/list";

            axios.get(url, {
                // apa aja nih disini;
                params:{}
            }).then(res => res.data)
            .then(res => {
                console.log(res);
                this.pregnancies = res.data;
            }).catch(error => {
                console.log(error);
                helper.renderError(error);
            })
        }
    },

    mounted(){
        this.fetchPregnancy();
    }
};
</script>

<style scoped>
/* Custom styles if needed */
</style>
