<template>
    <div class="max-w-3xl mx-auto p-4">
        <div class="mb-6">
            <div class="grid grid-cols-2 gap-4">
                <h1 class="text-2xl font-bold">Dairy Ibu Hamil Week ke-{{ pregnancy_week }}</h1>
                <div class="flex justify-end">
                    <img class="w-6 h-6" @click="gotoHome" :src="'storage/images/home.png'">
                </div>
            </div>
        </div>

        <!-- <Stepper :weeks="weeks" v-model:currentWeek="currentWeek" @update:currentWeek="handleWeekUpdate" /> -->

        <!-- Daftar Pertanyaan -->
        <div v-for="(question, index) in pregnancy_questions" :key="index" class="bg-gray-100 p-4 rounded-lg mb-4">
            <p class="mb-2">{{ index + 1 }}. {{ question.question }}</p>

            <!-- Opsi Pilihan -->
            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input v-model="question.answer" type="radio" :name="'question-' + index" value="Ya" class="form-radio text-indigo-600">
                    <span class="ml-2">Ya</span>
                </label>
                <label class="inline-flex items-center ml-6">
                    <input v-model="question.answer" type="radio" :name="'question-' + index" value="Tidak" class="form-radio text-indigo-600">
                    <span class="ml-2">Tidak</span>
                </label>
            </div>

            <!-- Input Text -->
            <!-- <div v-else-if="question.type === 'text'" class="mb-4">
                <textarea v-model="question.answer" class="w-full border-gray-300 rounded-lg shadow-sm" rows="3"
                    placeholder="Tulis keluhan atau gejala lainnya di sini..."></textarea>
            </div> -->
        </div>

        <!-- Tombol Simpan -->
        <button @click="submit" class="w-full bg-gray-600 text-white py-2 px-4 rounded-lg mt-4">
            Simpan
        </button>

        <!-- Tombol Tambah Pertanyaan ini kalo tenaga medis atau admi yg bisa nambah, sekarang ini halaman answer user ibu-->
        <!-- <div class="text-center mt-6">
            <button @click="addQuestion" class="bg-blue-500 text-white py-2 px-4 rounded-lg">
                Tambah Pertanyaan
            </button>
        </div> -->
    </div>
</template>

<script>
import toastr from 'toastr';
import { useRouter } from 'vue-router';
import {mapActions, mapGetters} from 'vuex';
import Stepper from '../utils/Stepper.vue';

// const router = useRouter();

export default {
    name: 'WeeklyMonitoringAnswer',
    components: { Stepper },
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
    mounted() {
        this.fetchWeek();
        this.fetchPregnancyQuestionAnswer({mother_id: this.mom.id, pregnancy_week: this.pregnancy_week});
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
            console.log('end '+this.pregnancy_week);
        },

        submit() {
            const url = this.baseUrl + "/api/pregnancy-questions";
            console.log(this.pregnancy_questions);
            axios.post(url, {
                questions: this.pregnancy_questions
            }).then(res => res.data)
            .then(res => {
                console.log(res);
                toastr.success(res.message);
            }).catch(error => {
                console.log(error);
                helper.renderError(error)
            })
        },

        gotoHome() {
            router.push({
                name: 'home',
                params: {}
            });
        },
        handleWeekUpdate(newWeekIndex) {
            this.currentWeek = newWeekIndex;
                this.$store.commit('setPregnancyWeek', newWeekIndex+1);
            this.fetchPregnancyQuestionAnswer({mother_id: this.mom.id, pregnancy_week: this.pregnancy_week });
            // console.log('Minggu saat ini berubah menjadi:', newWeek);
        }
    }
}
</script>
