<template>
    <div class="chart-container">
        <Bar :data="chartData" :options="chartOptions" />
    </div>
</template>

<script>
import { ref } from 'vue';
import { Bar } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js';

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale);

export default {
    name: 'PregnancyChart',
    components: {
        Bar
    },
    setup() {
        const chartData = ref({
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [
                {
                    label: 'Weight Gain (kg)',
                    backgroundColor: '#42A5F5',
                    data: [65, 74, 80, 85, 90, 94, 94, 94, 94, 94, 94, 94]
                }
            ]
        });

        const chartOptions = ref({
            responsive: true,
            maintainAspectRatio: false
        });

        return {
            chartData,
            chartOptions
        };
    }
};
</script>

<style scoped>
.chart-container {
    position: relative;
    height: 400px;
    width: 100%;
}
</style>
