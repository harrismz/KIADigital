<template>
    <div class="max-w-3xl mx-auto p-4">
        <div class="mb-6">
            <div class="grid grid-cols-2 gap-4">
                <h1 class="text-2xl font-bold">Dairy Ibu Hamil - Week 3</h1>
                <div class="flex justify-end">
                    <img class="w-6 h-6" @click="editAnswer" :src="'storage/images/edit.png'"></img>
                </div>
            </div>
        </div>


        <!-- Daftar Pertanyaan -->
        <div v-for="(question, index) in questions" :key="index" class="bg-gray-100 p-4 rounded-lg mb-4">
            <div v-if="question.type == 'text'">
                <p class="mb-2">{{ index + 1 }}. {{ question.text }}</p>
                <p class="text-justify font-medium italic">{{ question.answer }}</p>
            </div>
            <div v-else>
                <p class="mb-2">{{ index + 1 }}. {{ question.text }} <strong>{{ question.answer }}</strong></p>

            </div>
        </div>
    </div>
</template>

<script>
import { useRouter } from 'vue-router';
// const router = useRouter();
export default {
    data() {
        return {
            questions: [
                { text: 'Demam Lebih dari Dua Hari?', type: 'choice', answer: 'YA' }, //sepertinya perlu nambahin type answer untuk question
                { text: 'Pusing/Sakit Kepala Berat?', type: 'choice', answer: 'YA' },
                { text: 'Sulit Tidur / Cemas Berlebih?', type: 'choice', answer: 'TIDAK' },
                { text: 'Keluhan/Gejala Lainnya', type: 'text', answer: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec cursus malesuada ultrices. Quisque in lobortis justo. Morbi placerat eget erat eu maximus. Nullam in dapibus est. Fusce vel maximus tortor. Fusce a eros erat. Curabitur posuere tellus id nisl vulputate, ut tristique orci fringilla. Suspendisse a orci eget tellus tincidunt pulvinar. Morbi dignissim, arcu at elementum porttitor, nunc risus pulvinar erat, aliquet dictum risus nunc ut lorem. Cras id scelerisque dui, et pharetra quam. Integer placerat tincidunt leo non viverra. Donec consequat nibh venenatis, pellentesque arcu id, eleifend turpis. In hac habitasse platea dictumst. Nunc vel urna nec tellus fermentum congue. Curabitur laoreet vitae leo eget rutrum. Proin a posuere turpis.' },
            ]
        }
    },
    methods: {
        editAnswer() {
            this.$router.push({
                name: 'weekly-monitoring-answer',
                params: {}
            });
        }
        // // submit() {
        // //     console.log(this.questions);
        // //     alert('Data berhasil disimpan!');
        // // },
        // addQuestion() {
        //     this.questions.push({ text: 'Pertanyaan Baru', answer: '' });
        // }
    }
}
</script>
