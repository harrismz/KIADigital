<template>
    <div>
        <!-- Navigation (Week Selector) -->
        <div class="grid grid-cols-6 gap-2 mb-4">
            <button v-for="week in weeks" :key="week" :class="[
                'py-2 px-4 rounded-lg text-center',
                currentWeek === week ? 'bg-gray-400 text-white' : 'bg-gray-200'
            ]" @click="currentWeek = week">
                Minggu ke-{{ week }}
            </button>
        </div>

        <!-- Progress Bar -->
        <div class="relative w-full h-4 bg-gray-200 rounded-full overflow-hidden mb-4">
            <div class="absolute left-0 h-full bg-green-500 rounded-full" :style="{ width: `${progressPercentage}%` }">
            </div>
        </div>

        <div class="flex justify-between text-xs">
            <div>Trimester 1</div>
            <div>Trimester 2</div>
            <div>Trimester 3</div>
        </div>
    </div>
</template>

<script>
import { ref, computed } from 'vue';

export default {
    setup() {
        const lastMenstrualPeriod = new Date('2024-01-01'); // Ganti dengan tanggal haid terakhir yang relevan
        const dueDate = new Date('2024-10-01'); // Ganti dengan tanggal HPL yang relevan
        const today = new Date();

        const totalPregnancyDays = Math.floor((dueDate - lastMenstrualPeriod) / (1000 * 60 * 60 * 24));
        const daysPassed = Math.floor((today - lastMenstrualPeriod) / (1000 * 60 * 60 * 24));

        const progressPercentage = computed(() => {
            return Math.min(100, (daysPassed / totalPregnancyDays) * 100);
        });

        const weeks = [3, 4, 5, 6, 7]; // Sesuaikan dengan daftar minggu yang diinginkan
        const currentWeek = ref(3);

        return {
            weeks,
            currentWeek,
            progressPercentage,
        };
    },
};
</script>

<style scoped>
/* Tambahkan gaya khusus jika diperlukan */
</style>
