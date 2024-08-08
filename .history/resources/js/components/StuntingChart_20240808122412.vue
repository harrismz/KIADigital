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
      return chartConfig;
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
      fetchInformation() {
        // TODO : get child id
        const url = this.baseUrl + '/api/stunting-analysis/';

        axios.get(url)
          .then(response => {
            console.log(response)
            if(response.success) {
              this.childDevelopment = response.data;
            }
          })
          .catch(error => {
            console.error(error);
          });
      },
    },
  };

  // export default {
  //   name: 'StuntingChart',
  //   components: {
  //     Line
  //   },
  //   setup(){
  //     const store = useStore();
  //     const router = useRouter();

  //     return{
  //       store,
  //       router
  //     }
  //   },
  //   mounted() {
  //     this.getChildDevelopmentHistory();
  //   },
  //   computed: {
  //     getBaseUrl(){
  //       return this.store.getters.baseUrl
  //     }
  //   },
  //   data() {
  //     return chartConfig
  //   },
  //   methods: {
  //     async getChildDevelopmentHistory(){
  //       try {
  //           const response = await axios.get(`${this.baseUrl}/api/stunting-analysis`);
  //           console.log(response.data);
  //           console.log(this.baseUrl);
  //       } catch (error) {
  //           console.error('Error fetching kelurahan:', error);
  //       }
  //     }
  //   }
  // }
  </script>