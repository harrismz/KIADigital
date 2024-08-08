<template>
    <!-- <Line :data="data" :options="options" /> -->
    <div>
      {{ data }}
      {{ stuntingData }}
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
  import * as chartConfig from '../chartConfig.js'
  import { useStore } from 'vuex';
  import { useRouter } from 'vue-router';
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
        chartConfig,
        data: [],
        stuntingData: "asad",
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