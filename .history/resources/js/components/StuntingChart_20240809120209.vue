<template>
    
    <div class="flex flex-col min-h-24 bg-gray-100 p-6 rounded-lg">
          <!-- Title and Heading -->
      <div class="mb-4 text-center mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Stunting And Malnutrition Analysis</h1>
        <h2 class="text-xl font-semibold text-red-600">Realtime Data</h2>
      </div>
      <div class="grid grid-cols-2 gap-4 mb-8" style="height: 200px">
        <Line :data="chartData" :options="chartOptions"/>
        <!-- <Line :data="malnutritionData" :options="malnutritionOptions"/> -->
      </div>
      <div class="grid grid-cols-2 gap-4" style="height: 200px">
        <!-- <Line :data="chartData" :options="chartOptions"/> -->
        <Line :data="malnutritionData" :options="malnutritionOptions"/>
      </div>
      <!-- {{ data }} -->
    </div>
  </template>

  <script lang="ts">
  import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend
  } from 'chart.js'

  import {mapGetters, mapActions} from 'vuex';
  import { Line } from 'vue-chartjs'
  import axios from 'axios';
import { data } from 'autoprefixer';

  ChartJS.register(
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend
  )
  export default {
    name: 'StuntingChart',
    components: {
      Line
    },

    data() {
      return {
        data: [],
        chartOptions: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            y: {
              min: 0,
              max: 20
            }
          }
        },
        malnutritionOptions: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            y: {
              min: 0,
              max: 20
            }
          }
        },
        chartData: {
          labels: [],
          datasets: []
        },
        malnutritionData: {
          labels: [],
          datasets: []
        },
      };
    },

    computed: {
      ...mapGetters([
          'baseUrl'
      ]),

      queryParam() {
        return this.$route.query;
      }
    },

    mounted() {
      this.fetchStunting();
      this.fetchMalnutrition();
    },

    methods: {
      async fetchStunting() {
        // TODO : get child id
        const url = this.baseUrl + '/api/stunting-analysis/';
        const currentYear = new Date().getFullYear();

        try {
          const response = await axios.get(url); 
          if (response.data && response.data.success) {
            this.data = response.data.data;

            const uniqueCreatedAt = [...new Set(this.data.map((item: { created_at: any; }) => item.created_at))];

            const filteredData = this.data.filter(item => {
              const tanggal = new Date(item.created_at);
              return tanggal.getFullYear() === currentYear;
            });

            const labels = [...new Set(filteredData.map((item: { created_at: string }) => {
              const date = new Date(item.created_at);
              // Adjust the label format as needed (e.g., 'Jan 2024', '2024-01-01')
              return `${date.getMonth() + 1}/${date.getFullYear()}`;
            }))];

            const sortedLabels = [...new Set(labels)]
            .map(label => {
              const [month, year] = label.split('/').map(Number);
              return new Date(year, month - 1); // Create Date object for sorting
            })
            .sort((a, b) => a - b) // Sort dates in ascending order
            .map(date => `${date.getMonth() + 1}/${date.getFullYear()}`);

            const stuntingCounts = {};

            filteredData.forEach(item => {
              const date = item.created_at.split('T')[0]; // Assuming date format is YYYY-MM-DDTHH:mm:ss
              if (item.status_lhfa === 'Stunting') {
                if (stuntingCounts[date]) {
                  stuntingCounts[date]++;
                } else {
                  stuntingCounts[date] = 1;
                }
              }else{
                if (stuntingCounts[date]) {
                  stuntingCounts[date] = 1;
                }
              }
            });

            const dataValues = uniqueCreatedAt.map(date => stuntingCounts[date]);

            this.chartData = {
              labels: sortedLabels,
              datasets: [
                {
                  label: 'Stunting Count',
                  borderColor: 'rgb(75, 192, 192)',
                  data: dataValues
                },
              ]
            }
          } else {
            console.error("Failed to fetch data");
          }
        } catch (error) {
          console.error("An error occurred while fetching data:", error);
        }
      },
      async fetchMalnutrition() {
        // TODO : get child id
        const url = this.baseUrl + '/api/stunting-analysis/';
        const currentYear = new Date().getFullYear();
        try {
          const response = await axios.get(url); 
          if (response.data && response.data.success) {
            this.data = response.data.data;

            const uniqueCreatedAt = [...new Set(this.data.map((item: { created_at: any; }) => item.created_at))];

            const filteredData = this.data.filter(item => {
              const tanggal = new Date(item.created_at);
              return tanggal.getFullYear() === currentYear;
            });
            
            const labels = [...new Set(filteredData.map((item: { created_at: string }) => {
              const date = new Date(item.created_at);
              // Adjust the label format as needed (e.g., 'Jan 2024', '2024-01-01')
              return `${date.getMonth() + 1}/${date.getFullYear()}`;
            }))];

            const sortedLabels = [...new Set(labels)]
            .map(label => {
              const [month, year] = label.split('/').map(Number);
              return new Date(year, month - 1); // Create Date object for sorting
            })
            .sort((a, b) => a - b) // Sort dates in ascending order
            .map(date => `${date.getMonth() + 1}/${date.getFullYear()}`);

            const malnutritionCounts = {};

            filteredData.forEach(item => {
              const date = item.created_at.split('T')[0]; // Assuming date format is YYYY-MM-DDTHH:mm:ss
              if (item.status_wfl === 'Malnutrition') {
                if (malnutritionCounts[date]) {
                  malnutritionCounts[date]++;
                } else {
                  malnutritionCounts[date] = 1;
                }
              }
            });

            const dataValues = uniqueCreatedAt.map(date => malnutritionCounts[date]);

            this.malnutritionData = {
              labels: sortedLabels,
              datasets: [
                {
                  label: "Malnutrition Count",
                  borderColor: 'rgb(75, 192, 192)',
                  data: dataValues
                },
              ]
            }
          } else {
            console.error("Failed to fetch data");
          }
        } catch (error) {
          console.error("An error occurred while fetching data:", error);
        }
      },
    },
  };
  </script>