<template>
    <div class="max-w-3xl mx-auto p-4">
        <div class="mb-6">
            <div class="grid grid-cols-2 gap-4">
                <h1 class="text-2xl font-bold">Dairy Ibu Hamil</h1>
                <div class="flex justify-end gap-x-3">
                    <img class="w-6 h-6" @click="gotoHome" :src="'storage/images/home.png'"></img>
                    <img class="w-6 h-6" @click="editAnswer" :src="'storage/images/edit.png'"></img>
                </div>
            </div>
        </div>
        <Stepper :weeks="weeks" :currentWeek.sync="currentWeek" @update:currentWeek="handleWeekUpdate" />

        <!-- Daftar Pertanyaan -->
        <div v-for="(question, index) in pregnancy_questions" :key="index" class="bg-gray-100 p-4 rounded-lg mb-4">
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
import Stepper from '../utils/Stepper.vue';

export default {
    name: 'WeeklyMonitoringResult',
    components: { Stepper },
    // setup() {
    //     const router = useRouter();

    //     const questions = ref([
    //         {
    //             text: 'Demam Lebih dari Dua Hari?',
    //             type: 'choice',
    //             answer: 'YA'
    //         },
    //         {
    //             text: 'Pusing/Sakit Kepala Berat?',
    //             type: 'choice',
    //             answer: 'YA'
    //         },
    //         {
    //             text: 'Sulit Tidur / Cemas Berlebih?',
    //             type: 'choice',
    //             answer: 'TIDAK'
    //         },
    //         {
    //             text: 'Keluhan/Gejala Lainnya',
    //             type: 'text',
    //             answer: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec cursus malesuada ultrices. Quisque in lobortis justo. Morbi placerat eget erat eu maximus. Nullam in dapibus est. Fusce vel maximus tortor. Fusce a eros erat. Curabitur posuere tellus id nisl vulputate, ut tristique orci fringilla. Suspendisse a orci eget tellus tincidunt pulvinar. Morbi dignissim, arcu at elementum porttitor, nunc risus pulvinar erat, aliquet dictum risus nunc ut lorem. Cras id scelerisque dui, et pharetra quam. Integer placerat tincidunt leo non viverra. Donec consequat nibh venenatis, pellentesque arcu id, eleifend turpis. In hac habitasse platea dictumst. Nunc vel urna nec tellus fermentum congue. Curabitur laoreet vitae leo eget rutrum. Proin a posuere turpis.'
    //         }
    //     ]);

    //     const editAnswer = () => {
    //         router.push({
    //             name: 'weekly-monitoring-answer',
    //             params: {}
    //         });
    //     };

    //     const gotoHome = () => {
    //         router.push({
    //             name: 'home',
    //             params: {}
    //         });
    //     };

    //     return {
    //         questions,
    //         editAnswer,
    //         gotoHome
    //     };
    // }
    async mounted() {
        console.log('mounted');
        console.log(this);
        await this.fetchWeek();
        await this.fetchPregnancyQuestionAnswer({mother_id: this.mom.id, pregnancy_week: this.pregnancy_week });

    },
    data() {
        return {
            weeks: Array.from({length: 40}, (_, i) => i + 1)
        }
    },
    computed: {
        ...mapGetters(['baseUrl', 'mom', 'pregnancy_questions', 'pregnancy_week']),

    },
    methods: {
        ...mapActions(['fetchPregnancyQuestionAnswer']),

        async fetchWeek() {
            console.log('fetchWeek');
            console.log(this.pregnancy_week);
            // TODO : getWeek based on mom_id
            const id = this.mom.id;
            const url = `${this.baseUrl}/api/pregnancy-week-number/${id}`;

            try {
                const response = await axios.get(url);
                console.log('response', response.data);
                this.$store.commit('setPregnancyWeek', response.data);
                this.currentWeek = response.data;
            } catch (error) {
                console.error(error);
            }
            console.log('end'+this.pregnancy_week);
        },

        editAnswer() {
            let query = {
                mother_id: this.mom.id,
                week: this.pregnancy_week
            }
            this.$router.push({
                name: 'weekly-monitoring-answer',
                query: query
            });
        },
        gotoHome() {
            this.$router.push({
                name: 'home',
                params: {}
            });
        },
        renderAnswer(answer) {
            if(answer == null || answer == '' || answer == 0) {
                return '-'
            }

            return answer;
        },
        handleWeekUpdate(indexnewWeek) {
            this.currentWeek = indexnewWeek;
            this.$store.commit('setPregnancyWeek', indexnewWeek+1);
            this.fetchPregnancyQuestionAnswer({mother_id: this.mom.id, pregnancy_week: indexnewWeek+1 });
        }
    }
}
</script>
