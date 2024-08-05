<template>
  <div class="container mx-auto p-8 bg-white shadow-lg rounded-lg">
    <h1 class="text-3xl font-bold mb-4">{{ childDevelopment.child.child_name }}</h1>
    <p>Created Date: {{ childDevelopment.created_at }}</p>
    <button @click="goBack" class="mt-6 text-blue-500 hover:text-blue-700">Back</button>
  </div>
</template>

<script>
import axios from 'axios';
import {mapGetters, mapActions} from 'vuex';

export default {
  name: 'ChildDevelopment',
  components:{

  },
  data() {
    return {
      childDevelopment: {}
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
    fetchInformation() {
      // TODO : get child id
      let query = this.queryParam;
      let id = query.id;

      const url = this.baseUrl + '/api/child-development-history/' + id;

      axios.get(url)
        .then(response => {
          if(response.success) {
            this.childDevelopment = response.data;
          }
        })
        .catch(error => {
          console.error(error);
        });
    },
    goBack() {
      this.$router.push({ name: 'child-development-list' });
    }
  },
};
</script>
