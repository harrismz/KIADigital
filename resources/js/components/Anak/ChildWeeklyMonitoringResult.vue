<template>
    <div class="max-w-3xl mx-auto p-4">
        <div class="mb-6">
            <div class="grid grid-cols-2 grid-rows-2 gap-4">
                <h1 class="text-2xl font-bold">Dairy Anak</h1>
                <div class="flex justify-end gap-x-3 row-span-2">
                    <img class="w-6 h-6" @click="gotoDashboardAnak" :src="'storage/images/home.png'"></img>
                    <img class="w-6 h-6" @click="editAnswer" :src="'storage/images/edit.png'"></img>
                </div>
                <p>Pemantauan Perkembangan Anak</p>
            </div>
        </div>

        <!--  -->
        <div class="p-2 bg-white shadow mb-4">
            <label for="">Periode</label>
            <select @change="fetchQuestionAnswer({period_id})" v-model="period_id" name="periode" id="periode" class="block w-full p-2">
                <option v-for="opt in options" :value="opt.value" :key="opt.value">{{opt.key}}</option>
            </select>
        </div>
        <!-- Daftar Pertanyaan -->
        <div v-for="(question, index) in questions" :key="index" class="bg-gray-100 p-4 rounded-lg mb-4">
            <div>
                <p class="mb-2">{{ index + 1 }}. {{ question.question }}</p>
                <p class="text-justify font-medium italic">{{ renderAnswer( question.answer) }}</p>
            </div>
        </div>
    </div>
</template>

<script>
import { useRouter } from 'vue-router';
import { ref } from 'vue';
import {mapActions, mapGetters} from 'vuex';
import helper from '../helper';

export default {
    setup() {
        // const router = useRouter();
        // const questions = ref([
        //     {
        //         text: 'Bayi bisa mengangkat kepala mandiri hingga setinggi 45 derajat ?',
        //         type: 'choice',
        //         answer: 'TIDAK'
        //     },
        //     {
        //         text: 'Bayi bisa menggerakan kepala dari kiri / kanan ke tengah ?',
        //         type: 'choice',
        //         answer: 'YA'
        //     },
        //     {
        //         text: 'Bayi  bisa melihat dan menatap wajah anda ?',
        //         type: 'choice',
        //         answer: 'YA'
        //     },
        //     {
        //         text: 'Bayi bisa mengoceh spontant atau bereaksi dengan mengoceh ?',
        //         type: 'choice',
        //         answer: 'Tidak'
        //     }
        // ]);

        // const editAnswer = () => {
        //     router.push({
        //         name: 'child-weekly-monitoring-answer',
        //         params: {}
        //     });
        // };

        // const gotoDashboardAnak = () => {
        //     router.push({
        //         name: 'dashboard-anak',
        //         params: {}
        //     });
        // };

        // return {
        //     questions,
        //     editAnswer,
        //     gotoDashboardAnak
        // };
    },

    mounted(){
        this.fetchOptions();
        this.fetchQuestionAnswer({ period_id: this.period_id});
    },

    data() {
        return {
            // options:[],

            period_id: 1,

            // questions:[] //pindah ke store
        }
    },

    computed:{
        ...mapGetters(['baseUrl', 'child', 'questions', 'periods']),

        options() {
            return this.periods;
        }
    },

    methods: {
        ...mapActions(['fetchQuestionAnswer']),

        fetchOptions(){
            const url = this.baseUrl + "/api/combo/WeeklyChildMonitoringPeriod";
                        
            axios.get(url, {
                // apa aja nih disini;
                params:{}
            }).then(res => res.data)
            .then(res => {
                console.log(res);
                // this.options = res.data;
                this.$store.commit('setPeriods', res.data )
            }).catch(error => {
                console.log(error);
                helper.renderError(error);
            })
        },

        // fetchQuestionAnswer(){
        //     let child = this.child;
        //     const url = this.baseUrl + "/api/questions/"+ this.period_id;
                        
        //     axios.get(url, {
        //         // apa aja nih disini;
        //         params:{
        //             child_id: child.id
        //         }
        //     }).then(res => res.data)
        //     .then(res => {
        //         console.log(res);
        //         this.questions = res.data;
        //     }).catch(error => {
        //         console.log(error);
        //         helper.renderError(error);
        //     })
        // },

        editAnswer(){
            let query = {
                period_id: this.period_id,
                child_id: this.child.id
            };
            console.log({query})
            this.$router.push({
                name: 'child-weekly-monitoring-answer',
                query: query
            });
        },

        gotoDashboardAnak() {
            this.$router.push({
                name: 'home',
                params: {}
            });
        },

        renderAnswer(answer) {
            if(answer == null) {
                return '-'
            }

            return answer;
        }
    }
}
</script>
