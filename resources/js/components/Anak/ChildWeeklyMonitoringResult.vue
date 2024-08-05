<template>
    <div class="max-w-3xl mx-auto p-4">
        <div class="mb-6">
            <div class="grid grid-cols-2 grid-rows-2 gap-4">
                <h1 class="text-2xl font-bold">Dairy Anak - 1 Bulan</h1>
                <div class="flex justify-end gap-x-3 row-span-2">
                    <img class="w-6 h-6" @click="gotoDashboardAnak" :src="'storage/images/home.png'"></img>
                    <img class="w-6 h-6" @click="editAnswer" :src="'storage/images/edit.png'"></img>
                </div>
                <p>Pemantauan Perkembangan Anak</p>

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
import { ref } from 'vue';

export default {
    setup() {
        const router = useRouter();
        const questions = ref([
            {
                text: 'Bayi bisa mengangkat kepala mandiri hingga setinggi 45 derajat ?',
                type: 'choice',
                answer: 'TIDAK'
            },
            {
                text: 'Bayi bisa menggerakan kepala dari kiri / kanan ke tengah ?',
                type: 'choice',
                answer: 'YA'
            },
            {
                text: 'Bayi  bisa melihat dan menatap wajah anda ?',
                type: 'choice',
                answer: 'YA'
            },
            {
                text: 'Bayi bisa mengoceh spontant atau bereaksi dengan mengoceh ?',
                type: 'choice',
                answer: 'Tidak'
            }
        ]);

        const editAnswer = () => {
            router.push({
                name: 'child-weekly-monitoring-answer',
                params: {}
            });
        };

        const gotoDashboardAnak = () => {
            router.push({
                name: 'dashboard-anak',
                params: {}
            });
        };

        return {
            questions,
            editAnswer,
            gotoDashboardAnak
        };
    }
}
</script>
