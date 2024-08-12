<template>
    <div class="max-w-3xl mx-auto p-4">
        <h2 class="text-2xl font-bold mb-6">PROFILE</h2>

        <div class="my-2">
            <div class="mb-6">
                <div class="grid grid-cols-2 gap-4">
                    <h1 class="text-xl font-bold">Edit Identitas {{ }}</h1>
                    <div class="flex justify-end gap-x-3">
                        <img class="w-5 h-5 cursor-pointer" @click="redBack"
                            :src="`${baseUrl}/storage/images/home.png`">
                    </div>
                </div>
            </div>

            <form @submit.prevent="submit">

                <my-input :isRequired="value.isRequired" :inputType="value.inputType ? value.inputType : 'text'"
                    v-model="form[key]" :key="key" :inputKey="key" v-for="(value, key) in inputs"></my-input>

                <div class="mb-4">
                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                    <input type="date" name="date_of_birth" id="date_of_birth" v-model="form.date_of_birth"
                        class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <combo v-model="form[key]" :inputKey="key" :key="val.label" :url="val.url" :label="val.label"
                    v-for="(val, key) in combos" />

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

            <!-- Daftar Pertanyaan -->
            <!-- <div v-for="(question, index) in questions" :key="index" class="bg-gray-100 p-4 rounded-lg mb-4">
                <p class="mb-2">{{ index + 1 }}. {{ question.text }}</p>

                <!-- Opsi Pilihan --
                <div v-if="question.type === 'choice'" class="mb-4">
                    <label class="inline-flex items-center">
                        <input type="radio" :name="'question-' + index" value="Ya" class="form-radio text-indigo-600">
                        <span class="ml-2">Ya</span>
                    </label>
                    <label class="inline-flex items-center ml-6">
                        <input type="radio" :name="'question-' + index" value="Tidak"
                            class="form-radio text-indigo-600">
                        <span class="ml-2">Tidak</span>
                    </label>
                </div>

                <!-- Input Text --
                <div v-else-if="question.type === 'text'" class="mb-4">
                    <textarea v-model="question.answer" class="w-full border-gray-300 rounded-lg shadow-sm" rows="3"
                        placeholder="Tulis keluhan atau gejala lainnya di sini..."></textarea>
                </div>
            </div> -->

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
    </div>
</template>

<script>
import { mapGetters } from 'vuex';
import toastr from 'toastr';
import MyInput from '../utils/MyInput.vue';
import Combo from '../utils/combo.vue';

export default {
    name: 'UpdateProfile',
    data() {
        return {
            identitas: []
        };
    },
    computed: {
        ...mapGetters(['baseUrl', 'mom']),
        id() {
            return this.$route.params.id;
        },
        modelname() {
            return this.$route.params.modelname;
        }
    },
    mounted() {
        this.fetchIdentitas()
    },
    methods: {
        fetchIdentitas() {
            const url = `${this.baseUrl}/api/${this.modelname}/${this.id}`
            axios.get(url)
                .then(response => response.data)
                .then(response => {
                    this.identitas = response;
                    console.log("get Identity => ", this.identitas);
                })
        },


        redBack() {
            this.$router.go(-1);
        },


        // submit() {
        //     console.log(questions);
        //     toastr.success('Data Berhasil disimpan');
        //     router.push('/weekly-monitoring-result');
        // },

        // addQuestion() {
        //     questions.push({ text: 'Pertanyaan Baru', type: 'choice', answer: '' });
        // },


        // handleWeekUpdate(newWeek) {
        //     this.currentWeek = newWeek;
        //     // console.log('Minggu saat ini berubah menjadi:', newWeek);
        // },

    }
}
</script>
