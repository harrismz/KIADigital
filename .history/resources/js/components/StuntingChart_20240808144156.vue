<template>
    
    <div>
      <div style="height: 200px;">
        <Line :data="chartData" :options="chartOptions"/>
      </div>
      {{ data }}
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
        // chartData: {
        //   labels: [],
        //   datasets: [
        //     {
        //       label: 'Data One',
        //       data: [40, 39, 10, 40, 39, 80, 40],
        //       tension: 0.2,
        //       borderColor: 'rgb(75, 192, 192)',
        //     }
        //   ]
        // }
        chartData: {
          labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
          datasets: [
            
          ]
        }
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
      this.fetchInformation();
    },

    methods: {
      async fetchInformation() {
        // TODO : get child id
        const url = this.baseUrl + '/api/stunting-analysis/';

        try {
          const response = await axios.get(url); 
          if (response.data && response.data.success) {
            this.data = response.data.data;

            const uniqueCreatedAt = [...new Set(this.data.map((item: { created_at: any; }) => item.created_at))];
            console.log({uniqueCreatedAt});
            const labels = this.data.map((item: { created_at: any; }) => item.created_at);
            const stuntingCount = this.data.map((item: { status_lhfa: string; }) => item.status_lhfa);
            console.log({labels, stuntingCount});

            this.chartData = {
              labels: labels,
              datasets: [
                {
                  label: 'Data One',
                  backgroundColor: '#f87979',
                  data: [40, 3]
                }
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