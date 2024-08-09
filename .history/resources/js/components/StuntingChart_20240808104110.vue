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
    data() {
      return chartConfig
    },
    methods: {
      getChildDevelopmentHistory(){
        try {
            const response = await axios.get(`${baseUrl.value}/stunting-analysis`);
            kelurahanList.value = response.data;
            console.log({ kelurahanList });
        } catch (error) {
            console.error('Error fetching kelurahan:', error);
        }
      }
    }
  }
  </script>  