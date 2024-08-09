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
        const response = await axios.get(url); // Replace with your API URL
        if (response.data && response.data.success) {
          this.data = response.data.data; // Update with API response data
          this.stuntingData = "asaos"; // Update based on your logic
        } else {
          console.warn("API response does not contain expected success flag or data.");
        }
      } catch (error) {
        console.error("An error occurred while fetching data:", error);
      }

        // await axios.get(url)
        //   .then(response => {
        //     console.log(response)
        //     if(response.success) {
        //       this.data = response.data;
        //       this.stuntingData = "asaos"
        //     }
        //   })
        //   .catch(error => {
        //     console.error(error);
        //   });
      },
    },
  };
  </script>