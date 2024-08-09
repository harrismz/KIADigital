<template>
    <div class="max-w-3xl mx-auto p-4">
        <div class="mb-6">
            <div class="grid grid-cols-2 gap-4">
                <h1 class="text-2xl font-bold">Dairy Ibu Hamil</h1>
                <div class="flex justify-end">
                    <img class="w-6 h-6" @click="gotoHome" :src="'storage/images/home.png'">
                </div>
            </div>
        </div>

        <Stepper :weeks="weeks" :currentWeek.sync="currentWeek" @update:currentWeek="handleWeekUpdate" />

        <!-- Daftar Pertanyaan -->
        <div v-for="(question, index) in questions" :key="index" class="bg-gray-100 p-4 rounded-lg mb-4">
            <p class="mb-2">{{ index + 1 }}. {{ question.text }}</p>

            <!-- Opsi Pilihan -->
            <div v-if="question.type === 'choice'" class="mb-4">
                <label class="inline-flex items-center">
                    <input type="radio" :name="'question-' + index" value="Ya" class="form-radio text-indigo-600">
                    <span class="ml-2">Ya</span>
                </label>
                <label class="inline-flex items-center ml-6">
                    <input type="radio" :name="'question-' + index" value="Tidak" class="form-radio text-indigo-600">
                    <span class="ml-2">Tidak</span>
                </label>
            </div>

            <!-- Input Text -->
            <div v-else-if="question.type === 'text'" class="mb-4">
                <textarea v-model="question.answer" class="w-full border-gray-300 rounded-lg shadow-sm" rows="3"
                    placeholder="Tulis keluhan atau gejala lainnya di sini..."></textarea>
            </div>
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
import Stepper from '../utils/Stepper.vue';

// const router = useRouter();

export default {
    name: 'WeeklyMonitoringAnswer',
    components: { Stepper },
    data() {
        return {
            questions: [
                { text: 'Demam Lebih dari Dua Hari?', type: 'choice', answer: '' },
                { text: 'Pusing/Sakit Kepala Berat?', type: 'choice', answer: '' },
                { text: 'Sulit Tidur / Cemas Berlebih?', type: 'choice', answer: '' },
                { text: 'Keluhan/Gejala Lainnya', type: 'text', answer: '' }
            ],
            weeks: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15],
            currentWeek: 0
        };
    },
    watch: {
        currentWeek(newWeek) {
            console.log('Selected Week is ', newWeek);
        }
    },
    computed: {
        // ...mapGetters(['baseUrl']),
    },
    mounted() {
        this.fetchWeek();
    },
    methods: {
        fetchWeek() {
            // TODO : getWeek based on last pregnancy_id

            let query = this.queryParam;
            let id = query.id;

            const url = `${this.baseUrl}/api/pregnancy/${id}`;

            axios.get(url).then(response => {
                this.week = response.data.week;
            }).catch(error => {
                console.error(error);
            });
        },
        submit() {
            console.log(questions);
            toastr.success('Data Berhasil disimpan');
            router.push('/weekly-monitoring-result');
        },

        addQuestion() {
            questions.push({ text: 'Pertanyaan Baru', type: 'choice', answer: '' });
        },

        gotoHome() {
            router.push({
                name: 'home',
                params: {}
            });
        },
        handleWeekUpdate(newWeek) {
            this.currentWeek = newWeek;
            // console.log('Minggu saat ini berubah menjadi:', newWeek);
        }
    }
}
</script>
