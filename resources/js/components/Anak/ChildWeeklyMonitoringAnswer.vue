<template>
    <div class="max-w-3xl mx-auto p-4">
        <div class="mb-6">
            <div class="grid grid-cols-2 gap-4">
                <h1 class="text-2xl font-bold">Dairy Anak <span v-if="periodName" > ( {{ periodName }} )</span></h1>
                <div class="flex justify-end">
                    <img class="w-6 h-6" @click="gotoHome" :src="'storage/images/home.png'"></img>
                </div>
            </div>
        </div>

        <!-- Daftar Pertanyaan -->
        <div v-for="(question, index) in questions" :key="index" class="bg-gray-100 p-4 rounded-lg mb-4">
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
            <div v-if="question.type === 'text'" class="mb-4">
                <textarea v-model="question.answer" class="w-full border-gray-300 rounded-lg shadow-sm" rows="3"
                    placeholder="Tulis keluhan atau gejala lainnya di sini..."></textarea>
            </div>
        </div>

        <!-- Tombol Simpan -->
        <button @click="submit" class="w-full bg-gray-600 text-white py-2 px-4 rounded-lg mt-4">
            Simpan
        </button>

    </div>
</template>

<script>
import toastr from 'toastr';
import {mapGetters, mapActions} from 'vuex';
import helper from '../helper';

export default {
    setup() {
        // const router = useRouter();

        
        // const submit = () => {
        //     console.log(questions);
        //     toastr.success('Data Berhasil disimpan');
        //     router.push('/child-weekly-monitoring-result');
        // };

        // const addQuestion = () => {
        //     questions.push({ text: 'Pertanyaan Baru', type: 'choice', answer: '' });
        // };

        // const gotoHome = () => {
        //     router.push({
        //         name: 'home',
        //         params: {}
        //     });
        // };

        // return {
        //     questions,
        //     submit,
        //     addQuestion,
        //     gotoHome
        // };
    },

    data(){
        return {
            period: null
        }
    },

    methods: {
        ...mapActions([
            'fetchQuestionAnswer'
        ]),

        submit(){
            // console.log(this.questions)
            const url = this.baseUrl + "/api/questions";
                        
            axios.post(url, {
                questions: this.questions
            }).then(res => res.data)
            .then(res => {
                console.log(res);
                toastr.success(res.message);
            }).catch(error => {
                console.log(error);
                helper.renderError(error)
            })
        },

        fetchPeriod(){
            let period_id = this.period_id;

            const url = this.baseUrl + "/api/periods/"+ period_id;
                        
            axios.get(url, {
                // apa aja nih disini;
                params:{}
            }).then(res => res.data)
            .then(res => {
                console.log(res);
                this.period = res.data;
            }).catch(error => {
                console.log(error);
                helper.renderError(error)
            })
        },

        gotoHome(){
            this.$router.push({
                name: 'home',
                params: {}
            });
        }
    },

    computed: {
        ...mapGetters([
            'questions', 'baseUrl'
        ]),

        periodName(){
            if(this.period) {
                return this.period.period_name;
            }

            return null;
        },

        child_id(){
            return this.$route.query.child_id;
        },

        period_id() {
            return this.$route.query.period_id;
        }

    },

    mounted(){
        let child_id = this.child_id;
        let period_id = this.period_id;

        this.fetchQuestionAnswer({period_id})
        this.fetchPeriod();

    }
}
</script>
