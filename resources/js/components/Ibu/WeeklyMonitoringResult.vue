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

        <Stepper :weeks="weeks" v-model:currentWeek="currentWeek" @update:currentWeek="handleWeekUpdate" />
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
    async mounted() {
        await this.fetchWeek();
        await this.fetchPregnancyQuestionAnswer({mother_id: this.mom.id, pregnancy_week: this.pregnancy_week });
    },
    data() {
        return {
            currentWeek: null,
            weeks: Array.from({ length: 40 }, (_, i) => ({
                number: i + 1,
                disabled: false,
            })),
        }
    },
    computed: {
        ...mapGetters(['baseUrl', 'mom', 'pregnancy_questions', 'pregnancy_week']),
    },
    methods: {
        ...mapActions(['fetchPregnancyQuestionAnswer']),

        async fetchWeek() {
            const id = this.mom.id;
            const url = `${this.baseUrl}/api/pregnancy-week-number/${id}`;

            try {
                const response = await axios.get(url);

                this.$store.commit('setPregnancyWeek', response.data);
                this.currentWeek = response.data - 1;

                this.weeks = this.weeks.map(week => ({
                    ...week,
                    disabled: week.number > response.data,
                }));
            } catch (error) {
                console.error(error);
            }
            console.log('end'+this.pregnancy_week);
        },

        editAnswer() {
            let query = {
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
