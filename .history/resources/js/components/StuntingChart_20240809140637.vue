<template>
    
  <div class="container mx-auto bg-gray-100 p-4 rounded-lg">
    <h1 class="text-2xl font-bold text-blue-500 text-center">Stunting Chart Analysis</h1>
    <p class="mt-4 text-gray-500 text-xs">
      Grafik ini bertujuan untuk memberikan wawasan yang jelas tentang jumlah kasus stunting serta gizi buruk di Indonesia secara real-time.
    </p>
    
    <div class="flex flex-col md:flex-row gap-4 mt-4">
      <div class="flex-1 rounded-lg shadow-md bg-white p-4 hover:scale-[1.01] transition duration-300 cursor-pointer hover:bg-gray-200">
        <Line :data="chartData" :options="chartOptions"/>
      </div>
      <div class="flex-1 rounded-lg shadow-md bg-white p-4 hover:scale-[1.01] transition duration-300 cursor-pointer hover:bg-gray-200">
        <h3 class="text-md font-bold text-gray-500">Deskripsi</h3>
        <p class="text-xs">
          Grafik ini menampilkan data tentang prevalensi stunting pada anak-anak usia 0-5 tahun di berbagai provinsi di Indonesia untuk tahun 2023. Stunting, atau kekerdilan, adalah kondisi di mana anak-anak memiliki tinggi badan yang kurang dari standar pertumbuhan yang diharapkan karena kekurangan nutrisi kronis, infeksi berulang, atau faktor-faktor lain selama periode perkembangan kritis.
        </p>
      </div>
    </div>

    <div class="flex flex-col md:flex-row gap-4 mt-4">
      <div class="flex-1 rounded-lg shadow-md bg-white p-4 hover:scale-[1.01] transition duration-300 cursor-pointer hover:bg-gray-200">
        <Line :data="malnutritionData" :options="malnutritionOptions"/>
      </div>
      <div class="flex-1 rounded-lg shadow-md bg-white p-4 hover:scale-[1.01] transition duration-300 cursor-pointer hover:bg-gray-200">
        <h3 class="text-md font-bold text-gray-500">Deskripsi</h3>
        <p class="text-xs">
          Grafik ini menampilkan data tentang prevalensi stunting pada anak-anak usia 0-5 tahun di berbagai provinsi di Indonesia untuk tahun 2023. Stunting, atau kekerdilan, adalah kondisi di mana anak-anak memiliki tinggi badan yang kurang dari standar pertumbuhan yang diharapkan karena kekurangan nutrisi kronis, infeksi berulang, atau faktor-faktor lain selama periode perkembangan kritis.
        </p>
      </div>
    </div>
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
        const allDates = new Set();

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
              // Adjust label format
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
              const date = item.created_at.split('T')[0];
              allDates.add(date);
            });

            allDates.forEach(date => {
              stuntingCounts[date] = 0;
            });

            filteredData.forEach(item => {
              const date = item.created_at.split('T')[0];
              if (item.status_lhfa === 'Stunting') {
                if (stuntingCounts[date]) {
                  stuntingCounts[date]++;
                } else {
                  stuntingCounts[date] = 1;
                }
              }
            });

            const dataValues = uniqueCreatedAt
                .map(date => stuntingCounts[date])
                .filter(value => value !== undefined);

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
        const allDates = new Set();
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
              // Adjust label format
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
              const date = item.created_at.split('T')[0];
              allDates.add(date);
            });

            allDates.forEach(date => {
              malnutritionCounts[date] = 0;
            });

            filteredData.forEach(item => {
              const date = item.created_at.split('T')[0];
              if (item.status_wfl === 'Malnutrition') {
                if (malnutritionCounts[date]) {
                  malnutritionCounts[date]++;
                } else {
                  malnutritionCounts[date] = 1;
                }
              }
            });

            const dataValues = uniqueCreatedAt.map(date => malnutritionCounts[date]).filter(value => value !== undefined);

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