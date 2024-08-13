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

        <!-- Daftar Pertanyaan -->
        <div v-for="(pregnancy_question, index) in pregnancy_questions" :key="index" class="bg-gray-100 p-4 rounded-lg mb-4">
            <div v-if="pregnancy_question.type == 'text'">
                <p class="mb-2">{{ index + 1 }}. {{ pregnancy_question.text }}</p>
                <p class="text-justify font-medium italic">{{ pregnancy_question.answer }}</p>
            </div>
            <div v-else>
                <p class="mb-2">{{ index + 1 }}. {{ pregnancy_question.text }} <strong>{{ pregnancy_question.answer }}</strong></p>
            </div>
        </div>
    </div>
</template>

<script>
import { useRouter } from 'vue-router';
import { ref } from 'vue';
import {mapActions, mapGetters} from 'vuex';

export default {
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
    mounted() {
        this.fetchWeek();
        this.fetchPregnancyQuestionAnswer({mother_id: this.mom.id, week_number: this.week});
    },
    data() {
        return {

        }
    },
    computed: {
        ...mapGetters(['baseUrl', 'mom', 'pregnancy_questions', 'pregnancy_week']),

        options(){
            return Array.from({length: 40}, (_, index) => {
                const week = index + 1;
                return {
                    text: `Minggu ke-${week}`,
                    value: week
                };
            });
        }
    },
    methods: {
        ...mapActions(['fetchPregnancyQuestionAnswer']),

        fetchWeek() {
            // TODO : getWeek based on mom_id
            const id = this.mom.id;
            const url = `${this.baseUrl}/api/pregnancy-week-number/${id}`;

            axios.get(url).then(response => {
                this.$store.commit('setPregnancyWeek', response.data);
            }).catch(error => {
                console.error(error);
            });
        },
        editAnswer() {
            let query = {
                mother_id: this.mom.id,
                week: getWeek()
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
            if(answer == null) {
                return '-'
            }

            return answer;
        },
    }
}
</script>
