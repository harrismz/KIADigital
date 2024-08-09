<template>
    
    <div class="flex flex-col min-h-24 bg-gray-100 p-6">
      <div class="grid grid-cols-2 gap-4" style="height: 200px">
        <Line :data="chartData" :options="chartOptions"/>
        <!-- <Line :data="malnutritionData" :options="malnutritionOptions"/> -->
      </div>
      <div class="grid grid-cols-2 gap-4" style="height: 200px" >
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
          maintainAspectRatio: false
        },
        malnutritionOptions: {
          responsive: true,
          maintainAspectRatio: false
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
        try {
          const response = await axios.get(url); 
          if (response.data && response.data.success) {
            this.data = response.data.data;

            const uniqueCreatedAt = [...new Set(this.data.map((item: { created_at: any; }) => item.created_at))];

            const stuntingCounts = uniqueCreatedAt.reduce((acc, date) => {
              acc[date] = 0;
              return acc;
            }, {});

            this.data.forEach((item: { created_at: any; status_lhfa: string; }) => {
                const date = item.created_at;
                if (item.status_lhfa === 'Stunting' && stuntingCounts[date] !== undefined) {
                  stuntingCounts[date]++;
                }
              });

            const labels = uniqueCreatedAt;
            const dataValues = uniqueCreatedAt.map(date => stuntingCounts[date]);

            this.chartData = {
              labels: labels,
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
        try {
          const response = await axios.get(url); 
          if (response.data && response.data.success) {
            this.data = response.data.data;

            const uniqueCreatedAt = [...new Set(this.data.map((item: { created_at: any; }) => item.created_at))];
            const labels = uniqueCreatedAt;

            const malnutritionCounts = uniqueCreatedAt.reduce((acc, date) => {
              acc[date] = 0;
              return acc;
            }, {});

            this.data.forEach((item: { created_at: any; status_wfl: string; }) => {
                const date = item.created_at;
                if (item.status_wfl === 'Malnutrition' && malnutritionCounts[date] !== undefined) {
                  malnutritionCounts[date]++;
                }
              });

            const dataValues = uniqueCreatedAt.map(date => malnutritionCounts[date]);

            this.malnutritionData = {
              labels: labels,
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