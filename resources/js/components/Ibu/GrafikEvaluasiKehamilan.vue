<template>
    <div class="mb-6">
        <div class="grid grid-cols-2 gap-4">
            <h1 class="text-2xl font-bold">Grafik</h1>
            <div class="flex justify-end gap-x-3">
                <img class="w-6 h-6" @click="gotoHome" :src="'storage/images/home.png'"></img>
            </div>
        </div>
    </div>
    <div class="p-4">
        <h1 class="text-2xl font-bold mb-4">Evaluasi Kehamilan</h1>
        <PregnancyChart />
    </div>
    <div class="p-4">
        <h1 class="text-2xl font-bold mb-4">Peningkatan Berat Badan</h1>
        <WeightChart />
    </div>
</template>

<script>
import PregnancyChart from './PregnancyChart.vue';
import WeightChart from './WheightChart.vue';
import { useRouter } from 'vue-router';

export default {
    name: 'PregnancyEvaluation',
    setup() {
        const router = useRouter();

        const gotoHome = () => {
            router.push('/');
        };

        return {
            gotoHome
        };
    },
    components: {
        PregnancyChart,
        WeightChart
    }
};
</script>

<style scoped></style>
