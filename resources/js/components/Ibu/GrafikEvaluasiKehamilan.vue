<template>
    <div class="p-4">
        <h1 class="text-2xl font-bold mb-4">Grafik Evaluasi Kehamilan</h1>
        <PregnancyChart />
    </div>
    <div class="p-4">
        <h1 class="text-2xl font-bold mb-4">Grafik Peningkatan Berat Badan</h1>
        <WeightChart />
    </div>
</template>

<script>
import PregnancyChart from './PregnancyChart.vue';
import WeightChart from './WheightChart.vue';

export default {
    name: 'PregnancyEvaluation',
    components: {
        PregnancyChart,
        WeightChart
    }
};
</script>

<style scoped></style>
