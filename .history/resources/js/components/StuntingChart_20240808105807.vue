<template>
    <Line :data="data" :options="options" />
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
  import { Line } from 'vue-chartjs'
  import * as chartConfig from '../chartConfig.js'
  import { useStore } from 'vuex';
import { useRouter } from 'vue-router';
  
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
    setup(){
      const store = useStore();
      const router = useRouter();

      return{
        store,
        router
      }
    },
    mounted() {
      this.getChildDevelopmentHistory();
    },
    computed: {
      getBaseUrl(){
        return store.getters.baseUrl
      }
    },
    data() {
      return chartConfig
    },
    methods: {
      async getChildDevelopmentHistory(){
        try {
            console.log(window.location.origin);
            const response = await axios.get(window.location.origin+`/stunting-analysis`);
            console.log("test")
            console.log(response.data);
        } catch (error) {
            console.error('Error fetching kelurahan:', error);
        }
      }
    }
  }
  </script>  