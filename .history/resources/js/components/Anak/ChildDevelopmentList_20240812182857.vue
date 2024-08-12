<template>
  <div class="container mx-auto p-4">
    <div class="mb-6">
      <div class="grid grid-cols-2 gap-4">
        <h1 class="text-2xl font-bold">Catatan Pertumbuhan Anak</h1>
        <div class="flex justify-end gap-x-3">
          <img class="w-6 h-6 cursor-pointer" @click="gotoHome" :src="`${baseUrl}/storage/images/home.png`" alt="Home">
        </div>
      </div>
    </div>
    <div class="mb-4">
      <input v-model="searchQuery" @input="searchChildDevelopments" type="text" placeholder="Search..."
        class="w-full p-2 border rounded-md" />
    </div>
    <div v-for="childDev in paginatedChildDevelopments" :key="childDev.id" class="bg-white shadow-md rounded-lg p-4 mb-4">
      <div class="flex">
        <div>
          <h2 class="text-xl font-semibold">{{ childDev.child?.child_name }}</h2>
          <div>{{ formatDate(childDev.created_at) }}</div>
          <button @click="viewDetail(childDev.id)" class="mt-2 text-blue-500 hover:text-blue-700">Detail more</button>
        </div>
      </div>
    </div>
    <div class="flex justify-center mt-4">
      <button @click="previousPage" :disabled="currentPage === 1"
        class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50">Previous</button>
      <span class="px-4">{{ currentPage }}</span>
      <button @click="nextPage" :disabled="currentPage === totalPages"
        class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50">Next</button>
    </div>
  </div>
  <div>
    <VCarousel
      hide-delimiter-background
      hide-delimiters
      show-arrows="hover"
      style="margin-top: 20px; margin-left: 20px; margin-right: 20px;">
      <VCarouselItem>
        <div class="chart-container">
          <h1 class="mt-3 text-2xl font-bold text-blue-500 text-center mb-6">Grafik Pertumbuhan</h1>
          <div style="height: 400px;">
            <line-chart v-if="chartData" :data="chartData" :options="chartOptions" />
          </div>
        </div>
      </VCarouselItem>

      <VCarouselItem>
        <div class="chart-container">
          <h1 class="mt-3 text-2xl font-bold text-blue-500 text-center mb-6">Grafik Berat Badan vs Tinggi Badan</h1>
          <div style="height: 400px;">
            <line-chart v-if="weightData" :data="weightData" :options="weightOptions" />
          </div>
        </div>
      </VCarouselItem>

      <VCarouselItem>
        <div class="chart-container">
          <h1 class="mt-3 text-2xl font-bold text-blue-500 text-center mb-6">Grafik Lingkar Kepala</h1>
          <div style="height: 400px;">
            <line-chart v-if="headData" :data="headData" :options="headOptions" />
          </div>
        </div>
      </VCarouselItem>
    </VCarousel>
  </div>
</template>

<script>
import axios from 'axios';
import { mapGetters } from 'vuex';
import { Line } from 'vue-chartjs';
import { VCarousel, VCarouselItem } from 'vuetify/components/VCarousel';
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
ChartJS.register(Title, Tooltip, Legend, LineElement, PointElement, LinearScale, CategoryScale);

export default {
  name: 'ChildDevelopment',
  components: {
    LineChart: Line,
    VCarousel,
    VCarouselItem
  },
  data() {
    return {
      childDevelopment: [],
      searchQuery: '',
      currentPage: 1,
      itemsPerPage: 5,
      totalItems: 0,
      chartData: {
          labels: [],
          datasets: []
      },
      weightData: {
          labels: [],
          datasets: []
      },
      headData: {
          labels: [],
          datasets: []
      },
      chartOptions: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            x: {
                title: {
                    display: true,
                    text: 'Age',
                },
            },
            y: {
                title: {
                    display: true,
                    text: 'Length (cm)',
                },
            }
          }
        },
        weightOptions: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            x: {
                title: {
                    display: true,
                    text: 'Length (cm)',
                },
            },
            y: {
                title: {
                    display: true,
                    text: 'Weight (kg)',
                },
            }
          }
        },
        headOptions: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            x: {
                title: {
                    display: true,
                    text: 'Age',
                },
            },
            y: {
                title: {
                    display: true,
                    text: 'Lingkar Kepala (cm)',
                },
            }
          }
        }
    };
  },
  computed: {
    ...mapGetters(['baseUrl']),
    paginatedChildDevelopments() {
      const start = (this.currentPage - 1) * this.itemsPerPage;
      const end = start + this.itemsPerPage;
      return this.childDevelopment.slice(start, end);
    },
    totalPages() {
      return Math.ceil(this.totalItems / this.itemsPerPage);
    },
    lineChartStyle() {
      return {
        height: '300px',
        position: 'relative',
      };
    }
  },
  methods: {
    async fetchChildDevelopments() {
      const id = this.$store.state.active_child.id;
      const queryParams = new URLSearchParams({
        page: this.currentPage,
        search: this.searchQuery
      }).toString();

      try {
        console.log(this.baseUrl);
        console.log(id);
        console.log(queryParams);
        console.log(`${this.baseUrl}/api/child-development-history/${id}?${queryParams}`);

        axios.get(`${this.baseUrl}/api/child-development-history/${id}`, {
            headers: {
                'Accept': 'application/json', // Expect a JSON response
                'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
            }
        })
        .then(response => {
            this.childDevelopment = response.data.data;
            this.totalItems = response.data.total;
        })
        .catch(error => {
            console.error('Error fetching child developments:', error);
        });
      } catch (error) {
        console.error('Error fetching child developments:', error);
      }
    },
    searchChildDevelopments() {
      this.currentPage = 1; // Reset to first page on new search
      this.fetchChildDevelopments();
    },
    nextPage() {
      if (this.currentPage < this.totalPages) {
        this.currentPage += 1;
        this.fetchChildDevelopments();
      }
    },
    previousPage() {
      if (this.currentPage > 1) {
        this.currentPage -= 1;
        this.fetchChildDevelopments();
      }
    },
    viewDetail(id) {
      this.$router.push({ name: 'child-development', params: { id } });
    },
    getImageUrl(path) {
      return `${this.baseUrl}/storage/${path}`;
    },
    formatDate(date) {
      const options = { year: 'numeric', month: 'long', day: 'numeric' };
      return new Date(date).toLocaleDateString(undefined, options);
    },
    gotoHome() {
      this.$router.push({ name: 'home' });
    },
    async fetchLenghtData() {
      const id = this.$store.state.active_child.id;
      const response = await fetch(`${this.baseUrl}/api/child-development-history/${id}`);
      const data = await response.json();
      const labels = data.height.map(item => item.month);
      const dob = data.data.map(item => item.child.date_of_birth);
      const created_at = data.data.map(item => item.created_at);

      const age = dob.map((date, index) => {
        const birthDate = new Date(date);
        const currentDate = new Date(created_at[index]);
        const yearDiff = currentDate.getFullYear() - birthDate.getFullYear();
        const monthDiff = currentDate.getMonth() - birthDate.getMonth();
        // Total difference in months
        return yearDiff * 12 + monthDiff;
      });

      // Create a heightData with age and height
      const heightDataMap = data.data.reduce((map, item, index) => {
          const ageValue = age[index];
          map[ageValue] = item.height;
          return map;
      }, {});

      // Prepare the data with labels and heights
      const heightDataset = labels.map(label => {
          const ageValue = parseInt(label, 10); // Assuming labels are in months, convert to integer
          return {
              x: ageValue,
              y: heightDataMap[ageValue] !== undefined ? heightDataMap[ageValue] : 0 // Default to 0 if no match
          };
      });

      console.log(heightDataset);
      
      this.chartData = {
        labels: labels,
        datasets: [
          {
            label: 'Z-score -3',
            data: data.height.map(item => item.sd3neg),
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1,
            pointRadius: 0
          },
          {
            label: 'Z-score -2',
            data: data.height.map(item => item.sd2neg),
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1,
            pointRadius: 0
          },
          {
            label: 'Z-score -1',
            data: data.height.map(item => item.sd1neg),
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1,
            pointRadius: 0
          },
          {
            label: 'Z-score 0',
            data: data.height.map(item => item.sd0),
            backgroundColor: 'rgba(153, 102, 255, 0.2)',
            borderColor: 'rgba(153, 102, 255, 1)',
            borderWidth: 1,
            pointRadius: 0
          },
          {
            label: 'Z-score 1',
            data: data.height.map(item => item.sd1),
            backgroundColor: 'rgba(255, 159, 64, 0.2)',
            borderColor: 'rgba(255, 159, 64, 1)',
            borderWidth: 1,
            pointRadius: 0
          },
          {
            label: 'Z-score 2',
            data: data.height.map(item => item.sd2),
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1,
            pointRadius: 0
          },
          {
            label: 'Z-score 3',
            data: data.height.map(item => item.sd3),
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1,
            pointRadius: 0
          },
          {
            label: 'Child Height',
            data: heightDataset,
            borderColor: 'rgba(150, 150, 150, 1)',
            backgroundColor: 'rgba(150, 150, 1, 1)',
            fill: false,
            borderWidth: 1.5,
            pointRadius: (context) => context.raw.y !== 0 ? 2 : 0, // Only show points where y is not 0
          }
        ]
      }
    },
    async fetchWeightData() {
      const id = this.$store.state.active_child.id;
      const response = await fetch(`${this.baseUrl}/api/child-development-history/${id}`);
      const data = await response.json();
      const labels = data.weight.map(item => item.length);

      const heightToWeightsMap = data.data.reduce((map, item) => {
          if (!map[item.height]) {
              map[item.height] = [];
          }
          map[item.height].push(item.weight);
          return map;
      }, {});

      const weightDataset = data.weight.flatMap(item => {
          const length = item.length;
          const weights = heightToWeightsMap[length] || [0]; 
          return weights.map(weightValue => ({
              x: parseFloat(length, 10),
              y: weightValue
          }));
      });

      console.log(weightDataset);
      
      this.weightData = {
        labels: labels,
        datasets: [
          {
            label: 'Z-score -3',
            data: data.weight.map(item => item.sd3neg),
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1,
            pointRadius: 0
          },
          {
            label: 'Z-score -2',
            data: data.weight.map(item => item.sd2neg),
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1,
            pointRadius: 0
          },
          {
            label: 'Z-score -1',
            data: data.weight.map(item => item.sd1neg),
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1,
            pointRadius: 0
          },
          {
            label: 'Z-score 0',
            data: data.weight.map(item => item.sd0),
            backgroundColor: 'rgba(153, 102, 255, 0.2)',
            borderColor: 'rgba(153, 102, 255, 1)',
            borderWidth: 1,
            pointRadius: 0
          },
          {
            label: 'Z-score 1',
            data: data.weight.map(item => item.sd1),
            backgroundColor: 'rgba(255, 159, 64, 0.2)',
            borderColor: 'rgba(255, 159, 64, 1)',
            borderWidth: 1,
            pointRadius: 0
          },
          {
            label: 'Z-score 2',
            data: data.weight.map(item => item.sd2),
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1,
            pointRadius: 0
          },
          {
            label: 'Z-score 3',
            data: data.weight.map(item => item.sd3),
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1,
            pointRadius: 0
          },
          {
            label: 'Child Height',
            data: weightDataset,
            borderColor: 'rgba(150, 150, 150, 1)',
            backgroundColor: 'rgba(150, 150, 1, 1)',
            fill: false,
            borderWidth: 1.5,
            pointRadius: (context) => context.raw.y !== 0 ? 2 : 0, // Only show points where y is not 0
          }
        ]
      }
    },
    async fetchHeadData() {
      const id = this.$store.state.active_child.id;
      const response = await fetch(`${this.baseUrl}/api/child-development-history/${id}`);
      const data = await response.json();
      const labels = data.head.map(item => item.month);
      const dob = data.data.map(item => item.child.date_of_birth);
      const created_at = data.data.map(item => item.created_at);

      const age = dob.map((date, index) => {
        const birthDate = new Date(date);
        const currentDate = new Date(created_at[index]);
        const yearDiff = currentDate.getFullYear() - birthDate.getFullYear();
        const monthDiff = currentDate.getMonth() - birthDate.getMonth();
        // Total difference in months
        return yearDiff * 12 + monthDiff;
      });

      // Create a heightData with age and height
      const headDataMap = data.data.reduce((map, item, index) => {
          const ageValue = age[index];
          map[ageValue] = item.head_circumference;
          return map;
      }, {});

      // Prepare the data with labels and heights
      const headDataset = labels.map(label => {
          const ageValue = parseInt(label, 10); // Assuming labels are in months, convert to integer
          return {
              x: ageValue,
              y: headDataMap[ageValue] !== undefined ? headDataMap[ageValue] : 0 // Default to 0 if no match
          };
      });

      console.log(headDataset);
      
      this.headData = {
        labels: labels,
        datasets: [
          {
            label: 'Z-score -3',
            data: data.head.map(item => item.sd3neg),
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1,
            pointRadius: 0
          },
          {
            label: 'Z-score -2',
            data: data.head.map(item => item.sd2neg),
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1,
            pointRadius: 0
          },
          {
            label: 'Z-score -1',
            data: data.head.map(item => item.sd1neg),
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1,
            pointRadius: 0
          },
          {
            label: 'Z-score 0',
            data: data.head.map(item => item.sd0),
            backgroundColor: 'rgba(153, 102, 255, 0.2)',
            borderColor: 'rgba(153, 102, 255, 1)',
            borderWidth: 1,
            pointRadius: 0
          },
          {
            label: 'Z-score 1',
            data: data.head.map(item => item.sd1),
            backgroundColor: 'rgba(255, 159, 64, 0.2)',
            borderColor: 'rgba(255, 159, 64, 1)',
            borderWidth: 1,
            pointRadius: 0
          },
          {
            label: 'Z-score 2',
            data: data.head.map(item => item.sd2),
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1,
            pointRadius: 0
          },
          {
            label: 'Z-score 3',
            data: data.head.map(item => item.sd3),
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1,
            pointRadius: 0
          },
          {
            label: 'Child Height',
            data: headDataset,
            borderColor: 'rgba(150, 150, 150, 1)',
            backgroundColor: 'rgba(150, 150, 1, 1)',
            fill: false,
            borderWidth: 1.5,
            pointRadius: (context) => context.raw.y !== 0 ? 2 : 0, // Only show points where y is not 0
          }
        ]
      }
    }
    
  },
  created() {
    this.fetchChildDevelopments();
    this.fetchLenghtData();
    this.fetchWeightData();
    this.fetchHeadData();
  }
};
</script>
<style scoped>
.chart-container {
  background-color: white;
  padding: 20px;
  margin-left: 20px;
  margin-right: 20px;
  border-radius: 10px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}
</style>
