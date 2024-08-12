<template>
    <div class="w-full h-screen max-w-4xl mx-auto">
        <!-- Hanya render chart jika chartData sudah siap -->
        <line-chart v-if="chartData" :data="chartData" :options="chartOptions" />
    </div>
</template>

<script>
import { Line } from 'vue-chartjs';
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    LineElement,
    PointElement,
    LinearScale,
    CategoryScale,
} from 'chart.js';
import { ref } from 'vue';
import { data } from 'autoprefixer';

ChartJS.register(Title, Tooltip, Legend, LineElement, PointElement, LinearScale, CategoryScale);


export default {
    name: 'PertumbuhanAnak',
    components: {
        LineChart: Line
    },
    data() {
        return {
            chartData: {
                labels: [],
                datasets: []
            },
            chartOptions: {
                responsive: true,
                maintainAspectRatio: false
            }
        }
    },
    mounted() {
        this.fetchData();
    },
    methods: {
        async fetchData() {
             // TODO : get child id
        const url = this.baseUrl + '/api/stunting-analysis/';
        try{
            const response = await axios.get(url); 
            this.chartData = response.data;
            console.log({response.data});
        }catch(error){
            console.error(error);

        }
    },
},
};


// export default {
//     components: {
//         LineChart: Line,
//     },
//     setup() {
//         // Menggunakan ref untuk chartData
//         const chartData = ref({
//             labels: [],
//             datasets: [],
//         });

//         // Data default atau proses asinkron untuk mendapatkan data bisa dilakukan di sini
//         chartData.value = {
//             labels: ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24'],
//             datasets: [
//                 {
//                     label: 'Z-score +3',
//                     borderColor: '#000000',
//                     data: [54, 58, 61, 64, 66, 68, 70, 72, 74, 76, 78, 80, 82, 83, 85, 86, 87, 88, 89, 90, 91, 92, 92, 93, 94],
//                     fill: false,
//                 },
//                 {
//                     label: 'Z-score +2',
//                     borderColor: '#ff0000',
//                     data: [52, 55, 58, 61, 63, 65, 67, 69, 71, 73, 75, 76, 78, 79, 81, 82, 83, 84, 85, 86, 87, 88, 89, 89, 90],
//                     fill: false,
//                 },
//                 {
//                     label: 'Z-score 0',
//                     borderColor: '#00ff00',
//                     data: [49, 52, 55, 57, 60, 62, 64, 66, 68, 70, 71, 73, 74, 75, 77, 78, 79, 80, 81, 82, 83, 84, 84, 85, 86],
//                     fill: false,
//                 },
//                 {
//                     label: 'Z-score -2',
//                     borderColor: '#ff0000',
//                     data: [45, 48, 50, 53, 55, 57, 59, 61, 62, 64, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 76, 77, 78, 79],
//                     fill: false,
//                 },
//                 {
//                     label: 'Z-score -3',
//                     borderColor: '#000000',
//                     data: [43, 45, 47, 49, 51, 53, 55, 56, 58, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 69, 70, 71, 72, 72, 73],
//                     fill: false,
//                 },
//             ],
//         };

//         const chartOptions = ref({
//             responsive: true,
//             maintainAspectRatio: false,
//             scales: {
//                 x: {
//                     title: {
//                         display: true,
//                         text: 'Age (completed months and years)',
//                     },
//                 },
//                 y: {
//                     title: {
//                         display: true,
//                         text: 'Length (cm)',
//                     },
//                 },
//             },
//         });

//         return {
//             chartData,
//             chartOptions,
//         };
//     },
// };
</script>
