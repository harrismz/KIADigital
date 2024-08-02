<template>
    <div class="p-4">
        <h1 class="text-2xl font-bold mb-4">Grafik Evaluasi Kehamilan</h1>
        <PregnancyChart />
    </div>
</template>

<script>
import PregnancyChart from '../utils/PregnancyChart.vue';

export default {
    name: 'PregnancyEvaluation',
    components: {
        PregnancyChart
    }
};
</script>

<style scoped></style>
