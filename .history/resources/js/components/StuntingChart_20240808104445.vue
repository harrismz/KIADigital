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
    mounted() {
      this.getChildDevelopmentHistory();
    },
    data() {
      return chartConfig
    },
    methods: {
      getChildDevelopmentHistory(){
        try {
            console.log(window.location.origin);
            const response =  axios.get(`${baseUrl.value}/stunting-analysis`);
            console.log("test")
            console.log({ response });
        } catch (error) {
            console.error('Error fetching kelurahan:', error);
        }
      }
    }
  }
  </script>  