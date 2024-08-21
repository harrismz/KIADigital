<template>
    <div class="w-full">
        <!-- Navigation (Week Selector) -->
        <!-- <div class="grid grid-cols-6 gap-2 mb-4">
            <button v-for="week in weeks" :key="week" :class="[
                'py-2 px-4 rounded-lg text-center',
                currentWeek === week ? 'bg-gray-400 text-white' : 'bg-gray-200'
            ]" @click="currentWeek = week">
                Minggu ke-{{ week }}
            </button>
        </div> -->

        <!-- Progress Bar -->
        <div v-if="pregnancy">
            <div class="relative w-full h-4 bg-gray-200 rounded-full overflow-hidden mb-4">
                <div class="absolute left-0 h-full bg-green-500 rounded-full"
                    :style="{ width: `${progressPercentage}%` }">
                </div>
            </div>

            <div class="flex justify-between text-xs mb-5">
                <div>Trimester 1</div>
                <div>Trimester 2</div>
                <div>Trimester 3</div>
            </div>
        </div>
        <div v-else>
            <div class="p-4 bg-white mb-2">
                <h2 class="text-lg font-bold  text-gray-700">Belum Ada Kehamilan</h2>
            </div>
        </div>

        <!-- <ul class="steps">
            <li class="step step-info">Trimester</li>
            <li class="step step-info">Trimester</li>
            <li class="step">Trimester</li>
        </ul> -->

    </div>
</template>

<script>
// import { ref, computed } from 'vue';
import {mapGetters} from 'vuex';
import helper from '../helper';

export default {
    // setup() {
    //     const lastMenstrualPeriod = new Date('2024-01-01'); // Ganti dengan tanggal haid terakhir yang relevan
    //     const dueDate = new Date('2024-10-01'); // Ganti dengan tanggal HPL yang relevan
    //     const today = new Date();

    //     const totalPregnancyDays = Math.floor((dueDate - lastMenstrualPeriod) / (1000 * 60 * 60 * 24));
    //     const daysPassed = Math.floor((today - lastMenstrualPeriod) / (1000 * 60 * 60 * 24));

    //     const progressPercentage = computed(() => {
    //         return Math.min(100, (daysPassed / totalPregnancyDays) * 100);
    //     });

    //     const weeks = [3, 4, 5, 6, 7]; // Sesuaikan dengan daftar minggu yang diinginkan
    //     const currentWeek = ref(3);

    //     return {
    //         weeks,
    //         currentWeek,
    //         progressPercentage,
    //     };
    // },

    mounted(){

        this.fetchLatestPregnancy();

    },

    data(){
        return {
            pregnancy:null
        }
    },

    computed: {
        ...mapGetters([ 'mom', 'getUser', 'baseUrl' ]),

        lastMenstrualPeriod() {
            if(!this.pregnancy){
                return null;
            }

            return new Date(this.pregnancy.first_day_of_last_period);

        },

        dueDate(){
            if(!this.pregnancy){
                return null;
            }

            let res = this.pregnancy.estimate_date_of_delivery;

            if(res == null ) {
                // how to calculate 40 weeks from this.pregnancy.first_day_of_last_period ??
                let lastPeriodDate = new Date(this.pregnancy.first_day_of_last_period);
                let dueDate = new Date(lastPeriodDate);
                dueDate.setDate(lastPeriodDate.getDate() + 280); // Add 280 days (40 weeks)
                return dueDate;
            }

            return new Date(res);
        },

        today(){
            return new Date();
        },

        currentWeek(){
            return 3;  //i dont know what current week for
        },

        totalPregnancyDays(){
            const totalPregnancyDays = Math.floor((this.dueDate - this.lastMenstrualPeriod) / (1000 * 60 * 60 * 24));
            return totalPregnancyDays;
        },

        daysPassed() {
            const daysPassed = Math.floor((this.today - this.lastMenstrualPeriod) / (1000 * 60 * 60 * 24));
            return daysPassed;
        },

        progressPercentage(){
            return Math.min(100, (this.daysPassed / this.totalPregnancyDays) * 100);
        },

        weeks(){
            let res = [];
            for (let i = 0; i < 40; i++) {
                // const element = array[i];
                res.push(i+1);
            }
            return res;
        },

    },

    methods: {
        fetchLatestPregnancy(){
            let mom = this.mom;
            const url = this.baseUrl + `/api/pregnancy/` + mom.id;
            axios.get(url, {
                // apa aja nih disini;
                params:{}
            }).then(res => res.data)
            .then(res => {
                console.log({ progresbar: res });
                this.pregnancy = res.data;
                console.log({ progresbar: this.$store.state.lastHpl })
                this.$store.state.lastHpl = res.data.estimate_date_of_delivery;
                console.log({ progresbar: this.$store.state.lastHpl })
            }).catch(error => {
                console.log(error);
                helper.renderError(error)
            })
        }
    }
};
</script>

<style scoped>
/* Tambahkan gaya khusus jika diperlukan */
</style>
