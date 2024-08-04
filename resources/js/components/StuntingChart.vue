<template>
     <Bar
      id="my-chart-id"
      :options="chartOptions"
      :data="chartData"
    />
  </template>
  
  <script>
  import { Bar } from 'vue-chartjs'
  import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'
  
  ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)
  
  export default {
    name: 'StuntingChart',
    components: {Bar},
    data() {
      return {
        chartData: {
          labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
          datasets: [
            {
              label: 'Persentase Stunting',
              backgroundColor: '#42A5F5',
              data: [40, 20, 12, 39, 10, 40, 39, 80, 40, 70, 90, 60]
            }
          ]
        },
        chartOptions: {
          responsive: true,
          maintainAspectRatio: false
        }
      }
    }
  }
  </script>
  
  <style scoped>
  div {
    position: relative;
    width: 80%;
    height: 400px;
  }
  </style>


  